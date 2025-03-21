<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsDetail extends Model
{
    use HasFactory;
    protected $table = 'NewsDetails';
    public $timestamps = false;

    protected $fillable = ['ImagePath', 'Content', 'ThuTu', 'Form'];

    public function news()
    {
        return $this->belongsTo(News::class, 'NewsID', 'NewsID');
    }
}
