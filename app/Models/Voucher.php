<?php
// app/Models/Area.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    
    protected $guarded = [];
    protected $fillable = [
        'category_id', 'title', 'code', 'description', 'type', 'value',
        'min_order', 'max_discount', 'brand', 'image',
        'usage_limit', 'used_count', 'valid_from', 'valid_until', 'is_active',
    ];

     
}