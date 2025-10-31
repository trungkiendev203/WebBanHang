<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller {
    public function index(){
        $products = DB::table('tb_product')->limit(5)->get();
        return view('admin.dashboard',compact('products'));
    }
}
