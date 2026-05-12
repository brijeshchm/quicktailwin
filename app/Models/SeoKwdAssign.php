<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoKwdAssign extends Model
{
    protected $table = 'seo_kwd_assign';
     protected $fillable = [
        'seo_id',     
        'kwd_assign',
        'created_by',
        'updated_by',
    ];
}
