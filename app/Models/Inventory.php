<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'tb_inventory';
    protected $primaryKey = 'id_inventory';
    public $timestamps = true;

    protected $fillable = [
        'id_variant',
        'qty_change',
        'note',
    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'id_variant', 'id_variant');
    }
}
