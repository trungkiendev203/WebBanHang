<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MomoService
{
    protected string $endpoint;
    protected string $partnerCode;
    protected string $accessKey;
    protected string $secretKey;
    protected string $returnUrl;
    protected string $ipnUrl;

    public function __construct()
    {
        $this->endpoint    = config('services.momo.endpoint');
        $this->partnerCode = config('services.momo.partner_code');
        $this->accessKey   = config('services.momo.access_key');
        $this->secretKey   = config('services.momo.secret_key');
        $this->returnUrl   = config('services.momo.return_url');
        $this->ipnUrl      = config('services.momo.ipn_url');
    }

    /**
     * Tạo giao dịch thanh toán MoMo (Redirect)
     */
    public function createPayment(array $data): array
    {
        $orderId    = $data['order_id'];
        $amount     = $data['amount'];
        $orderInfo  = $data['order_info'] ?? 'Thanh toán đơn hàng';
        $requestId  = time() . '';

        // Chuỗi ký (theo docs MoMo)
        $rawHash = "accessKey={$this->accessKey}"
            . "&amount={$amount}"
            . "&extraData="
            . "&ipnUrl={$this->ipnUrl}"
            . "&orderId={$orderId}"
            . "&orderInfo={$orderInfo}"
            . "&partnerCode={$this->partnerCode}"
            . "&redirectUrl={$this->returnUrl}"
            . "&requestId={$requestId}"
            . "&requestType=captureWallet";

        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        $payload = [
            'partnerCode' => $this->partnerCode,
            'accessKey'   => $this->accessKey,
            'requestId'   => $requestId,
            'amount'      => $amount,
            'orderId'     => $orderId,
            'orderInfo'   => $orderInfo,
            'redirectUrl' => $this->returnUrl,
            'ipnUrl'      => $this->ipnUrl,
            'extraData'   => '',
            'requestType' => 'captureWallet',
            'signature'   => $signature,
            'lang'        => 'vi',
        ];

        $response = Http::post($this->endpoint, $payload);

        return $response->json();
    }

    /**
     * Verify chữ ký IPN từ MoMo
     */
    public function verifySignature(array $data): bool
    {
        $rawHash = "accessKey={$this->accessKey}"
            . "&amount={$data['amount']}"
            . "&extraData={$data['extraData']}"
            . "&message={$data['message']}"
            . "&orderId={$data['orderId']}"
            . "&orderInfo={$data['orderInfo']}"
            . "&orderType={$data['orderType']}"
            . "&partnerCode={$data['partnerCode']}"
            . "&payType={$data['payType']}"
            . "&requestId={$data['requestId']}"
            . "&responseTime={$data['responseTime']}"
            . "&resultCode={$data['resultCode']}"
            . "&transId={$data['transId']}";

        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        return hash_equals($signature, $data['signature']);
    }
}
