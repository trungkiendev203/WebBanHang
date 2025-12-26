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
    'slug_product',
    'price_product',
    'saleprice_product',
    'import_price',
    'describe_product',
    'view_product',
    'status_product',
    'id_category',
    'id_label',
    'image'
];


    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'id_product', 'id_product');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'id_product', 'id_product');
    }
    public function label()
{
    return $this->belongsTo(Label::class, 'id_label', 'id_label');
}

}
