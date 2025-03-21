<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptDetail extends Model
{
    use HasFactory;

    protected $table = 'Recieptdetails';
    protected $primaryKey = 'DetailID';
    public $timestamps = false;

    protected $fillable = [
        'DetailID', 'RecieptID', 'ItemID','PackID','Quantity'
    ];

    public function receipt()
    {
        return $this->belongsTo(Receipt::class, 'RecieptID', 'RecieptID');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'ItemID', 'ItemID');
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class, 'PackID', 'PackID');
    }
}
