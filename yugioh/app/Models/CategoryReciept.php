<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryReciept extends Model
{
    use HasFactory;

    protected $table = 'recieptcategories';
    protected $primaryKey = 'CategoryID';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'CategoryID','CategoryName',
    ];
}
