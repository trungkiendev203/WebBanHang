<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $table = 'collections';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'banner',
        'description',
        'status'
    ];

    /**
     * Quan hệ N-N với Product
     * 1 collection có nhiều sản phẩm
     */
    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'collection_product',
            'collection_id',
            'product_id'
        );
    }
}
