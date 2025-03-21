<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;

    protected $table = 'packs';
    protected $primaryKey = 'PackID';
    public $timestamps = false;

    protected $fillable = [
        'PackID','PackName','Image_pack','Price'
    ];

    public function packCards()
    {
        return $this->hasMany(PackCard::class, 'PackID', 'PackID');
    }

    public function gachaResults()
    {
        return $this->hasMany(GachaResult::class, 'PackID', 'PackID');
    }
}
