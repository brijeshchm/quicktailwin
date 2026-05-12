<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
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
}
