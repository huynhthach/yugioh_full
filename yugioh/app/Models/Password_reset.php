<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password_reset extends Model
{
    use HasFactory;

    protected $table = 'password_reset';
    protected $primaryKey = 'Email';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['Email','Token','Created_at'];
}
