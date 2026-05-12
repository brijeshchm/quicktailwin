<?php

namespace App\Models\Client;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class Client extends Authenticatable
{
    use SoftDeletes;
     
	protected $table = 'clients';
    protected $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */	
	  protected $fillable = [

    // Auth / basic
    'username',
    'password',
    'business_slug',
    'pauseLead',
    'client_type',
    'active_status',
    'paid_status',
    'conversion_status',

    // Business info
    'business_name',
    'business_intro',
    'business_slug',
    'occupation',
    'year_of_estb',
    'certifications',
    'display_hofo',
    'payment_mode_accepted',
    'logo',
    'profile_pic',
    'business_map',
    'pictures',
    'whatsapp',

    // Contact
    'email',
    'mobile',
    'sec_mobile',
    'stdcode',
    'landline',
    'fax',
    'tollfree',
    'website',

    // Address (business)
    'address',
    'area',
    'zone',
    'zone_id',
    'pincode',
    'landmark',
    'city_id',
    'city',
    'state_id',
    'state',
    'country',

    // Personal details
    'sirName',
    'first_name',
    'middle_name',
    'last_name',
    'personal_email',
    'personal_phone',
    'personal_address',
    'personal_area',
    'personal_zone',
    'personal_zone_id',
    'personal_pincode',
    'personal_city',
    'personal_city_id',
    'personal_state',
    'personal_state_id',
    'dob',
    'gender',
    'marital',

    // Subscription / finance
    'max_kw',
    'coins_free',
    'coins_amt',
    'balance_amt',
    'order_amount',
    'cost_per_lead',
    'yrly_subs_start_date',
    'yrly_subs_end_date',
    'expired_from',
    'expired_on',
    'package_status',

    // Leads
    'leads_count',
    'leads_remaining',

    // Status
    'certified_status',
    'pauseLead',

    // Misc
    'time',
    'remark',
    'created_by',
    'facebook_url',
    'instagram_url',
    'twitter_url',
    'linkedin_url',
    'pinterest_url',
    'youtube_url',
    'gst_no',
    'cin_no',
    'iso_no',
    'pan_no',
    'gsin',
    'google_id',
    'is_social_login',
];
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','remember_token'
    ];
	
	protected $dates = ['deleted_at'];

    
}
