<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
    
 protected $fillable = [
        'user_id', 'redeemable_item_id', 'business_id',
        'item_name', 'business_name', 'city',
        'coins_spent', 'status'
    ];

    public function user()     { return $this->belongsTo(User::class); }
    public function business() { return $this->belongsTo(Client::class); }
    public function item()     { return $this->belongsTo(RedeemableItem::class, 'redeemable_item_id'); }
   
}
