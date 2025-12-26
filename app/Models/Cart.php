<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'tb_cart';
    protected $primaryKey = 'id_cart';
        public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_product',
        'id_product_variant',
        'quantity',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'id_product_variant', 'id_product_variant');
    }   

}
