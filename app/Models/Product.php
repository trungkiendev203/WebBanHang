<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'tb_product';
    protected $primaryKey = 'id_product';
    public $timestamps = true;

 protected $fillable = [
    'code_product',
    'name_product',
    'price_product',
    'saleprice_product',
    'import_price',  
    'describe_product',
    'size_product',
    'image',
    'image_thumb',
    'quantity',
    'view_product',
    'status_product',
    'id_category',
    'id_label',
    'slug_product',
];


    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    public function label()
    {
        return $this->belongsTo(Label::class, 'id_label', 'id_label');
    }
    public function images()
{
    return $this->hasMany(ProductImage::class, 'id_product', 'id_product');
}

}

