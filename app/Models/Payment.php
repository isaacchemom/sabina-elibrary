<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

     // Specify the attributes that are mass assignable
    protected $fillable = [
        'phone',
        'amount',
        'bookId',
        'status',
        'mpesa_trans_id',
        'trans_id',
        'MerchantRequestID',
        'CheckoutRequestID'
    ];



    public function user(){
        return $this->belongsTo('App\Models\User');
    }


    public function transaction()
    {


        return $this->belongsTo(Transaction::class, 'trans_id', 'id');
    }
}
