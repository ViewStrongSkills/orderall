<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionExtra extends Model
{

		protected $fillable = [
			'menu_extra_id',
			'transaction_item_id',
			'name',
			'price',
		];

    public function item()
    {
      return $this->belongsTo('App\TransactionItem');
    }

		public function extra()
		{
			return $this->belongsTo('App\MenuExtra', 'menu_extra_id');
		}
}
