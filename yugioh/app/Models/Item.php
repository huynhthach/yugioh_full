<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'Items';
    protected $primaryKey = 'ItemID';
    public $timestamps = false;

    protected $fillable = [
        'ItemName', 'ItemCategory', 'Description', 'image',
    ];

    // Define relationships
    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'ItemCategory', 'CategoryID');
    }

    public function ownerItems()
    {
        return $this->hasMany(OwnedItem::class, 'ItemID', 'ItemID');
    }

    public function favorite_tags()
    {
        return $this->hasMany(Favorite_Tags::class,'ItemID', 'ItemID');
    }

    public function isFavoritedByUser($userId)
    {
        // Logic kiểm tra xem item có được favorite bởi user hay không
        return $this->favorite_tags()->where('UserID', $userId)->exists();
    }

    

}
