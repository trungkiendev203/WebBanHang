<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'tb_label';
    protected $primaryKey = 'id_label';
    public $timestamps = true;

    protected $fillable = [
        'code_label',
        'name_label',
        'slug_label',
        'status_label',
    ];
}
