<?php
// app/Models/Area.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    
    protected $guarded = [];
    protected $fillable = [
        'id',
        'area',
        'zone_id',
        'created_at',
        'updated_at',        
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function assignedAreas()
    {
        return $this->hasMany(AssignedArea::class);
    }
}