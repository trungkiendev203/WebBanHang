<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $addresses = CustomerAddress::where('id_customer', $customer->id_customer)
            ->orderByDesc('is_default')
            ->get();

        return view('client.account.address', compact('addresses'));
    }
    
    public function store(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'name_receiver'    => 'required',
            'phone_receiver'   => 'required',
            'province'         => 'required',
            'district'         => 'required',
            'ward'             => 'required',
            'address_detail'   => 'required',
        ]);

        // Nếu là địa chỉ mặc định → reset các địa chỉ khác
        if ($request->is_default) {
            CustomerAddress::where('id_customer', $customer->id_customer)
                ->update(['is_default' => 0]);
        }

        CustomerAddress::create([
            'id_customer'    => $customer->id_customer,
            'name_receiver'  => $request->name_receiver,
            'phone_receiver' => $request->phone_receiver,
            'province'       => $request->province,
            'district'       => $request->district,
            'ward'           => $request->ward,
            'address_detail' => $request->address_detail,
            'is_default'     => $request->is_default ? 1 : 0,
        ]);

        return back()->with('success', 'Đã thêm địa chỉ');
    }

    public function setDefault($id)
    {
        $customer = Auth::guard('customer')->user();

        CustomerAddress::where('id_customer', $customer->id_customer)
            ->update(['is_default' => 0]);

        CustomerAddress::where('id_address', $id)
            ->where('id_customer', $customer->id_customer)
            ->update(['is_default' => 1]);

        return back()->with('success', 'Đã đặt làm địa chỉ mặc định');
    }

    public function destroy($id)
    {
        $customer = Auth::guard('customer')->user();

        CustomerAddress::where('id_address', $id)
            ->where('id_customer', $customer->id_customer)
            ->delete();

        return back()->with('success', 'Đã xóa địa chỉ');
    }
}
