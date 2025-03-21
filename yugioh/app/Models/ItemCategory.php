<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;
    protected $table = 'ItemCategories';
    protected $primaryKey = 'CategoryID';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'CategoryID', 'CategoryName',
    ];
}
