<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    public  $timestamps = false;

    protected $fillable = ['Username', 'Password', 'Email', 'NgayTao', 'IDRole', 'imageus'];


    public function role()
    {
        return $this->belongsTo(Role::class, 'IDRole');
    }

    public function ownedItems()
    {
        return $this->hasMany(OwnedItem::class, 'OwnerID', 'UserID');
    }
}
