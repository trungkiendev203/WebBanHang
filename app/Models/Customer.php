<?php

// app/Models/Customer.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $table = 'tb_customer';
    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'name', 'email', 'phone', 'password'
    ];

    protected $hidden = ['password'];
}

