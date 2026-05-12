<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\Citieslists;
use App\Models\ChildCategory;
use App\Models\ParentCategory;
use App\Models\Keyword;
use App\Models\KeywordSellCount;
class SeoLog extends Model
{
    protected $fillable = [
        'id',
        'description',         
        'version',         
        'table',         
        'attributes',         
        'status',         
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'premium_price' => 'decimal:2',
        'diamond_price' => 'decimal:2',
        'platinum_price' => 'decimal:2',
        'royal_price' => 'decimal:2',
        'king_price' => 'decimal:2',
        'preferred_price' => 'decimal:2',
        'rating_value' => 'decimal:1',
    ];

    public function childCategory()
    {
        return $this->belongsTo(ChildCategory::class, 'child_category_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(ParentCategory::class, 'parent_category_id');
    }

    public function city()
    {
        return $this->belongsTo(Citieslists::class, 'city_id');
    }
}
