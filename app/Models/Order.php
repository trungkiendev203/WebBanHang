<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'tb_order';
    protected $primaryKey = 'id_order';

    protected $fillable = [
        'id_user',
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
        'total_amount'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
}

