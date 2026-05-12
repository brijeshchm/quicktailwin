<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class SeoWork extends Model
{
     protected $fillable = [
        'keyword',        
        'website',
        'email',
        'password',
        'backlink',
        'index_status',
        'index_value',
        'city',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the user associated with the SEO work.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who created the SEO work.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
