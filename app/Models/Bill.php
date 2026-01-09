<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $table = 'tb_bill';
    protected $primaryKey = 'id_bill';
    public $timestamps = true;

protected $fillable = [
   'code_bill','id_order','payment_method','status_bill','total_amount'
];


    protected static function booted()
{
    static::creating(function ($bill) {
        if (empty($bill->code_bill)) {
            $bill->code_bill = 'BILL' . rand(1000, 9999);
        }
    });
}

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }
}
