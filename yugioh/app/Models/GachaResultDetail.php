<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GachaResultDetail extends Model
{
    use HasFactory;

    protected $table = 'gacha_result_details';
    protected $primaryKey = 'ResultDetailID';
    public $timestamps = false;

    protected $fillable = [
        'GachaResultID',
        'CardID',
    ];
    
    public function gachaResult()
    {
        return $this->belongsTo(GachaResult::class, 'GachaResultID', 'GachaResultID');
    }

    public function card()
    {
        return $this->belongsTo(Item::class, 'CardID', 'ItemID');
    }
}
