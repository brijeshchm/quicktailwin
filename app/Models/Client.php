<?php
// app/Models/Client.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasProfileCompletion;
use Illuminate\Database\Eloquent\Builder;
class Client extends Model
{
    use SoftDeletes,HasApiTokens,HasProfileCompletion;
    protected $table = 'clients';
    protected $guarded = [];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function assignedAreas()
    {
        return $this->hasMany(AssignedArea::class);
    }

    public function assignedZones()
    {
        return $this->hasMany(AssignedZone::class);
    }

    public function assignedKeywords()
    {
        return $this->hasMany(AssignedKwd::class);
    }

    public function leads()
    {
        return $this->hasMany(AssignedLead::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

  public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query, string $search): void {
            $query->where(function (Builder $query) use ($search): void {
                $query->where('business_name', 'like', "%{$search}%")
                    ->orWhere('owner_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        });
    }

    public function getInitialsAttribute(): string
    {
        return collect(explode(' ', $this->business_name))
            ->filter()
            ->take(2)
            ->map(fn (string $word): string => strtoupper($word[0]))
            ->implode('');
    }
 
}