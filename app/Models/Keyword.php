<?php
// app/Models/Keyword.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $table = 'keyword';
   protected $fillable = [
    'id',
    'keyword',
    'slug',
    'icon',
    'keyword_with_city',
    'child_category_id',
    'parent_category_id',
    'city_id',
    'category',
    'related_keyword',

    'diamond_pos_sold',
    'platinum_pos_sold',
    'seo_type',
    'bucket',

    'faqq1',
    'faqa1',
    'faqq2',
    'faqa2',
    'faqq3',
    'faqa3',
    'faqq4',
    'faqa4',
    'faqq5',
    'faqa5',
    'faqq6',
    'faqa6',

    'premium_price',
    'diamond_price',
    'platinum_price',
    'royal_price',
    'king_price',
    'preferred_price',

    'royal_pos_sold',
    'king_pos_sold',
    'preferred_pos_sold',

    'meta_title',
    'meta_description',
    'meta_keywords',

    'top_description',
    'courseabout',
    'heading',

    'paragraph1',
    'paragraph2',
    'paragraph3',
    'paragraph4',
    'paragraph5',
    'paragraph6',

    'bottom_description',

    'ratingvalue',
    'ratingcount',

    'created_at',
    'updated_at',
];
    // protected $guarded = [];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function parentCategory()
    {
        return $this->belongsTo(ParentCategory::class);
    }

    public function childCategory()
    {
        return $this->belongsTo(ChildCategory::class);
    }

    public function assignedKeywords()
    {
        return $this->hasMany(AssignedKwd::class, 'kw_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'kw_id');
    }
}