<?php
// app/Models/AssignedArea.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedArea extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'id',
        'client_id',
        'state_id',
        'assigned_zone_id',
        'city_id ',        
        'area_id ',        
        'created_at ',        
        'updated_at ',        
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}