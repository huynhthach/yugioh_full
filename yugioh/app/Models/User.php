<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public  $timestamps = false;
    protected $table = 'Users';
    protected $primaryKey = 'UserID';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['Username', 'Password ', 'Email', 'NgayTao', 'IDRole', 'balance'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Role::class, 'IDRole');
    }

    // Define relationship with OwnedItem model
    public function ownedItems() {
        return $this->hasMany(OwnedItem::class, 'OwnerID');
    }

    public function favorite_tags() {
        return $this->hasMany(Favorite_Tags::class, 'UserID');
    }


}
