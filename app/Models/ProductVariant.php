<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'tb_product_variant';
    protected $primaryKey = 'id_product_variant';

    protected $fillable = [
        'id_product',
        'size',
        'color',
        'stock',
        'sku'
    ];
}
