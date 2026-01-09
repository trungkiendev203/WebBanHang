<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'tb_order_detail';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'id_product',
        'id_product_variant',
        'quantity',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
    public function productVariant()
{
    return $this->belongsTo(ProductVariant::class, 'id_product_variant', 'id_product_variant');
}
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'id_product_variant', 'id_product_variant');
    }
}
