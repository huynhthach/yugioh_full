<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comment';
    protected $primaryKey = 'Comment_ID';
    public $timestamps = false; 

    protected $fillable = [
        'Comment_ID	', 'UserID','NewsID', 'Content', 'Created_at'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function news()
    {
        return $this->belongsTo(News::class, 'NewsID', 'NewsID');
    }


}
