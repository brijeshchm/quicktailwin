<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedeemableItem extends Model
{
    
 protected $fillable = [
        'name', 'description', 'image_url',
        'coins_required', 'credit_coins',
        'city_prices', 'category', 'is_active'
    ];

 
   
}
