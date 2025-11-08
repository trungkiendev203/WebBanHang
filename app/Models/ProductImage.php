<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'tb_product_image';
    protected $primaryKey = 'id_image';
    public $timestamps = false;

    protected $fillable = [
        'id_product',
        'image_url',
        'created_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}

