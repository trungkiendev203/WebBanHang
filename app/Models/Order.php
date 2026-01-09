<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    protected $table = 'tb_order';
    protected $primaryKey = 'id_order';

    protected $fillable = [
        'id_user',
        'id_customer',
        'total_price',
        'status_order',
        'name_customer',
        'email_customer',
        'phone_customer',
        'province',
        'district',
        'ward',
        'address_detail',
        'code_order',
        'order_date',
        'payment_method',
        'payment_status',
        'payment_code',
        'total_amount',
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->code_order)) {
                $order->code_order = '#'.rand(100000, 999999);
            }
            if (empty($order->order_date)) {
                $order->order_date = now();
            }
        });
    }
    // ✅ Alias theo view
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
}
