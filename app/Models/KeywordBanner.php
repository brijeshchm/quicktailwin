<?php
// app/Models/AssignedArea.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeywordBanner  extends Model
{
    protected $fillable = [
        'keyword_id', 'image_path', 'original_name', 'alt_text', 'sort_order','client_slug'
    ];

    public function keyword()
    {
        return $this->belongsTo(Keyword::class);
    }

    public function getImageUrlAttribute()
    {
        return asset($this->image_path);
    }
}