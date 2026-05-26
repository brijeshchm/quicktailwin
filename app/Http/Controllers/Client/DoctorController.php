<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Client;
use Illuminate\Support\Facades\Cache;
class DoctorController extends Controller
{
     
    public function doctorHub(Request $request){

    $search   = trim((string) $request->input('q', ''));
        $location = trim((string) $request->input('location', ''));

        $clinics = collect($this->getClinics())
            ->when($search, fn ($c) => $c->filter(fn ($x) =>
                str_contains(strtolower($x['name'] ?? ''), strtolower($search)) ||
                str_contains(strtolower($x['specialty'] ?? ''), strtolower($search))
            ))
            ->values();


            // dd($clinics);
        $doctors = $this->getDoctors();

        $stats = [
            ['value' => 50,  'suffix' => '+',  'label' => 'Top Clinics'],
            ['value' => 200, 'suffix' => '+',  'label' => 'Specialists'],
            ['value' => 10,  'suffix' => 'k+', 'label' => 'Appointments'],
            ['value' => 99,  'suffix' => '%',  'label' => 'Satisfaction'],
        ];
//  dd($clinics->take(3));
        return view('client.doctor-hub', [
            'clinics'  =>  $clinics,
            'doctors'  =>  $doctors,
            'stats'    => $stats,
            'search'   => $search,
            'location' => $location,
        ]);
        
        
        
        
        
    }




    public function getClinics(): array
    {
         return [
            ['id'=>1,'name'=>'MedCare Plus','specialty'=>'Multi-Specialty','city'=>'Dehradun','rating'=>4.9,'reviews'=>312,'image'=>'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?q=80&w=1200'],
            ['id'=>2,'name'=>'Aura Wellness Center','specialty'=>'Cardiology','city'=>'Delhi','rating'=>4.8,'reviews'=>540,'image'=>'https://images.unsplash.com/photo-1629909613654-28e377c37b09?q=80&w=1200'],
            ['id'=>3,'name'=>'Sunrise Diagnostics','specialty'=>'Diagnostics','city'=>'Mumbai','rating'=>4.7,'reviews'=>189,'image'=>'https://images.unsplash.com/photo-1631815589968-fdb09a223b1e?q=80&w=1200'],
        ];
        
    }

    public function getDoctors(): array
    {
         
        return [
                    ['id'=>1,'name'=>'Dr. Anjali Verma','specialty'=>'Cardiologist','clinic'=>'Aura Wellness','rating'=>4.9,'image'=>'https://i.pravatar.cc/300?img=47','is_available_today'=>'false','title'=>'Neurologist'],
                    ['id'=>2,'name'=>'Dr. Rohan Mehta','specialty'=>'Dermatologist','clinic'=>'MedCare Plus','rating'=>4.8,'image'=>'https://i.pravatar.cc/300?img=12','is_available_today'=>'true','title'=>'Neurologist'],
                    ['id'=>3,'name'=>'Dr. Priya Singh','specialty'=>'Pediatrician','clinic'=>'Sunrise Clinic','rating'=>4.9,'image'=>'https://i.pravatar.cc/300?img=5','is_available_today'=>'true','title'=>'Neurologist'],
                    ['id'=>4,'name'=>'Dr. Kabir Khan','specialty'=>'Neurologist','clinic'=>'Aura Wellness','rating'=>4.7,'image'=>'https://i.pravatar.cc/300?img=15','is_available_today'=>'true','title'=>'Neurologist'],
                ];
             
             
        
    }
 
    public function clinicDetails(Request $request)
{
    // ─── Mock REVIEWS as a Collection of objects ───
    $reviews = collect([
        [
            'id' => 1,
            'patient_name' => 'Rahul Sharma',
            'rating' => 5,
            'title'  => 'Outstanding service',
            'comment' => 'Professional staff, clean facility, and the doctor was excellent. Highly recommend!',
            'review_date' => now()->subDays(4),
            'is_verified' => true,
            'helpful_count' => 12,
        ],
        [
            'id' => 2,
            'patient_name' => 'Priya Verma',
            'rating' => 4,
            'title'  => 'Great experience',
            'comment' => 'Wait time was minimal and the consultation was thorough. Will visit again.',
            'review_date' => now()->subDays(10),
            'is_verified' => true,
            'helpful_count' => 7,
        ],
    ])->map(function ($r) {
        $r['initials'] = collect(explode(' ', $r['patient_name']))
            ->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->implode('');
        return (object) $r;
    });

    // ─── Mock DOCTORS as a Collection of objects ───
    $doctors = collect([
        [
            'id' => 1, 'slug' => 'dr-amit-singh',
            'name' => 'Dr. Amit Singh', 'title' => 'MD, FRCS',
            'specialty' => 'Cardiology', 'subspecialty' => 'Interventional Cardiology',
            'image_url' => 'https://i.pravatar.cc/300?u=1',
            'years_experience' => 15, 'rating' => 4.8, 'review_count' => 87,
            'consultation_fee' => 150, 'accepts_insurance' => true,
            'is_available_today' => true, 'languages' => ['English','Hindi'],
        ],
        [
            'id' => 2, 'slug' => 'dr-neha-kapoor',
            'name' => 'Dr. Neha Kapoor', 'title' => 'MBBS, MD',
            'specialty' => 'Cardiology', 'subspecialty' => null,
            'image_url' => 'https://i.pravatar.cc/300?u=2',
            'years_experience' => 10, 'rating' => 4.6, 'review_count' => 54,
            'consultation_fee' => 120, 'accepts_insurance' => true,
            'is_available_today' => false, 'languages' => ['English','Hindi','Punjabi'],
        ],
    ])->map(function ($d) {
        $d['initials'] = collect(explode(' ', $d['name']))
            ->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->implode('');
        return (object) $d;
    });

    // ─── Mock ACCREDITATIONS ───
    $accreditations = collect([
        ['name' => 'NABH Accredited', 'issuing_body' => 'National Healthcare Board', 'year' => 2020, 'expiry_year' => 2028],
        ['name' => 'JCI Certified',    'issuing_body' => 'Joint Commission International', 'year' => 2019, 'expiry_year' => 2027],
        ['name' => 'ISO 9001:2015',    'issuing_body' => 'ISO',                            'year' => 2021, 'expiry_year' => null],
    ])->map(fn($a) => (object) $a);

    // ─── Build CLINIC as an object with all relations ───
    $clinic = (object) [
        'id'                 => 1,
        'slug'               => 'aura-health-delhi',
        'name'               => 'Aura Health Delhi',
        'tagline'            => 'Excellence in cardiac care since 2010',
        'specialty'          => 'Cardiology',
        'about'              => 'Premier medical center dedicated to excellence in patient care and cutting-edge treatment. Our facility combines state-of-the-art technology with compassionate care from globally recognized specialists.',
        'cover_image_url'    => 'https://picsum.photos/seed/clinic-cover/1600/700',
        'logo_url'           => 'https://picsum.photos/seed/clinic-logo/200/200',
        'city'               => 'Delhi',
        'address'            => '123 Main Road, Connaught Place',
        'phone'              => '+91 98765 43210',
        'email'              => 'info@aurahealth.example.com',
        'website'            => 'https://aurahealth.example.com',
        'years_in_operation' => 15,
        'rating'             => 4.7,
        'review_count'       => $reviews->count(),
        'amenities'          => ['Free Wi-Fi','Parking','Wheelchair Accessible','Cafeteria','Pharmacy','Lab on Premises'],
        'insurances'         => ['Star Health','HDFC ERGO','ICICI Lombard','New India Assurance','Bajaj Allianz'],
        'opening_hours'      => [
            ['day' => 'Monday',    'open' => '08:00', 'close' => '20:00', 'is_closed' => false],
            ['day' => 'Tuesday',   'open' => '08:00', 'close' => '20:00', 'is_closed' => false],
            ['day' => 'Wednesday', 'open' => '08:00', 'close' => '20:00', 'is_closed' => false],
            ['day' => 'Thursday',  'open' => '08:00', 'close' => '20:00', 'is_closed' => false],
            ['day' => 'Friday',    'open' => '08:00', 'close' => '20:00', 'is_closed' => false],
            ['day' => 'Saturday',  'open' => '09:00', 'close' => '17:00', 'is_closed' => false],
            ['day' => 'Sunday',    'open' => null,    'close' => null,    'is_closed' => true],
        ],
        // Relations
        'reviews'        => $reviews,
        'doctors'        => $doctors,
        'accreditations' => $accreditations,
    ];

    // ─── Compute avg rating & distribution ───
    $avgRating = $clinic->reviews->count() > 0
        ? round($clinic->reviews->avg('rating'), 1)
        : (float) $clinic->rating;

    $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    foreach ($clinic->reviews as $r) {
        if (isset($ratingCounts[$r->rating])) {
            $ratingCounts[$r->rating]++;
        }
    }

    $stats = [
        'patients'     => 1240,
        'doctors'      => $clinic->doctors->count(),
        'wait_time'    => 12,
        'satisfaction' => 96,
    ];
 
    return view('client.clinic-details', compact('clinic', 'stats', 'ratingCounts', 'avgRating'));
}

}
