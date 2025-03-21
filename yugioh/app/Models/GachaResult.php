<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GachaResult extends Model
{
    use HasFactory;

    protected $table = 'gacha_results';
    protected $primaryKey = 'GachaResultID';
    public $timestamps = false;

    protected $fillable = [
        'UserID',
        'PackID',
        'GachaDate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class, 'PackID', 'PackID');
    }

    public function gachaResultDetails()
    {
        return $this->hasMany(GachaResultDetail::class, 'GachaResultID', 'GachaResultID');
    }
}
