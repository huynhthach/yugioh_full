<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $primaryKey = 'TransID';
    public $timestamps = false;

    protected $fillable = ['TransID','UserID', 'Amount', 'Date'];

    public function User()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }
}
