<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Guest extends Authenticatable
{
    use Notifiable;

    protected $guard = 'guests';

    protected $fillable = [
        'name', 'email', 'password', 'company',
        'title', 'first_name', 'middle_name', 'last_name',
        'dob', 'marital_status', 'city', 'area', 'pincode',
        'occupation', 'avatar',
        'mobile',
        'email','business_name',
        'profile_progress', 'profile_step', 'name', 'country_code', 'contact_number', 'email',
        'address', 'landmark', 'pincode', 
        'std_code', 'landline_number', 'tag', 'is_default',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'dob' => 'date',
        'mobile_1_verified' => 'boolean',
        'mobile_2_verified' => 'boolean',
    ];

    /**
     * Calculate profile completion progress
     */
    public function calculateProgress(): int
    {
        $fields = [
            'first_name', 'last_name', 'dob', 'marital_status',
            'city', 'area', 'pincode', 'occupation',
            'avatar', 'mobile_1',
        ];

        $filled = collect($fields)->filter(fn($f) => !empty($this->$f))->count();
        return (int) round(($filled / count($fields)) * 100);
    }
	
	public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getTagBadgeColorAttribute(): string
    {
        return match($this->tag) {
            'home'   => 'bg-green-100 text-green-700',
            'office' => 'bg-blue-100 text-blue-700',
            default  => 'bg-gray-100 text-gray-700',
        };
    }
	
	
}