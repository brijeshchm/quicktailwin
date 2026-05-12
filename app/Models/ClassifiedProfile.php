<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassifiedProfile extends Model
{
    protected $fillable = [
        'website',
        'user_name',
        'seo_activity',
        'email',
        'password',
        'profile_url',
        'status',
        'created_by',
        'updated_by',
    ];
}
