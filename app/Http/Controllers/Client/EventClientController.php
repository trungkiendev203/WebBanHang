<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class EventClientController extends Controller
{


public function index($id)
{
    $event = DB::table('tb_event')
        ->where('id_event', $id)
        ->where('status', 1)
        ->first();

    if (!$event) abort(404);

    $products = Product::with('images') // 👈 BẮT BUỘC
        ->whereIn('id_product', function ($q) use ($id) {
            $q->select('id_product')
              ->from('tb_event_product')
              ->where('id_event', $id);
        })
        ->where('status_product', 1)
        ->get();

    return view('client.event.index', compact('event', 'products'));
}



}
