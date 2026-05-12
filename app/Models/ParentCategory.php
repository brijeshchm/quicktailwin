<?php
// app/Models/ParentCategory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
	protected $table = 'parent_category';
    protected $guarded = [];

    public function childCategories()
    {
        return $this->hasMany(ChildCategory::class, 'parent_category_id', 'id');
    }
 


    public function keywords()
    {
        return $this->hasMany(Keyword::class,'parent_category_id', 'id');
    }
}