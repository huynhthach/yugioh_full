<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use HasFactory;
    protected $table = 'NewsCategories';
    protected $primaryKey = 'CategoryID';
    public $timestamps = false;

    protected $fillable = ['CategoryName'];

    public function news()
    {
        return $this->hasMany(News::class, 'CategoryID', 'CategoryID');
    }
}
