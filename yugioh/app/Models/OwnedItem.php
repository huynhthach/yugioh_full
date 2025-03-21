<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnedItem extends Model
{
    use HasFactory;
    protected $table = 'owneditems';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ItemID','PackID', 'OwnerID','Quantity', 'NgaySoHuu',
    ];

    // Define relationships
    public function item()
    {
        return $this->belongsTo(Item::class, 'ItemID', 'ItemID');
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class, 'PackID', 'PackID');
    }

    // Assume you have a User model for the OwnerID foreign key
    public function owner()
    {
        return $this->belongsTo(User::class, 'OwnerID', 'UserID');
    }

    public function gacha(){
        return $this->hasMany(GachaResult::class,'OwnerID','UserID');
    }

    public function reciept(){
        return $this->hasMany(GachaResult::class,'OwnerID','UserIDBuy');
    }
}
