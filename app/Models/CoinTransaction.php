<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinTransaction extends Model
{
    
protected $fillable = [
        'user_id', 'redeemable_item_id', 'business_id',
        'item_name', 'business_name', 'city',
        'coins_spent', 'status','type', 'points', 'description'
    ];

    public function user()     { return $this->belongsTo(User::class); }
   
}
