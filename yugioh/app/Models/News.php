<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'News';
    protected $primaryKey = 'NewsID';
    public $timestamps = false;

    protected $fillable = ['Title', 'PublishedDate', 'CategoryID', 'image'];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'CategoryID', 'CategoryID');
    }

    public function details()
    {
        return $this->hasOne(NewsDetail::class, 'NewsID', 'NewsID');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'NewsID', 'NewsID');
    }

    
}
