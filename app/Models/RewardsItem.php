<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardsItem extends Model
{
    
 protected $fillable = [
        'title','code', 'description', 'image_url',
        'coins_required', 'credit_coins',
        'city_prices', 'category', 'is_active'
    ];
	
 
   
}
