<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $table = 'Receipt';
    protected $primaryKey = 'RecieptID';
    public $timestamps = false; 

    protected $fillable = [
        'RecieptID', 'UserIDBuy', 'UserIDSell', 'RecieptDate','TotalAmount','State','CategoryReceiptID'
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'UserIDBuy', 'UserID');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'UserIDSell', 'UserID');
    }

    public function category_reciept(){
        return $this->belongsTo(CategoryReciept::class,'CategoryReceiptID','CategoryID');
    }

    public function recieptdetail()
    {
        return $this->hasMany(ReceiptDetail::class, 'RecieptID', 'RecieptID');
    }
}
