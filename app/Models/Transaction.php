<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    //public function user(){
      //  return $this->belongsTo('App\Models\User');
   // }



    public function items()
    {
        return $this->belongsTo(items::class,'item_id');
    }

    public function payments()
    {


        return $this->hasMany(Payment::class, 'trans_id', 'id');
    }
}
