<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite_Tags extends Model
{
    use HasFactory;

    protected $table = 'favorite_tags';

    protected $primaryKey = null; // Bảng này không có primary key tự tăng

    public $incrementing = false; // Vô hiệu hóa tự động tăng cho các trường khóa chính

    protected $fillable = [
        'UserID',
        'ItemID',
    ];

    // Assume you have a User model for the OwnerID foreign key
    public function owner()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'ItemID', 'ItemID');
    }



    public $timestamps = false; // Không sử dụng timestamps
}
