<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function items()
    {
      return $this->hasMany('App\TransactionItem', 'transaction_id');
    }

    //Returns user of this transaction
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    //Returns business of this transaction
    public function business()
    {
    	return $this->belongsTo('App\Business');
    }

    public function transactionextras()
    {
      return $this->hasManyThrough('App\TransactionExtra', 'App\TransactionItem');
    }
}
