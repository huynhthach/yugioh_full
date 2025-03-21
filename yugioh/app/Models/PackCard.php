<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackCard extends Model
{
    use HasFactory;

    protected $table = 'pack_cards';
    public $timestamps = false;

    protected $fillable = [
        'PackID',
        'CardID',
        'Rate',
    ];

    public function pack()
    {
        return $this->belongsTo(Pack::class, 'PackID', 'PackID');
    }

    public function card()
    {
        return $this->belongsTo(Item::class, 'CardID', 'ItemID');
    }
}
