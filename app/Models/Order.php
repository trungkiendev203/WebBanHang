<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'tb_order';
    protected $primaryKey = 'id_order';
    public $timestamps = false;

    protected $fillable = [
        'code_order', 'name_customer', 'email_customer', 'phone_customer',
        'province', 'district', 'ward', 'address_detail',
        'order_date', 'total_amount', 'status_order'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
    public function bill()
    {
        return $this->hasOne(Bill::class, 'id_order', 'id_order');
    }
    public function orderDetails()
{
    return $this->hasMany(\App\Models\OrderDetail::class, 'id_order', 'id_order');
}

    
}
