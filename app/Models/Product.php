<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'tb_product';
    protected $primaryKey = 'id_product';
    
    protected $fillable = [
        'name_product',
        'slug_product',
        'code_product',
        'id_category',
        'id_label',
        'image', // Ảnh chính
        'price_product',
        'saleprice_product',
        'import_price',
        'describe_product',
        'status_product',
        'view_product'
    ];

    // ✅ QUAN HỆ VỚI PRODUCT_IMAGES (NHIỀU ẢNH)
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'id_product', 'id_product');
    }

    // ✅ QUAN HỆ VỚI VARIANTS
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'id_product', 'id_product');
    }

    // ✅ QUAN HỆ VỚI CATEGORY
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    // ✅ QUAN HỆ VỚI LABEL
    public function label()
    {
        return $this->belongsTo(Label::class, 'id_label', 'id_label');
    }
}