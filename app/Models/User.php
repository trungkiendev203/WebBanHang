<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';
    public $timestamps = true;

    protected $fillable = [
        'account_user','pass_user','name_user','email_user',
        'phonenumber_user','type_user','status_user'
    ];
}

