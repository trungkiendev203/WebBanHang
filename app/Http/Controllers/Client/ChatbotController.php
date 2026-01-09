<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class ChatbotController extends Controller
{
    /**
     * Collation dùng cho LIKE (để match tốt hơn giữa không dấu/có dấu).
     * Nếu MySQL 8+ bạn có thể đổi sang: utf8mb4_0900_ai_ci
     */
    private string $searchCollation = 'utf8mb4_unicode_ci';

    /**
     * Special phrases (ASCII) cần giữ nguyên, không tách.
     * key = ASCII phrase để detect, value = dạng có dấu (để match tốt hơn nếu DB/Collation không AI)
     */
    private array $specialPhrases = [
        'co duc roi'  => 'có đức rời',
        'duc roi'     => 'đức rời',
        'co vien roi' => 'có viền rời',
        'vien roi'    => 'viền rời',
        'tay dai'     => 'tay dài',
        'tay ngan'    => 'tay ngắn',
        'dang ngan'   => 'dáng ngắn',
        'dang dai'    => 'dáng dài',
        'vai ngang'   => 'vai ngang',
        'co tron'     => 'cổ tròn',
        'co chu v'    => 'cổ chữ v',
    ];

    /**
     * Synonyms map (ASCII): base => list variants (ASCII)
     */
    private array $synonyms = [
        'ao so mi'   => ['ao so mi', 'somi', 'ao cong so'],
        'vay'        => ['vay', 'chan vay'],
        'quan jean'  => ['quan jean', 'jean', 'quan bo'],
        'dam'        => ['dam', 'vay lien', 'dam lien'],
        'den'        => ['den', 'mau den', 'black'],
        'trang'      => ['trang', 'mau trang', 'white'],
        'do'         => ['do', 'mau do', 'red'], // đừng để "do" trong stopWords (sẽ mất màu đỏ)
    ];

    private array $stopWords = [
        // ASCII stopwords
        'toi','muon','can','tim','mua','co','duoc','cho','cua','va','la','mot','cac',
        'nay','the','nao','khong','ban','em','anh','chi','oi','gi','voi','nhe',
        'chiec','cai','mau','sp','san','pham','loai','size','shop','store',
        // note: KHÔNG có 'do' để còn match màu đỏ
    ];

    public function suggest(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'message' => 'required|string|max:300',
            ]);

            $rawMessage   = trim((string) $request->input('message', ''));
            $lowerMessage = mb_strtolower($rawMessage, 'UTF-8');

            Log::info('💬 User query:', ['message' => $rawMessage]);

            // 1) Greeting
            if ($this->isGreeting($lowerMessage)) {
                return response()->json([
                    'text' => 'Xin chào! 👋 Tôi là trợ lý Sweetie. Bạn mô tả sản phẩm giúp mình nha, ví dụ: "áo sơ mi trắng tay dài", "đầm đen dự tiệc", "chân váy"...',
                    'products' => [],
                ]);
            }

            // 2) Direct search (nhanh, không gọi AI)
            $directResults = $this->directSearch($rawMessage);
            if ($directResults->isNotEmpty()) {
                return response()->json([
                    'text' => $this->generateResponse($rawMessage, $directResults->count()),
                    'products' => $this->formatProducts($directResults),
                ]);
            }

            // 3) AI analyze
            $aiData = $this->callOpenAI($rawMessage);

            if (!$aiData || !is_array($aiData)) {
                return $this->showSuggestions('Mình chưa hiểu rõ ý bạn. Gợi ý một số mẫu đang hot:');
            }

            // không phải tìm sản phẩm
            if (($aiData['intent'] ?? '') !== 'product_search') {
                return response()->json([
                    'text' => (string)($aiData['response_text'] ?? 'Bạn muốn tìm sản phẩm gì? Hãy mô tả cụ thể hơn nhé!'),
                    'products' => [],
                ]);
            }

            // 4) AI search scoring
            $aiResults = $this->aiSearchWithScoring($aiData);
            if ($aiResults->isEmpty()) {
                // gợi ý theo ngữ cảnh AI (đỡ “lung tung”)
                [$hintTermsA, $categoryA] = $this->buildHintsFromAiData($aiData);
                return $this->showSuggestions('Không tìm thấy sản phẩm chính xác. Gợi ý cho bạn:', $hintTermsA, $categoryA);
            }

            return response()->json([
                'text' => $this->generateResponse($rawMessage, $aiResults->count()),
                'products' => $this->formatProducts($aiResults),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'text' => $e->validator->errors()->first('message') ?: 'Tin nhắn không hợp lệ.',
                'products' => [],
            ], 422);

        } catch (\Throwable $e) {
            Log::error('❌ Chatbot error:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'text' => 'Xin lỗi, có lỗi xảy ra. Vui lòng thử lại.',
                'products' => [],
            ], 500);
        }
    }

    /**
     * Direct search: normalize ASCII + giữ special phrases, giới hạn candidates để tránh query nặng.
     */
    private function directSearch(string $rawMessage): Collection
    {
        $lower = mb_strtolower(trim($rawMessage), 'UTF-8');
        $ascii = $this->toAscii($lower);

        // detect special phrases (ASCII) + bản có dấu
        $phrasePairs = $this->extractSpecialPhrasesPairs($ascii); // [asciiPhrase => accentedPhrase]
        $phraseAscii = array_keys($phrasePairs);

        // expand synonyms trên ASCII
        $expanded = $this->expandSynonyms($ascii);

        // extract keywords (ASCII)
        $keywords = $this->extractKeywords($expanded, $phraseAscii);

        $termsAscii = array_values(array_unique(array_merge($phraseAscii, $keywords)));
        if (empty($termsAscii)) return collect();

        // ✅ core query để bonus match (fix case: "tôi cần tìm 1 chiếc chân váy")
        // trước đây ascii full câu chứa stopword nên không match tên sản phẩm
        $coreAscii = trim(implode(' ', $termsAscii)); // ví dụ: "chan vay"

        Log::info('🔍 Direct search preprocessed:', [
            'raw' => $rawMessage,
            'ascii' => $ascii,
            'coreAscii' => $coreAscii,
            'phrases' => $phrasePairs,
            'keywords' => $keywords,
        ]);

        $candidates = Product::query()
            ->where('status_product', 1)
            ->where(function ($q) use ($lower, $termsAscii, $phrasePairs) {
                // exact match tên (có dấu)
                $q->orWhereRaw('LOWER(name_product) = ?', [$lower]);

                foreach ($termsAscii as $t) {
                    $this->orWhereLikeAi($q, 'name_product', $t);
                    $this->orWhereLikeAi($q, 'describe_product', $t);
                }

                // thêm match theo bản có dấu cho special phrases
                foreach ($phrasePairs as $asciiPhrase => $accentedPhrase) {
                    $term = mb_strtolower($accentedPhrase, 'UTF-8');
                    $this->orWhereLikeAi($q, 'name_product', $term);
                    $this->orWhereLikeAi($q, 'describe_product', $term);
                }
            })
            ->select([
                'id_product', 'name_product', 'price_product', 'image', 'slug_product',
                'view_product', 'describe_product'
            ])
            ->limit(120)
            ->get();

        if ($candidates->isEmpty()) return collect();

        $scored = $candidates->map(function ($p) use ($lower, $phrasePairs, $termsAscii, $coreAscii) {
            $nameLower = mb_strtolower((string)$p->name_product, 'UTF-8');
            $nameAscii = $this->toAscii($nameLower);

            $descLower = mb_strtolower((string)($p->describe_product ?? ''), 'UTF-8');
            $descAscii = $this->toAscii($descLower);

            $score = 0;

            if ($nameLower === $lower) {
                $score = 100;
            } else {
                // Special phrases: +30
                foreach (array_keys($phrasePairs) as $ph) {
                    if (str_contains($nameAscii, $ph) || str_contains($descAscii, $ph)) {
                        $score += 30;
                    }
                }

                // Terms: +10 trong tên, +5 trong mô tả
                foreach ($termsAscii as $t) {
                    if (str_contains($nameAscii, $t)) $score += 10;
                    elseif (str_contains($descAscii, $t)) $score += 5;
                }

                // ✅ Bonus match core terms liền nhau (ví dụ "chan vay" nằm trong "chan vay luoi ...")
                if ($coreAscii !== '' && str_contains($nameAscii, $coreAscii)) {
                    $score += 20;
                }
            }

            $p->relevance_score = $score;
            return $p;
        });

        return $scored
            ->filter(fn($p) => ($p->relevance_score ?? 0) >= 30)
            ->sort(function ($a, $b) {
                return [$b->relevance_score, (int)$b->view_product] <=> [$a->relevance_score, (int)$a->view_product];
            })
            ->take(5)
            ->values();
    }

    /**
     * AI Search with scoring
     */
    private function aiSearchWithScoring(array $aiData): Collection
    {
        $keywords       = (array)($aiData['keywords'] ?? []);
        $specialPhrases = (array)($aiData['special_phrases'] ?? []);
        $category       = $aiData['category'] ?? null;
        $colors         = (array)($aiData['colors'] ?? []);
        $attributes     = (array)($aiData['attributes'] ?? []);

        $keywordsA       = $this->normalizeArrayToAscii($keywords);
        $specialPhrasesA = $this->normalizeArrayToAscii($specialPhrases);
        $colorsA         = $this->normalizeArrayToAscii($colors);
        $attributesA     = $this->normalizeArrayToAscii($attributes);
        $categoryA       = $category ? $this->toAscii(mb_strtolower((string)$category, 'UTF-8')) : null;

        $allTermsA = array_values(array_unique(array_merge($specialPhrasesA, $keywordsA, $colorsA, $attributesA)));
        if (empty($allTermsA) && !$categoryA) return collect();

        Log::info('🤖 AI extracted:', [
            'keywords' => $keywordsA,
            'special_phrases' => $specialPhrasesA,
            'category' => $categoryA,
            'colors' => $colorsA,
            'attributes' => $attributesA,
        ]);

        $candidates = Product::query()
            ->where('status_product', 1)
            ->with(['category:id_category,name_category'])
            ->where(function ($q) use ($allTermsA) {
                foreach ($allTermsA as $t) {
                    // ✅ đúng biến là $t, KHÔNG phải $accentedPhrase
                    $this->orWhereLikeAi($q, 'name_product', $t);
                    $this->orWhereLikeAi($q, 'describe_product', $t);
                }
            })
            ->select([
                'id_product', 'id_category', 'name_product', 'price_product', 'image',
                'slug_product', 'view_product', 'describe_product'
            ])
            ->limit(150)
            ->get();

        if ($candidates->isEmpty()) return collect();

        $scored = $candidates->map(function ($p) use ($specialPhrasesA, $keywordsA, $colorsA, $attributesA, $categoryA) {
            $nameLower = mb_strtolower((string)$p->name_product, 'UTF-8');
            $nameAscii = $this->toAscii($nameLower);

            $descLower = mb_strtolower((string)($p->describe_product ?? ''), 'UTF-8');
            $descAscii = $this->toAscii($descLower);

            $score = 0;

            // Special phrases: +30
            foreach ($specialPhrasesA as $ph) {
                if ($ph !== '' && (str_contains($nameAscii, $ph) || str_contains($descAscii, $ph))) {
                    $score += 30;
                }
            }

            // Category match: +25 (dùng contains cho linh hoạt)
            if ($categoryA && $p->relationLoaded('category') && $p->category) {
                $catName = $this->toAscii(mb_strtolower((string)$p->category->name_category, 'UTF-8'));
                if (str_contains($catName, $categoryA)) {
                    $score += 25;
                }
            }

            // Colors: +15
            foreach ($colorsA as $c) {
                if ($c !== '' && (str_contains($nameAscii, $c) || str_contains($descAscii, $c))) {
                    $score += 15;
                }
            }

            // Keywords: +10 trong tên, +5 trong mô tả
            foreach ($keywordsA as $k) {
                if ($k === '') continue;
                if (str_contains($nameAscii, $k)) $score += 10;
                elseif (str_contains($descAscii, $k)) $score += 5;
            }

            // Attributes: +10 trong tên, +5 trong mô tả
            foreach ($attributesA as $a) {
                if ($a === '') continue;
                if (str_contains($nameAscii, $a)) $score += 10;
                elseif (str_contains($descAscii, $a)) $score += 5;
            }

            $p->ai_score = $score;
            return $p;
        });

        return $scored
            ->filter(fn($p) => ($p->ai_score ?? 0) >= 30)
            ->sort(function ($a, $b) {
                return [$b->ai_score, (int)$b->view_product] <=> [$a->ai_score, (int)$a->view_product];
            })
            ->take(5)
            ->values();
    } // ✅ đóng hàm ở đây (fix lỗi thiếu })

    /**
     * OpenAI: bắt buộc trả JSON chuẩn nhờ response_format.
     */
    private function callOpenAI(string $message): ?array
    {
        try {
            $apiKey = (string) config('services.openai.key');
            if ($apiKey === '') {
                Log::error('❌ Missing OpenAI key');
                return null;
            }

            $payload = [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => $this->getEnhancedPrompt()],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.1,
                'max_tokens' => 220,
                'response_format' => ['type' => 'json_object'],
            ];

            $response = Http::timeout(15)
                ->withToken($apiKey)
                ->post('https://api.openai.com/v1/chat/completions', $payload);

            if ($response->failed()) {
                Log::error('❌ OpenAI failed:', ['status' => $response->status(), 'body' => $response->body()]);
                return null;
            }

            $content = $response->json('choices.0.message.content');
            if (!is_string($content) || trim($content) === '') return null;

            $data = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
                Log::error('❌ JSON decode failed:', ['content' => $content]);
                return null;
            }

            return $data;

        } catch (\Throwable $e) {
            Log::error('❌ OpenAI exception:', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function getEnhancedPrompt(): string
    {
        $special = implode('", "', array_values($this->specialPhrases));
        return <<<PROMPT
Bạn là AI phân tích tìm kiếm thời trang GMOON. Trả về JSON (KHÔNG giải thích, KHÔNG markdown).

Schema:
{
  "intent": "product_search|greeting|policy",
  "keywords": [],
  "special_phrases": [],
  "category": "đầm|áo|quần|váy|áo khoác|null",
  "colors": [],
  "attributes": [],
  "response_text": ""
}

QUY TẮC:
- Nếu là chào hỏi -> intent="greeting" và response_text ngắn gọn.
- Nếu user hỏi ngoài tìm sản phẩm (chính sách, ship, đổi trả...) -> intent="policy" và response_text trả lời ngắn.
- Nếu tìm sản phẩm -> intent="product_search".
- Special phrases KHÔNG TÁCH (ví dụ): "{$special}".
- keywords: từ khóa mô tả sản phẩm (bỏ "tôi muốn", "cần", "tìm"...).
- category phải đúng: áo ≠ đầm, quần ≠ váy.
- colors: màu chủ đạo.
- attributes: form dáng/kiểu cổ/kiểu tay (tay dài/tay ngắn/dáng ngắn/dáng dài/vai ngang/cổ tròn/cổ chữ v...).

Ví dụ:
Input: "áo dáng ngắn có đức rời tay dài"
Output: {"intent":"product_search","keywords":["so mi"],"special_phrases":["có đức rời","dáng ngắn","tay dài"],"category":"áo","colors":[],"attributes":["dáng ngắn","tay dài"],"response_text":""}

Input: "chào bạn"
Output: {"intent":"greeting","keywords":[],"special_phrases":[],"category":null,"colors":[],"attributes":[],"response_text":"Chào bạn! Mình giúp bạn tìm sản phẩm gì ạ?"}
PROMPT;
    }

    private function showSuggestions(string $text, array $hintTermsA = [], ?string $categoryA = null): JsonResponse
    {
        $q = Product::query()->where('status_product', 1);

        // ưu tiên gợi ý theo category nếu có
        if ($categoryA) {
            $q->whereHas('category', function ($c) use ($categoryA) {
                $this->whereLikeAi($c, 'name_category', $categoryA);
            });
        } elseif (!empty($hintTermsA)) {
            $q->where(function ($sub) use ($hintTermsA) {
                foreach ($hintTermsA as $t) {
                    $this->orWhereLikeAi($sub, 'name_product', $t);
                    $this->orWhereLikeAi($sub, 'describe_product', $t);
                }
            });
        }

        $products = $q->orderByDesc('view_product')
            ->limit(5)
            ->get(['id_product','name_product','price_product','image','slug_product']);

        return response()->json([
            'text' => $text,
            'products' => $this->formatProducts($products),
        ]);
    }

    private function formatProducts(Collection $products): array
    {
        return $products->map(function ($p) {
            $img = $p->image
                ? asset('uploads/product/' . $p->image)
                : asset('images/no-image.png');

            $link = '#';

            try {
                $slug = $p->slug_product ?? null;

                if (!empty($slug)) {
                    if (Route::has('client.product.show')) {
                        $link = route('client.product.show', $slug);
                    } else {
                        $link = url('/san-pham/' . $slug);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Chatbot link build error', [
                    'id_product' => $p->id_product ?? null,
                    'slug' => $p->slug_product ?? null,
                    'err' => $e->getMessage()
                ]);
                $link = '#';
            }

            return [
                'name'  => (string) $p->name_product,
                'price' => number_format((float)$p->price_product, 0, ',', '.') . 'đ',
                'image' => $img,
                'link'  => $link,
            ];
        })->toArray();
    }

    private function generateResponse(string $query, int $count): string
    {
        if ($count <= 0) return "Không tìm thấy \"{$query}\". Bạn thử mô tả khác giúp mình nhé!";
        if ($count === 1) return "Tìm thấy sản phẩm phù hợp:";
        return "Tìm thấy {$count} sản phẩm phù hợp nhất:";
    }

    private function isGreeting(string $lowerMessage): bool
    {
        $greetings = ['xin chao', 'chao', 'hello', 'hi', 'hey', 'alo'];
        $ascii = $this->toAscii($lowerMessage);

        return mb_strlen($lowerMessage, 'UTF-8') < 25
            && collect($greetings)->contains(fn($g) => str_contains($ascii, $g));
    }

    /**
     * Extract special phrases pairs: [asciiPhrase => accentedPhrase]
     */
    private function extractSpecialPhrasesPairs(string $asciiText): array
    {
        $found = [];
        foreach ($this->specialPhrases as $ascii => $accented) {
            if (str_contains($asciiText, $ascii)) {
                $found[$ascii] = $accented;
            }
        }
        return $found;
    }

    private function expandSynonyms(string $asciiText): string
    {
        foreach ($this->synonyms as $base => $variants) {
            foreach ($variants as $v) {
                if (str_contains($asciiText, $v)) {
                    if (!str_contains($asciiText, $base)) {
                        $asciiText .= ' ' . $base;
                    }
                    break;
                }
            }
        }
        return $asciiText;
    }

    /**
     * Extract keywords ASCII, bỏ stopwords, giữ nguyên phrases đã detect.
     */
    private function extractKeywords(string $asciiText, array $preservedPhrases = []): array
    {
        $temp = $asciiText;

        foreach ($preservedPhrases as $ph) {
            $temp = str_replace($ph, ' ', $temp);
        }

        $temp = preg_replace('/\s+/', ' ', trim($temp));
        if ($temp === '') return [];

        $words = explode(' ', $temp);

        $keywords = array_filter($words, function ($w) {
            $w = trim($w);
            if ($w === '' || mb_strlen($w, 'UTF-8') < 2) return false;
            return !in_array($w, $this->stopWords, true);
        });

        return array_values(array_unique($keywords));
    }

    private function toAscii(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');

        $map = [
            'à'=>'a','á'=>'a','ạ'=>'a','ả'=>'a','ã'=>'a','â'=>'a','ầ'=>'a','ấ'=>'a','ậ'=>'a','ẩ'=>'a','ẫ'=>'a','ă'=>'a','ằ'=>'a','ắ'=>'a','ặ'=>'a','ẳ'=>'a','ẵ'=>'a',
            'è'=>'e','é'=>'e','ẹ'=>'e','ẻ'=>'e','ẽ'=>'e','ê'=>'e','ề'=>'e','ế'=>'e','ệ'=>'e','ể'=>'e','ễ'=>'e',
            'ì'=>'i','í'=>'i','ị'=>'i','ỉ'=>'i','ĩ'=>'i',
            'ò'=>'o','ó'=>'o','ọ'=>'o','ỏ'=>'o','õ'=>'o','ô'=>'o','ồ'=>'o','ố'=>'o','ộ'=>'o','ổ'=>'o','ỗ'=>'o','ơ'=>'o','ờ'=>'o','ớ'=>'o','ợ'=>'o','ở'=>'o','ỡ'=>'o',
            'ù'=>'u','ú'=>'u','ụ'=>'u','ủ'=>'u','ũ'=>'u','ư'=>'u','ừ'=>'u','ứ'=>'u','ự'=>'u','ử'=>'u','ữ'=>'u',
            'ỳ'=>'y','ý'=>'y','ỵ'=>'y','ỷ'=>'y','ỹ'=>'y',
            'đ'=>'d'
        ];

        $text = str_replace(array_keys($map), array_values($map), $text);
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
        $text = preg_replace('/\s+/', ' ', trim($text));

        return $text;
    }

    private function normalizeArrayToAscii(array $arr): array
    {
        $out = [];
        foreach ($arr as $v) {
            if (!is_string($v)) continue;
            $v = trim($v);
            if ($v === '') continue;
            $out[] = $this->toAscii($v);
        }
        return array_values(array_unique(array_filter($out)));
    }

    private function escapeLike(string $value): string
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $value);
    }

    /**
     * LIKE with COLLATE (accent-insensitive + case-insensitive theo collation chọn).
     */
    private function orWhereLikeAi($q, string $column, string $term): void
    {
        $like = '%' . $this->escapeLike($term) . '%';
        $q->orWhereRaw("LOWER($column) COLLATE {$this->searchCollation} LIKE ?", [$like]);
    }

    private function whereLikeAi($q, string $column, string $term): void
    {
        $like = '%' . $this->escapeLike($term) . '%';
        $q->whereRaw("LOWER($column) COLLATE {$this->searchCollation} LIKE ?", [$like]);
    }

    /**
     * Build hint terms + category từ AI data để showSuggestions() gợi ý đúng ngữ cảnh.
     */
    private function buildHintsFromAiData(array $aiData): array
    {
        $keywordsA       = $this->normalizeArrayToAscii((array)($aiData['keywords'] ?? []));
        $specialPhrasesA = $this->normalizeArrayToAscii((array)($aiData['special_phrases'] ?? []));
        $colorsA         = $this->normalizeArrayToAscii((array)($aiData['colors'] ?? []));
        $attributesA     = $this->normalizeArrayToAscii((array)($aiData['attributes'] ?? []));
        $category        = $aiData['category'] ?? null;
        $categoryA       = $category ? $this->toAscii(mb_strtolower((string)$category, 'UTF-8')) : null;

        $hintTermsA = array_values(array_unique(array_merge($specialPhrasesA, $keywordsA, $colorsA, $attributesA)));

        return [$hintTermsA, $categoryA];
    }
}
