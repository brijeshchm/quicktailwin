<?php
// app/Models/ParentCategory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
	protected $table = 'parent_category';
  protected $fillable = [
    'parent_category',
    'parent_slug',
    'form_type',
    'status',
    'pc_icon',
    'category_icon',
    'category_banner',

    'h1_heading',
    'meta_title',
    'meta_keywords',
    'meta_description',

    'top_heading',
    'top_description',
    'bottom_heading',
    'bottom_description',

    'courseabout',
    'heading',

    'paragraph1',
    'paragraph2',
    'paragraph3',
    'paragraph4',
    'paragraph5',
    'paragraph6',

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

    'ratingvalue',
    'ratingcount',
];
    public function childCategories()
    {
        return $this->hasMany(ChildCategory::class, 'parent_category_id', 'id');
    }
 


    public function keywords()
    {
        return $this->hasMany(Keyword::class,'parent_category_id', 'id');
    }
}