<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $table = 'tb_customer_address';
    protected $primaryKey = 'id_address';

    protected $fillable = [
        'id_customer',
        'name_receiver',
        'phone_receiver',
        'province',
        'district',
        'ward',
        'address_detail',
        'is_default'
    ];
    
}
