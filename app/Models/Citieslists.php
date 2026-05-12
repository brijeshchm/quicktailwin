<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citieslists extends Model
{
    //
	protected $table = 'citylists';
    protected $fillable = [
        'id',
        'city',
        'state_id',
        'state',
        'latitude',
        'longitude'
    ];
}
