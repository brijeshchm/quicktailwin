<?php

namespace App\Helpers;

class BusinessOverviewGenerator
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
	
	
	// public static function generate(
    //     $client,
    //     string $workingHoursHtml = '',
    //     ?string $categorySlug = null
    // ): array {
    //     $business = trim($client->business_name ?? 'this business');
    //     $area     = trim($client->area ?? '');
    //     $city     = trim($client->city ?? '');

    //     $location = implode(', ', array_filter([
    //         $area,
    //         $city,
    //     ]));

    //     $slug = strtolower(
    //         trim($categorySlug ?? $client->category_service ?? '')
    //     );

    //     $template = self::detectTemplate($slug);

    //     if (!method_exists(self::class, $template)) {
    //         $template = 'generic';
    //     }

    //     return self::$template(
    //         $business,
    //         $area,
    //         $city,
    //         $location,
    //         $workingHoursHtml
    //     );
    // }

    // private static function detectTemplate(string $slug): string
    // {
    //     $map = getOverViewBusiness($slug);

    //     if (!is_array($map)) {
    //         return 'generic';
    //     }

    //     foreach ($map as $needle => $template) {
    //         $needle = strtolower(trim($needle));

    //         if ($needle !== '' && str_contains($slug, $needle)) {
    //             return $template;
    //         }
    //     }

    //     return 'generic';
    // }

    // private static function generic(
    //     string $business,
    //     string $area,
    //     string $city,
    //     string $location,
    //     string $workingHoursHtml
    // ): array {
    //     return [
    //         'title' => "{$business} in {$city}",
    //         'description' => "{$business} provides professional services"
    //             . ($location !== '' ? " in {$location}" : '')
    //             . '.',
    //         'working_hours' => $workingHoursHtml,
    //     ];
    // }


 


    private static function weddingBand(
        string $business,
        string $area,
        string $city,
        string $location,
        string $workingHoursHtml
    ): array {
        return [
            'title' => "Wedding Band Services by {$business} in {$city}",
            'description' => "{$business} provides wedding band, band baja and baraat services"
                . ($location !== '' ? " in {$location}" : '')
                . '.',
            'working_hours' => $workingHoursHtml,
        ];
    }
	

   public static function generate($client, string $workingHoursHtml = '', ?string $categorySlug = null)
    {
        $business = trim($client->business_name ?? 'this business');
        $area     = trim($client->area ?? '');
        $city     = trim($client->city ?? '');
        $location = trim("{$area}, {$city}", ', ');

        $slug = strtolower($categorySlug ??  $client->category_service ?? '');
 
        $template = self::detectTemplate($slug);
 
        return self::{$template}($business, $area, $city, $location, $workingHoursHtml);
    }

    /*
     * Map a service slug → template method name.
     */
    private static function detectTemplate($slug)
    {
      $map = getOverViewBusiness($slug);
 
        foreach ($map as $needle => $template) {
            if (str_contains($slug, $needle)) {
                return $template;
            }
        }
        return 'generic';
    }

private static function training($business, $area, $city, $location, $hours): string
{
    return "{$business} in {$location} is a leading training institute in {$city}, offering professional courses and skill-development programs for students, working professionals, and career changers. From technical certifications to soft-skill workshops, the institute provides hands-on training, real-world projects, doubt-clearing sessions, flexible weekday, weekend, and fast-track batches, and dedicated placement support. {$hours} Whether you want to develop skills in IT, finance, management, digital marketing, or vocational courses, {$business} offers experienced trainers, modern infrastructure, and career-focused programs to help you achieve professional growth.";
}

private static function acRepair($business, $area, $city, $location, $hours): string
{
    return "{$business} in {$location} is a trusted AC repair and service provider in {$city}, offering installation, uninstallation, servicing, gas refilling, deep cleaning, PCB repair, compressor replacement, and AMC services for split, window, and central AC systems. {$hours} With trained technicians, genuine spare parts, transparent pricing, same-day doorstep service, and service warranty, {$business} provides reliable AC repair solutions throughout {$area}.";
}

private static function fridgeRepair($business, $area, $city, $location, $hours): string
{
    return "{$business} in {$location} provides reliable refrigerator repair services in {$city} for single-door, double-door, side-by-side, French-door refrigerators, mini-fridges, and deep freezers. Skilled technicians repair cooling problems, water leakage, ice build-up, compressor faults, gas leakage, thermostat issues, and noisy operation. {$hours} With quick doorstep service, genuine spare parts, transparent pricing, and experienced technicians, {$business} delivers dependable refrigerator repair services across {$area}.";
}

private static function waterPurifierRepair($business, $area, $city, $location, $hours): string
{
    return "{$business} in {$location} is a trusted water purifier repair and service provider in {$city}, covering RO, UV, UF, and gravity-based water purifiers. Services include filter replacement, membrane replacement, motor repair, TDS adjustment, leakage repair, candle replacement, and annual maintenance contracts. {$hours} With trained technicians, genuine spare parts, transparent pricing, quick doorstep service, and post-service warranty, {$business} helps households across {$area} maintain clean and safe drinking water.";
}

private static function laptopRepair($business, $area, $city, $location, $hours): string
{
    return "{$business} in {$location} provides professional laptop repair services in {$city} for Dell, HP, Lenovo, Acer, Asus, Apple MacBook, Microsoft Surface, MSI, and other brands. Services include screen replacement, keyboard repair, battery replacement, motherboard repair, hinge repair, virus removal, operating-system installation, SSD and RAM upgrades, and data recovery. {$hours} With honest diagnostics, genuine spare parts, quick turnaround, doorstep service, and reliable warranty, {$business} is a trusted laptop repair provider across {$area}.";
}

private static function computerRepair($business, $area, $city, $location, $hours): string
{
    return "{$business} in {$location} provides complete computer and desktop repair services in {$city}, including hardware repair, operating-system installation, virus removal, data recovery, network and Wi-Fi setup, RAM and SSD upgrades, printer setup, and home or office IT support. {$hours} With skilled engineers, transparent pricing, on-site service, remote support, and AMC plans, {$business} provides dependable computer repair solutions to homes and businesses across {$area}.";
}
 
  



    // ── 9. CAR REPAIR ──
    private static function carRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted car repair and servicing centre in {$city}, offering periodic maintenance, engine repair, AC service, brake and clutch repair, denting and painting, battery replacement, tyre alignment and balancing, oil change, and complete bodywork. The garage serves all car brands — Maruti Suzuki, Hyundai, Tata, Mahindra, Honda, Toyota, Kia, Renault, Skoda, Volkswagen, Ford, and luxury cars.{$hours} With skilled mechanics, advanced diagnostic tools, and genuine spare parts, {$business} in {$location} delivers professional car care at honest prices. Customers across {$area} trust {$business} for transparent estimates, on-time delivery, and post-service warranty. Visit today for a free vehicle health check-up in {$city}.";
    }

    // ── 10. BIKE REPAIR ──
    private static function bikeRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a reliable bike and two-wheeler repair shop in {$city}, offering periodic servicing, engine work, tyre change, chain repair, brake adjustment, battery replacement, electrical repairs, denting, painting, and accessory fitting. The team services all brands — Hero, Bajaj, TVS, Honda, Yamaha, Suzuki, Royal Enfield, KTM, and electric bikes.{$hours} Riders across {$area} trust {$business} in {$location} for skilled mechanics, genuine parts, and quick turnaround. With transparent service charges and pickup-drop options in {$city}, {$business} keeps your bike road-ready, fuel-efficient, and safe. Book your bike service today.";
    }

    // ── 11. BANQUET HALL ──
    private static function banquetHall($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a premium banquet hall in {$city}, ideal for weddings, receptions, sangeet, engagement ceremonies, birthday parties, corporate events, and social gatherings. The venue offers spacious seating, air-conditioned halls, modern lighting, sound systems, ample parking, valet service, dedicated bridal rooms, and in-house catering with multi-cuisine options.{$hours} From small intimate functions to grand celebrations, {$business} in {$location} provides flexible packages, customized décor, and professional event support to make every occasion memorable. With elegant interiors, attentive staff, and a prime location in {$area}, {$business} is among the most preferred banquet halls in {$city}. Book your date today.";
    }

    

    // ── 14. WEDDING PHOTOGRAPHY ──
    private static function weddingPhotography($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading wedding photography and videography service in {$city}, capturing every emotion of your big day with cinematic style. Specializations include candid photography, traditional photography, pre-wedding shoots, post-wedding shoots, drone videography, cinematic wedding films, photo albums, same-day edits, and live event coverage.{$hours} Working with the latest camera equipment, drones, gimbals, and editing software, the creative team at {$business} in {$location} crafts stunning visual stories that you will treasure forever. Couples across {$area} and {$city} choose {$business} for its artistic eye, professional handling, and timely delivery. Book your wedding photographer today and preserve memories that last a lifetime.";
    }

    // ── 15. WEDDING DECORATION / FLOWER DECORATION ──
    private static function weddingDecoration($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a creative wedding and event decoration specialist in {$city}, offering stunning stage décor, mandap decoration, entrance gates, fresh flower decoration, themed décor, fairy light setups, balloon decoration, and customized backdrops for weddings, engagements, receptions, birthdays, and corporate events.{$hours} From traditional Indian themes to modern minimalist setups, {$business} in {$location} blends fresh flowers, fabric drapes, premium lighting, and on-trend styling to transform any venue into a dream space. Trusted by families across {$area} and {$city}, {$business} delivers turnkey decoration with creative concepts and on-time setup. Book a free consultation today.";
    }

    // ── 16. VARMALA / JAIMALA ──
    private static function varmala($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides spectacular varmala and jaimala entry services in {$city} — from elegant manual entries to grand mechanical varmala setups, hydraulic platforms, revolving stages, rotating jaimala thaalis, dry ice effects, LED-lit garlands, and themed bride-groom entries. Every setup is custom-designed to match your wedding theme and venue.{$hours} Make your varmala ceremony the highlight of your wedding with {$business} in {$location}. Trusted by couples across {$area} and {$city}, the experienced team handles design, installation, special effects, and safety with precision. Add cinematic magic to your jaimala moment — enquire today for available designs and packages.";
    }

    // ── 17. WEDDING CHOREOGRAPHER ──
    private static function weddingChoreographer($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers professional wedding choreography services in {$city} for sangeet, mehndi, haldi, reception, and engagement functions. The choreographers specialize in couple dance, family group dance, Bollywood choreography, classical, hip-hop, lyrical, and themed performances — designed to match every skill level from beginners to dance enthusiasts.{$hours} With customized song selection, easy-to-learn routines, costume guidance, and stage presentation tips, {$business} in {$location} makes every performance unforgettable. Couples and families across {$area} and {$city} trust {$business} for energetic, joyful, and rehearsal-friendly choreography. Book your sessions today and shine on the dance floor.";
    }

    // ── 18. WEDDING ORGANISER / PLANNER ──
    private static function weddingOrganiser($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a complete wedding planning and event management company in {$city}, offering end-to-end services — venue booking, decoration, catering, photography, hospitality, transport, guest management, choreography, baraat services, return gifts, invitations, and destination wedding coordination.{$hours} From intimate weddings to grand celebrations, {$business} in {$location} delivers stress-free planning, on-budget execution, and creative direction tailored to every culture and tradition. Families across {$area} and {$city} count on {$business} to bring their dream wedding to life. Schedule a planning consultation today and let the experts handle the rest.";
    }

    // ── 19. ASTROLOGER ──
    private static function astrologer($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a renowned astrology and Vedic consultation service in {$city}, offering marriage matching (kundli milan), guna milan, birth chart analysis, horoscope reading, gemstone recommendations, vastu consultancy, palmistry, numerology, muhurat selection, and remedies for life challenges.{$hours} With years of experience in Vedic astrology, {$business} in {$location} provides accurate, ethical, and confidential guidance to clients across {$area} and {$city}. From wedding date selection to compatibility checks, get trusted insights that bring clarity and peace of mind. Book a session today — in-person or online consultations available.";
    }

    // ── 20. GHODA BAGGI ──
    private static function ghodaBaggi($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers premium ghoda baggi (horse carriage) and decorated horse services in {$city} for weddings, baraats, processions, ring ceremonies, and special events. Choose from royal Rajasthani-style baggis, vintage carriages, decorated horses with traditional ornaments, and themed setups complete with sherwani-clad coachmen.{$hours} Make your baraat unforgettable with the regal arrival of a beautifully adorned ghoda baggi from {$business} in {$location}. Trusted by families across {$area} and {$city}, the team ensures well-groomed horses, on-time service, and safety throughout the procession. Book your wedding baggi today.";
    }

    

    // ── 22. COLD FIRE / FOG EFFECT ──
    private static function coldFire($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} specializes in cold fire (cold pyro), fog effects, dry ice setups, LED confetti blasters, sparkular machines, smoke jets, and special-effect lighting for weddings, varmala entries, sangeet events, corporate functions, and stage shows in {$city}.{$hours} Create breathtaking entry moments with the safe, smoke-free, indoor-friendly effects from {$business} in {$location}. Trusted by event planners across {$area} and {$city}, every setup is operated by trained technicians ensuring safety, timing, and visual brilliance. Book cold fire and fog effects today for an unforgettable celebration.";
    }

     

    // // ── 25. GENERIC FALLBACK (any uncategorized service) ──
    private static function generic($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted service provider in {$city}, known for quality, reliability, and customer satisfaction. With experienced professionals, modern tools, and a strong commitment to service excellence, {$business} It caters to a wide range of customer needs across {$city} and is open from {$hours} From first contact to job completion, {$business} in {$location} ensures transparent pricing, on-time service, and quality outcomes that customers in {$city} can count on. Whether for one-time service or ongoing requirements, {$business} stands as a reliable choice. Get in touch today to learn more or schedule a visit.";
    }


 // ── 1. DOCTORS ──
    private static function doctors($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted clinic in {$city} offering expert consultation by experienced doctors across general medicine, paediatrics, gynaecology, orthopaedics, ENT, cardiology, dermatology, diabetes care, and chronic disease management. Patients receive accurate diagnosis, prescribed treatment plans, lab test referrals, second opinions, and structured follow-up care all under one roof.{$hours} Trusted by families across {$area} and {$city}, {$business} in {$location} is known for qualified MBBS and MD specialists, hygienic facilities, minimal waiting time, transparent consultation fees, and complete medical guidance for every age group. Book your appointment today for reliable, patient-first medical care from doctors near you.";
    }

    // ── 2. HOSPITAL ──
    private static function hospital($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading multi-speciality hospital in {$city} offering 24×7 emergency care, ICU, surgery, maternity services, diagnostics, pathology lab, pharmacy, and inpatient facilities. With specialists in cardiology, neurology, orthopaedics, paediatrics, oncology, and general surgery, the hospital is equipped to handle both routine treatments and critical care.{$hours} Patients across {$area} and {$city} choose {$business} in {$location} for its experienced doctors, modern equipment, cashless insurance support, ambulance services, and dedicated nursing staff. Whether you need a planned procedure, emergency admission, or specialist consultation, {$business} ensures safe, affordable, and high-quality healthcare for every patient.";
    }

    // ── 3. DENTIST ──
    private static function dentist($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading dental clinic in {$city} offering complete oral care including teeth cleaning, scaling, root canal treatment, dental implants, braces, aligners, cosmetic dentistry, kids dentistry, wisdom tooth removal, and full-mouth rehabilitation. Modern sterilisation protocols, digital X-rays, and painless procedures make every visit comfortable.{$hours} Patients across {$area} and {$city} trust {$business} in {$location} for honest treatment plans, transparent pricing, EMI options, and skilled BDS and MDS dentists. Book your dental check-up today and get expert care for healthier teeth and a brighter smile.";
    }

    // ── 4. MEDICAL SHOP ──
    private static function medicalShop($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted medical store in {$city} offering a wide range of prescription medicines, OTC drugs, generic alternatives, surgical items, ayurvedic products, baby care, and personal hygiene essentials. All medicines are sourced directly from authorised distributors and stored under proper temperature conditions for full efficacy.{$hours} Customers across {$area} and {$city} rely on {$business} in {$location} for genuine medicines, fast home delivery, competitive prices, monthly discounts on chronic medication, and friendly pharmacist support. Visit or call today to refill prescriptions or order essential health products.";
    }

    // ── 5. MEDICAL EQUIPMENT ──
    private static function medicalEquipment($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} supplies a complete range of medical equipment in {$city} including hospital beds, wheelchairs, oxygen concentrators, BiPAP and CPAP machines, nebulisers, BP monitors, glucometers, walking aids, and surgical instruments. Equipment is available for both sale and rent with installation and after-sales support.{$hours} Hospitals, clinics, and home users across {$area} and {$city} trust {$business} in {$location} for branded products, warranty coverage, doorstep delivery, and on-site service. Contact today for personalised quotes on home care or hospital-grade medical equipment.";
    }

    // ── 6. PATIENT CARE ──
    private static function patientCare($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers professional patient care services in {$city} including trained attendants, nurses, post-surgery care, elderly care, bedridden patient support, physiotherapy assistance, and 24-hour home nursing. Caregivers are background-verified and trained in hygiene, medication schedules, mobility support, and emergency response.{$hours} Families across {$area} and {$city} rely on {$business} in {$location} for compassionate, reliable, and affordable home care that respects patient dignity. Book a caregiver today for short-term recovery support or long-term elderly care at home.";
    }

    // ── 7. YOGA ──
    private static function yoga($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a popular yoga studio in {$city} offering classes in Hatha yoga, Ashtanga, Vinyasa flow, Power yoga, Pranayama, meditation, prenatal yoga, and therapeutic yoga for back pain, stress, diabetes, and weight loss. Sessions are led by certified yoga teachers in small batches for personalised attention.{$hours} Students across {$area} and {$city} choose {$business} in {$location} for its peaceful environment, flexible morning and evening batches, online classes, and structured progress tracking. Start your yoga journey today and experience better flexibility, strength, focus, and overall well-being.";
    }

    // ── 8. GYM ──
    private static function gym($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a fully equipped gym in {$city} offering strength training, cardio, CrossFit, Zumba, HIIT, personal training, weight loss programs, muscle gain plans, and sports-specific conditioning. The facility features modern equipment, certified trainers, diet consultation, and clean changing rooms with showers.{$hours} Fitness enthusiasts across {$area} and {$city} pick {$business} in {$location} for affordable membership plans, flexible timings, group classes, and a motivating community. Sign up today for a free trial and start your transformation with expert coaching and a results-driven workout plan.";
    }

    // ── 9. HEALTH WELLNESS (catch-all) ──
    private static function healthWellness($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted health and wellness centre in {$city} offering therapies, fitness coaching, weight management, holistic healing, ayurveda, naturopathy, physiotherapy, and lifestyle counselling. Services are designed to improve physical fitness, mental well-being, and long-term health.{$hours} Clients across {$area} and {$city} visit {$business} in {$location} for expert practitioners, personalised wellness plans, clean facilities, and visible results. Book your first wellness consultation today and start a healthier, balanced lifestyle.";
    }

    // ── 10. SPA ──
    private static function spa($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a premium spa in {$city} offering Swedish massage, deep tissue therapy, Thai massage, Balinese massage, aromatherapy, foot reflexology, body scrubs, couple spa packages, and detox treatments. The relaxing ambience, trained therapists, and hygienic linens deliver a complete rejuvenation experience.{$hours} Guests across {$area} and {$city} prefer {$business} in {$location} for genuine therapies, transparent pricing, no upselling, and exclusive monthly memberships. Book a spa session today and unwind from stress, body pain, and a busy lifestyle.";
    }

    // ── 11. BEAUTY PARLOUR ──
    private static function beautyParlour($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a well-known beauty parlour in {$city} offering facials, threading, waxing, hair spa, hair colour, keratin treatment, manicure, pedicure, bridal makeup, party makeup, and skin clean-ups. Premium products from L'Oréal, MAC, O3+, and Lotus Herbals are used for safe, long-lasting results.{$hours} Women across {$area} and {$city} trust {$business} in {$location} for skilled beauticians, hygienic equipment, on-time service, and budget-friendly combo packages. Walk in today or book your appointment for a complete beauty makeover.";
    }

    // ── 12. SALON ──
    private static function salon($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a top unisex salon in {$city} offering haircut, hair styling, beard grooming, hair colour, hair smoothening, head massage, facials, clean-ups, and pre-wedding grooming packages. The salon uses branded products and follows strict hygiene with sanitised tools and single-use disposables.{$hours} Clients across {$area} and {$city} prefer {$business} in {$location} for stylish cuts, trending hair colours, friendly staff, and value-for-money pricing. Book your slot online or walk in to experience a fresh, modern grooming session.";
    }

     
    // ── 13. AC SERVICE ──
    private static function acService($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers professional AC service in {$city} including AC installation, gas refilling, deep cleaning, repair, uninstallation, PCB and compressor replacement, and annual maintenance contracts (AMC) for split, window, cassette, and central AC units across all brands like LG, Samsung, Daikin, Voltas, Hitachi, and Blue Star.{$hours} Customers across {$area} and {$city} trust {$business} in {$location} for trained technicians, original spare parts, transparent pricing, same-day service, and post-service warranty. Book your AC service today for efficient cooling, lower power bills, and longer machine life.";
    }

    // ── 14. CAR SERVICE ──
    private static function carService($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a full-service car workshop in {$city} offering general service, oil and filter changes, brake repair, AC servicing, battery replacement, denting and painting, wheel alignment, balancing, suspension work, and computerised diagnostics for hatchbacks, sedans, SUVs, and luxury cars.{$hours} Car owners across {$area} and {$city} rely on {$business} in {$location} for genuine OEM spares, certified mechanics, pickup and drop service, transparent estimates, and post-service warranty. Book your car service today and keep your vehicle running smoothly and safely.";
    }

    // ── 15. ELECTRIC CAR SERVICE ──
    private static function electricCarService($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} specialises in electric car service in {$city} covering battery diagnostics, BMS (Battery Management System) inspection, motor and controller repair, charging port issues, software updates, brake servicing, suspension checks, and full periodic maintenance for Tata, MG, Mahindra, Hyundai, BYD, and Tesla EVs.{$hours} EV owners across {$area} and {$city} trust {$business} in {$location} for trained EV technicians, certified diagnostic tools, original parts, doorstep pickup, and transparent service estimates. Book your electric car service today and ensure peak range, battery health, and long-term performance.";
    }

    // ── 16. ELECTRIC BIKE SERVICE ──
    private static function electricBikeService($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers expert electric bike service in {$city} including battery testing, motor repair, controller replacement, charger diagnostics, brake service, tyre replacement, and full periodic maintenance for Ola, Ather, TVS iQube, Bajaj Chetak, Hero Electric, and other top EV scooter brands.{$hours} EV scooter owners across {$area} and {$city} choose {$business} in {$location} for certified technicians, genuine spares, doorstep service options, and transparent service costs. Schedule your electric bike service today for smooth rides, better range, and longer battery life.";
    }

    // ── 17. CAR TOWING ──
    private static function carTowing($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides reliable 24×7 car towing services in {$city} including flatbed towing, accident vehicle recovery, breakdown assistance, jump start, on-spot tyre change, fuel delivery, and inter-city towing for cars, SUVs, vintage cars, and luxury vehicles.{$hours} Motorists across {$area} and {$city} rely on {$business} in {$location} for fast response times, insured towing, trained crew, and damage-free transport. Save the number — call {$business} the moment you face a breakdown or accident.";
    }

    // ── 18. LAPTOP REPAIR ──
      

    // ── 20. MOBILE REPAIR ──
    private static function mobileRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading mobile phone repair centre in {$city} offering display replacement, battery change, charging port repair, water damage recovery, motherboard repair, software flashing, and unlocking services for iPhone, Samsung, OnePlus, Vivo, Oppo, Realme, Xiaomi, and Nothing phones.{$hours} Mobile users across {$area} and {$city} prefer {$business} in {$location} for original spare parts, ISO-grade tools, transparent quotes, same-day service, and up to 6-month repair warranty. Bring your phone in today and walk out with a fully functional device.";
    }

    // ── 21. REFRIGERATOR REPAIR ──
    private static function refrigeratorRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides expert refrigerator repair in {$city} for single-door, double-door, side-by-side, and triple-door fridges from LG, Samsung, Whirlpool, Godrej, Haier, Bosch, and Panasonic. Services include gas refilling, compressor replacement, thermostat issues, water leakage, ice formation, and PCB repair.{$hours} Households across {$area} and {$city} call {$business} in {$location} for trained technicians, doorstep service, transparent rates, and 90-day service warranty. Book a refrigerator repair today and stop food spoilage with same-day fixes.";
    }

    // ── 22. TV REPAIR ──
    private static function tvRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} specialises in TV repair in {$city} for LED, LCD, OLED, QLED, plasma, and smart TVs across Sony, Samsung, LG, MI, OnePlus, TCL, and Panasonic. Common services include display replacement, backlight repair, power supply issues, motherboard repair, smart features setup, and HDMI port fixes.{$hours} TV owners across {$area} and {$city} rely on {$business} in {$location} for free diagnosis, fast doorstep service, original spare parts, and clear service quotes. Call today and get your TV back to perfect picture and sound quality.";
    }

    // ── 23. WASHING MACHINE REPAIR ──
    private static function washingMachineRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers reliable washing machine repair services in {$city} for fully automatic, semi-automatic, top-load, and front-load machines from IFB, LG, Samsung, Whirlpool, Bosch, Godrej, and Haier. Services cover drum noise, water leakage, drainage issues, PCB faults, motor repair, and door lock problems.{$hours} Households across {$area} and {$city} choose {$business} in {$location} for skilled technicians, original spares, transparent pricing, and 90-day repair warranty. Book your washing machine repair today and avoid laundry pile-ups.";
    }

    // ── 24. SOFA REPAIR ──
    private static function sofaRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides complete sofa repair and refurbishment services in {$city} including foam replacement, cushion repair, frame fixing, recliner mechanism repair, leather restoration, fabric change, and full sofa re-upholstery in trending fabrics and premium leatherette.{$hours} Customers across {$area} and {$city} trust {$business} in {$location} for skilled craftsmen, doorstep estimation, branded fabrics, and on-time delivery. Bring your old sofa back to life — book a free home inspection today and choose from hundreds of design options.";
    }

    // ── 25. COOLER REPAIR ──
    private static function coolerRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers fast air cooler repair services in {$city} including motor replacement, pump repair, water leakage fixing, fan blade replacement, cooling pad change, and full servicing for desert, tower, personal, and industrial coolers across Symphony, Bajaj, Crompton, Kenstar, Usha, and Voltas.{$hours} Households and shopkeepers across {$area} and {$city} rely on {$business} in {$location} for same-day doorstep service, original spares, transparent pricing, and post-service warranty. Book a cooler repair today and stay cool through the summer.";
    }

    // ── 26. WATER GEYSER REPAIR ──
    private static function waterGyserRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides expert water geyser repair services in {$city} covering instant geysers, storage geysers, gas geysers, and solar water heaters from Bajaj, Havells, AO Smith, Racold, Crompton, and Venus. Services include heating element replacement, thermostat repair, leakage fixing, and full descaling.{$hours} Homeowners across {$area} and {$city} rely on {$business} in {$location} for trained technicians, genuine parts, fast same-day service, and transparent service costs. Book your geyser repair today and enjoy uninterrupted hot water at home.";
    }

    // ── 27. KITCHEN CHIMNEY REPAIR ──
    private static function kitchenChimneyRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers professional kitchen chimney repair and cleaning services in {$city} including filter replacement, deep degreasing, motor repair, switch and LED replacement, and complete servicing for auto-clean, baffle, and cassette filter chimneys from Faber, Elica, Glen, Hindware, Kaff, and Sunflame.{$hours} Homemakers across {$area} and {$city} prefer {$business} in {$location} for trained chimney technicians, eco-friendly cleaning chemicals, doorstep service, and transparent pricing. Book a chimney service today and restore strong suction and a clean, smoke-free kitchen.";
    }

    // ── 28. GAS STOVE REPAIR ──
    private static function gasStoveRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides quick and safe gas stove repair services in {$city} including burner cleaning, knob replacement, auto-ignition repair, gas leakage check, regulator issues, hose replacement, and complete servicing for 2-burner, 3-burner, 4-burner, glass top, and built-in hobs.{$hours} Households across {$area} and {$city} trust {$business} in {$location} for trained technicians, original spares, fast doorstep service, and full safety inspection at every visit. Book a gas stove repair today for safe and efficient cooking.";
    }

    // ── 29. WATER PUMP REPAIR ──
    private static function waterPumpRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers complete water pump repair services in {$city} covering submersible pumps, monoblock pumps, jet pumps, borewell pumps, and pressure boosters from Kirloskar, Crompton, Havells, CRI, KSB, and Texmo. Services include motor rewinding, impeller replacement, capacitor repair, and full overhauling.{$hours} Homeowners and farmers across {$area} and {$city} rely on {$business} in {$location} for skilled mechanics, genuine parts, on-site service, and AMC plans for societies and farms. Book your water pump repair today for an uninterrupted water supply.";
    }

    // ── 30. INDUCTION STOVE REPAIR ──
    private static function inductionStoveRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides expert induction stove and cooktop repair services in {$city} including glass top replacement, sensor repair, IGBT and PCB issues, error code troubleshooting, and full servicing for Prestige, Bajaj, Pigeon, Philips, Havells, and Sunflame induction units.{$hours} Households across {$area} and {$city} trust {$business} in {$location} for trained technicians, original parts, doorstep service, and clear service warranties. Book your induction stove repair today and keep your kitchen running without interruption.";
    }

    // ── 31. HOME APPLIANCES REPAIR (catch-all) ──
    private static function homeAppliancesRepair($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a one-stop home appliance repair service in {$city} covering AC, refrigerator, washing machine, microwave, geyser, chimney, cooler, gas stove, induction stove, water purifier, and TV repairs across all major brands including LG, Samsung, Whirlpool, Bosch, IFB, and Haier.{$hours} Customers across {$area} and {$city} rely on {$business} in {$location} for trained multi-brand technicians, doorstep service, original parts, AMC packages, and transparent pricing. Call once and get every appliance fixed under one roof.";
    }

    // ── 32. ELECTRIC SERVICES ──
    private static function electricServices($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers complete electrical services in {$city} including new wiring, rewiring, switchboard repair, MCB and ELCB installation, inverter setup, fan installation, light fitting, geyser installation, AC point work, and full electrical maintenance for homes, offices, and shops.{$hours} Property owners across {$area} and {$city} trust {$business} in {$location} for licensed electricians, ISI-marked materials, safe earthing, fair pricing, and post-service warranty. Call today for any electrical repair, installation, or full house wiring requirement.";
    }

    // ── 33. CARPENTER ──
    private static function carpenter($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides professional carpentry services in {$city} including modular wardrobe making, modular kitchen, TV unit, study table, bed and headboard, door and window repair, hinge and lock fitting, and complete custom furniture in plywood, MDF, particle board, and solid wood.{$hours} Homeowners across {$area} and {$city} hire {$business} in {$location} for skilled carpenters, accurate measurements, branded hardware, on-time delivery, and transparent quotes. Book a site visit today and transform your space with quality woodwork.";
    }

    // ── 34. PAINTER ──
    private static function painter($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers professional painting contractor services in {$city} including interior wall painting, exterior weatherproof painting, wood polishing, metal painting, texture paints, distemper, emulsion, enamel, and waterproof coatings using Asian Paints, Berger, Nerolac, and Dulux products.{$hours} Homeowners across {$area} and {$city} choose {$business} in {$location} for skilled painters, dust-free finishes, on-time project delivery, free shade consultation, and transparent labour rates. Get a free site visit today for a fresh, modern paint job.";
    }

    // ── 35. CIVIL CONTRACTOR ──
    private static function civilContractor($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a reliable civil contractor in {$city} offering full house construction, renovation, slab casting, flooring, tiling, plastering, brickwork, waterproofing, and turnkey project execution for residential, commercial, and industrial sites. Materials, labour, and supervision are all handled in-house.{$hours} Clients across {$area} and {$city} trust {$business} in {$location} for licensed engineers, ISI-grade materials, structured timelines, transparent BOQs, and quality control at every stage. Schedule a site survey today and get a detailed construction or renovation quote.";
    }

    // ── 36. HOME CONSTRUCTION ──
    private static function homeConstruction($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers turnkey home construction services in {$city} from plot survey, architectural design, structural drawings, foundation, RCC slab, plumbing, electrical, plastering, flooring, painting, and final finishing. Every project is executed under licensed civil engineer supervision with ISI-grade materials.{$hours} Homeowners across {$area} and {$city} trust {$business} in {$location} for transparent per-square-foot pricing, milestone-based payments, BOQ-driven estimates, on-time delivery, and post-handover support. Book a free site visit today and start building your dream home with confidence.";
    }

    // ── 37. HOME FURNITURE ──
    private static function homeFurniture($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a premium home furniture and decoration store in {$city} offering modular sofas, dining sets, beds, wardrobes, study tables, TV units, recliners, kids furniture, and complete home furnishing solutions in solid wood, engineered wood, and metal finishes.{$hours} Customers across {$area} and {$city} love {$business} in {$location} for modern designs, durable build, free home delivery, expert installation, and EMI options. Visit the showroom or order online today and give your home a refreshed, stylish look.";
    }

    // ── 38. INTERIOR DESIGNER ──
    private static function interiorDesigner($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a top interior designer in {$city} offering modular kitchens, walk-in wardrobes, false ceilings, TV units, wall panelling, lighting design, 3D visualisation, and full home and office interior turnkey solutions in modern, contemporary, minimalist, and luxury styles.{$hours} Homeowners across {$area} and {$city} choose {$business} in {$location} for award-winning designers, branded hardware (Hettich, Hafele, Blum), transparent BOQs, on-time delivery, and 5-year service warranty. Book a free design consultation today and transform your home or office.";
    }

    // ── 39. CLEANING SERVICES ──
    private static function cleaningServices($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers professional cleaning services in {$city} including deep home cleaning, kitchen and bathroom scrubbing, sofa and carpet shampooing, mattress cleaning, office cleaning, post-construction cleaning, and full sanitisation using eco-friendly chemicals and machine-based methods.{$hours} Homes and offices across {$area} and {$city} trust {$business} in {$location} for trained crews, branded chemicals, fixed-price packages, and same-day booking. Book a deep cleaning today and enjoy a fresh, hygienic, and germ-free space.";
    }

    // ── 40. HOUSEKEEPING ──
    private static function housekeeping($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides reliable housekeeping services in {$city} for residential societies, corporate offices, hotels, hospitals, schools, and retail outlets. Services include daily cleaning, floor mopping, toilet sanitisation, glass cleaning, pantry maintenance, and uniformed deployment of trained staff.{$hours} Clients across {$area} and {$city} choose {$business} in {$location} for background-verified staff, supervisor visits, EPF/ESI compliance, and structured monthly billing. Request a quote today for daily, weekly, or full-time housekeeping deployment.";
    }

    // ── 41. MAID SERVICE ──
    private static function maidService($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers verified maid and servant services in {$city} including part-time maids, full-time maids, 24-hour live-in helpers, cooks, babysitters, elderly care attendants, and househelp for cleaning, washing, and kitchen work.{$hours} Families across {$area} and {$city} trust {$business} in {$location} for background-verified, Aadhaar-validated staff, free replacement guarantee, and transparent service contracts. Book a maid today and bring reliable, professional help into your home.";
    }

    // ── 42. LAUNDRY SERVICE ──
    private static function laundryService($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a professional laundry and dry cleaning service in {$city} offering wash and fold, steam iron, dry cleaning of suits, sarees, lehengas, blazers, curtains, blankets, sneakers, and leather goods. Pickup and delivery are available across {$area}.{$hours} Customers across {$area} and {$city} prefer {$business} in {$location} for fabric-safe chemicals, hygienic packaging, transparent per-piece pricing, and quick turnaround. Schedule a pickup today and free yourself from laundry hassles.";
    }

    // ── 43. LIFT & ELEVATOR ──
    private static function liftElevator($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers complete lift and elevator solutions in {$city} including new installation, AMC service, modernisation, breakdown repair, rope and roller replacement, ARD installation, and 24×7 emergency support for passenger lifts, home lifts, hospital lifts, freight lifts, and capsule elevators.{$hours} Builders, RWAs, and businesses across {$area} and {$city} trust {$business} in {$location} for certified engineers, OEM-grade spares, safety audits, and government-approved installation. Request a site survey today for a custom lift quote or AMC plan.";
    }

    // ── 44. WELDER & FABRICATION ──
    private static function welder($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides expert welding and fabrication services in {$city} for grills, gates, railings, staircases, MS steel doors, stainless steel works, balcony grills, structural fabrication, and on-site arc and TIG welding for homes, shops, and industrial sites.{$hours} Property owners and contractors across {$area} and {$city} rely on {$business} in {$location} for skilled welders, ISI-grade material, accurate measurements, durable finishing, and on-time delivery. Get a free site quote today for your fabrication project.";
    }
   
    // ── 45. SECURITY SYSTEM ──
    private static function securitySystem($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides advanced security system solutions in {$city} including CCTV camera installation, biometric access control, intercom systems, video door phones, motion sensors, burglar alarms, fire alarm panels, and cloud-based DVR/NVR setups for homes, shops, offices, and societies.{$hours} Property owners across {$area} and {$city} trust {$business} in {$location} for branded products (CP Plus, Hikvision, Dahua), certified installers, AMC plans, and 24×7 technical support. Book a free security audit today and secure your premises with modern surveillance.";
    }

    // ── 46. SECURITY GUARD ──
    private static function securityGuard($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a reliable security guard agency in {$city} providing trained security personnel for residential societies, corporate offices, factories, malls, schools, hospitals, and events. Services include armed guards, unarmed guards, bouncers, gunmen, lady guards, and supervisors with full uniform and equipment.{$hours} Clients across {$area} and {$city} trust {$business} in {$location} for PSARA-licensed services, background-verified staff, EPF/ESI compliance, supervisor patrolling, and 24×7 control room support. Request a quote today for short-term events or long-term security deployment.";
    }

    // ── 47. FIRE SAFETY ──
    private static function fireSafety($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers complete fire safety solutions in {$city} including fire extinguisher sales and refilling, fire alarm panel installation, smoke detectors, sprinkler systems, hydrant systems, fire NOC consultancy, fire audits, and fire safety training for offices, factories, malls, and schools.{$hours} Businesses across {$area} and {$city} rely on {$business} in {$location} for ISI-certified equipment, licensed engineers, AMC packages, and government-approved fire NOC documentation. Schedule a fire safety inspection today and stay 100% compliant and protected.";
    }
     
    // ── 48. REAL ESTATE ──
    private static function realEstate($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted real estate agency in {$city} dealing in residential flats, builder floors, independent houses, plots, farmhouses, commercial shops, office spaces, and rental properties. Verified listings, RERA-approved projects, and end-to-end documentation support are offered for buyers, sellers, and tenants.{$hours} Property seekers across {$area} and {$city} trust {$business} in {$location} for honest deals, on-site visits, home loan assistance, legal verification, and registry support. Connect today to buy, sell, or rent the right property at the right price.";
    }

    // ── 49. PG HOSTEL ──
    private static function pgHostel($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a well-maintained PG and hostel in {$city} offering single, double, and triple-sharing rooms for students and working professionals. Amenities include home-cooked meals, hot water, attached washrooms, AC and non-AC options, Wi-Fi, laundry, weekly housekeeping, and 24×7 security with CCTV.{$hours} Residents from across {$area} and {$city} pick {$business} in {$location} for safe environment, verified staff, hygienic kitchens, and budget-friendly rent plans. Book your PG room today with no brokerage and zero hidden charges.";
    }

    // ── 50. HOTEL ──
    private static function hotel($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a popular hotel in {$city} offering comfortable AC rooms, deluxe and executive suites, family rooms, in-room dining, free Wi-Fi, conference halls, and banquet facilities. The hotel is well connected to major landmarks, railway station, and the airport.{$hours} Travellers across {$area} and {$city} pick {$business} in {$location} for spotless rooms, friendly staff, on-time check-in, multi-cuisine restaurant, and best-rate online bookings. Reserve your stay today and enjoy a relaxed, comfortable visit.";
    }

    // ── 51. 5-STAR HOTEL ──
    private static function fiveStarHotel($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a luxurious 5-star hotel in {$city} offering premium suites, plush rooms, multi-cuisine fine-dining restaurants, world-class spa, swimming pool, fitness centre, business lounges, and grand banquet halls for weddings, conferences, and corporate events.{$hours} Discerning guests across {$area} and {$city} pick {$business} in {$location} for impeccable hospitality, personalised butler service, gourmet dining, and award-winning facilities. Reserve your luxury experience today for an unforgettable stay.";
    }

    // ── 52. BUDGET HOTEL ──
    private static function budgetHotel($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a comfortable budget hotel in {$city} offering clean AC and non-AC rooms, hot water, complimentary breakfast, free Wi-Fi, 24×7 reception, and CCTV-secured premises at pocket-friendly prices for students, families, and business travellers.{$hours} Guests across {$area} and {$city} prefer {$business} in {$location} for honest pricing, hygienic rooms, helpful staff, and easy online booking with no hidden charges. Book your stay today and travel smart without overspending.";
    }

    // ── 53. RESTAURANT ──
    private static function restaurant($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a popular restaurant in {$city} serving a delicious menu of North Indian, South Indian, Chinese, Mughlai, Continental, and tandoori specialities along with desserts, beverages, and family combo meals. The hygienic kitchen, friendly staff, and cosy ambience make every meal memorable.{$hours} Food lovers across {$area} and {$city} pick {$business} in {$location} for fresh ingredients, generous portions, value-for-money pricing, online ordering, and party booking options. Visit today or order online for a complete dining experience.";
    }
 
    // ── 54. FINANCE SERVICE ──
    private static function financeService($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted finance services provider in {$city} offering mutual funds, SIPs, insurance (life, health, motor), tax planning, GST filing, ITR filing, business loans, and personal financial advisory for salaried professionals, business owners, and NRIs.{$hours} Clients across {$area} and {$city} pick {$business} in {$location} for SEBI-registered advisors, transparent commissions, goal-based planning, and end-to-end documentation support. Book a free consultation today and start building long-term wealth.";
    }

    // ── 55. LOAN SERVICE ──
    private static function loanService($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted loan service provider in {$city} offering personal loans, home loans, business loans, education loans, car loans, loan against property, and balance transfers with minimum documentation and competitive interest rates from top banks and NBFCs.{$hours} Borrowers across {$area} and {$city} trust {$business} in {$location} for quick eligibility checks, CIBIL improvement guidance, doorstep documentation, and fast disbursal. Apply today and get the right loan with full transparency and zero hidden charges.";
    }

    // ── 56. ATM ──
    private static function atm($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a conveniently located ATM in {$city} supporting cash withdrawals, mini statements, balance enquiry, PIN change, and card-to-card transfers for all major banks and debit/credit card networks including Visa, MasterCard, RuPay, and American Express.{$hours} Residents and visitors across {$area} and {$city} use {$business} in {$location} for 24×7 access, well-lit premises, CCTV-secured cabins, and reliable uptime. Visit anytime for fast, safe banking transactions near you.";
    }

    // ── 57. TOUR & TRAVEL ──
    private static function tourTravel($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading tour and travel agency in {$city} offering customised holiday packages, group tours, religious yatras, honeymoon trips, international tours, visa assistance, flight bookings, hotel reservations, and cab and bus rentals for domestic and overseas destinations.{$hours} Travellers across {$area} and {$city} trust {$business} in {$location} for transparent itineraries, verified hotels, professional tour managers, and 24×7 on-trip support. Plan your next holiday today and travel stress-free with expertly curated packages.";
    }

    // ── 58. PACKERS & MOVERS ──
    private static function packersMovers($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers professional packers and movers services in {$city} including local shifting, intercity relocation, household goods packing, car and bike transportation, office relocation, and warehousing. Trained crews use bubble wrap, corrugated sheets, wooden crates, and GPS-tracked trucks.{$hours} Families and businesses across {$area} and {$city} rely on {$business} in {$location} for IBA-approved transit, insured cargo, transparent quotations, and on-time delivery. Get a free moving estimate today for a stress-free, damage-free shift.";
    }

    // ── 59. JOB CONSULTANT ──
    private static function jobConsultant($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading job consultancy in {$city} offering placement services for freshers and experienced professionals in IT, BPO, sales, banking, finance, healthcare, engineering, manufacturing, and government-sector roles. Resume building, interview prep, and skill assessment are part of the placement process.{$hours} Job seekers across {$area} and {$city} trust {$business} in {$location} for verified employers, no upfront fees, fast interview scheduling, and post-placement support. Register your profile today and accelerate your career with the right job match.";
    }

    // ── 60. LAWYER ──
    private static function lawyer($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is an experienced lawyer and advocate in {$city} handling civil, criminal, family, matrimonial, divorce, property, cheque bounce, consumer, cyber, corporate, taxation, and high court matters. Legal services include case filing, drafting, notices, agreements, court representation, and out-of-court settlements.{$hours} Clients across {$area} and {$city} trust {$business} in {$location} for honest legal advice, confidentiality, strong courtroom representation, and transparent fees. Book a confidential consultation today and get expert guidance for your legal matter.";
    }

     
    // ── 61. PROFESSIONAL TRAINING (general) ──
    private static function professionalTraining($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a well-known training institute in {$city} offering professional certification courses with practical projects, expert mentors, industry-relevant curriculum, hands-on assignments, mock interviews, and 100% placement assistance for students and working professionals.{$hours} Learners across {$area} and {$city} pick {$business} in {$location} for small batches, flexible timings, online and offline modes, EMI fee options, and lifetime course access. Enrol today and turn your learning into a real career boost.";
    }

    // ── 62. COMPUTER COURSES ──
    private static function computerCourses($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a top computer training institute in {$city} offering courses in Python, Java, C/C++, full-stack web development, MERN, MEAN, data science, machine learning, cloud computing (AWS/Azure), DevOps, SQL, Tally, MS Office, and graphic designing. Every program includes live projects, certifications, and placement support.{$hours} Students and professionals across {$area} and {$city} trust {$business} in {$location} for industry-trained mentors, modern labs, recorded sessions, and verified placement records. Enrol today to build job-ready IT skills and accelerate your tech career.";
    }

    // ── 63. ENGINEERING COURSES ──
    private static function engineeringCourses($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers specialised engineering training courses in {$city} for civil, electrical, electronics, mechanical, embedded systems, robotics, and IoT. Courses cover AutoCAD, Revit, STAAD Pro, MATLAB, PLC/SCADA, PCB design, Arduino, Raspberry Pi, and hands-on industry projects.{$hours} Engineering students and graduates across {$area} and {$city} pick {$business} in {$location} for experienced faculty, certified labs, project guidance, and placement assistance. Enrol today and add high-demand technical skills to your engineering profile.";
    }

    // ── 64. DIGITAL MARKETING TRAINING ──
    private static function digitalMarketingTraining($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading digital marketing training institute in {$city} offering courses in SEO, Google Ads, Meta Ads, social media marketing, email marketing, content marketing, e-commerce marketing, analytics, and AI-powered marketing tools. Every module includes live campaigns and real client projects.{$hours} Students, freelancers, and business owners across {$area} and {$city} pick {$business} in {$location} for Google-certified trainers, hands-on practice, internship opportunities, and placement assistance with leading agencies. Enrol today and turn digital marketing into a high-income career or business growth engine.";
    }

    // ── 65. SHARE MARKET TRAINING ──
    private static function shareMarketTraining($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers practical share market training in {$city} covering stock market basics, technical analysis, fundamental analysis, intraday trading, swing trading, options strategies, futures, commodity, and currency trading using charting platforms like TradingView, Zerodha Kite, and Upstox.{$hours} Traders and investors across {$area} and {$city} trust {$business} in {$location} for SEBI-aware curriculum, live market sessions, mentor support, and risk-management focused strategies. Join the next batch and start making smarter, data-driven trades.";
    }

    // ── 66. ENTRANCE EXAM COACHING (general) ──
    private static function entranceExamCoaching($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a result-oriented entrance exam coaching centre in {$city} preparing students for banking exams, SSC, RRB, state PCS, defence, NDA, CDS, GATE, NTSE, KVPY, polytechnic, teachers' eligibility, and other competitive exams with full classroom, doubt sessions, and weekly tests.{$hours} Aspirants across {$area} and {$city} pick {$business} in {$location} for expert faculty, structured study material, free mock tests, performance tracking, and proven selection record. Enrol today and turn your exam preparation into a guaranteed result.";
    }

    // ── 67. UPSC COACHING ──
    private static function upscCoaching($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a top UPSC and civil services coaching institute in {$city} offering full courses for Prelims (GS + CSAT), Mains (GS 1-4, essay, optional subjects), interview, and current affairs. The programme includes daily answer writing, NCERT revision, test series, mentorship, and study planners.{$hours} IAS aspirants across {$area} and {$city} pick {$business} in {$location} for ex-IAS mentors, comprehensive notes, doubt-clearing sessions, and a proven Prelims-to-Mains-to-Interview roadmap. Enrol today and start your civil services journey with expert guidance.";
    }

    // ── 68. IIT-JEE COACHING ──
    private static function iitJeeCoaching($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading IIT-JEE coaching institute in {$city} preparing students for JEE Main, JEE Advanced, and other engineering entrance exams. The curriculum covers Physics, Chemistry, and Mathematics with concept building, problem-solving, doubt sessions, weekly tests, and full-length mocks.{$hours} Students and parents across {$area} and {$city} trust {$business} in {$location} for IIT-alumni faculty, NCERT-based foundation classes (8th-10th), focused 11th-12th programmes, performance analytics, and a strong selection record. Enrol today and start preparing for top IITs and NITs.";
    }

    // ── 69. NEET COACHING ──
    private static function neetCoaching($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a top NEET coaching institute in {$city} preparing students for MBBS, BDS, AYUSH, and allied medical courses. The programme covers Physics, Chemistry, and Biology with NCERT-based teaching, daily practice problems, doubt clearing, weekly tests, and AIIMS-pattern mock exams.{$hours} Medical aspirants across {$area} and {$city} pick {$business} in {$location} for experienced MBBS faculty, micro-topic test series, biology focus modules, and a proven NEET selection record. Enrol today and start your journey towards a top medical college.";
    }

    // ── 70. CAT COACHING ──
    private static function catCoaching($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading CAT and MBA entrance coaching institute in {$city} preparing students for CAT, XAT, SNAP, NMAT, MAT, CMAT, IIFT, and state-level management entrance exams. Quant, VARC, LRDI, GD/PI, and WAT modules are taught by IIM and top B-school alumni.{$hours} MBA aspirants across {$area} and {$city} trust {$business} in {$location} for adaptive mock tests, sectional analysis, mentor support, and personalised B-school admission counselling. Enrol today and accelerate your path to IIMs and top management institutes.";
    }

    // ── 71. LAW ENTRANCE COACHING ──
    private static function lawEntranceCoaching($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a top law entrance coaching institute in {$city} preparing students for CLAT, AILET, LSAT, SLAT, MH-CET Law, and other top law entrance exams. The programme covers English, Logical Reasoning, Legal Reasoning, GK and Current Affairs, and Quant with classroom teaching and weekly mocks.{$hours} Law aspirants across {$area} and {$city} pick {$business} in {$location} for NLU-alumni faculty, structured study material, current affairs digests, and a proven selection record into NLUs. Enrol today and start preparing for a successful legal career.";
    }

    // ── 72. HOTEL MGMT ENTRANCE COACHING ──
    private static function hotelMgmtEntranceCoaching($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a specialised hotel management entrance coaching institute in {$city} preparing students for NCHMCT JEE, IIHM eCHAT, IHM, and other hospitality entrance exams. The programme covers Reasoning, GK, English, Aptitude, and personality development for GD/PI rounds.{$hours} Hospitality aspirants across {$area} and {$city} pick {$business} in {$location} for expert mentors, mock interviews, grooming sessions, and a proven IHM selection record. Enrol today and launch your career in hotel and hospitality management.";
    }

    // ── 73. DESIGN ENTRANCE COACHING ──
    private static function designEntranceCoaching($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading design entrance coaching institute in {$city} preparing students for NID, NIFT, UCEED, CEED, and architecture entrance exams. The programme covers drawing, creative aptitude, design thinking, material handling, situation tests, and portfolio building under expert mentors.{$hours} Aspiring designers across {$area} and {$city} trust {$business} in {$location} for NID/NIFT-alumni faculty, studio environment, mock interviews, and a strong record of NID, NIFT, and IIT design selections. Enrol today and launch your career in design.";
    }

    // ── 74. CA COACHING (CA / CS / CMA / ICWA / CFA) ──
    private static function caCoaching($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a top professional coaching institute in {$city} for CA, CS, CMA, ICWA, CFA, CFP, and other finance and accounting certifications. The programme covers Foundation, Intermediate, and Final levels with concept-based teaching, MCQ practice, test series, and revision modules.{$hours} Commerce students across {$area} and {$city} pick {$business} in {$location} for qualified CA/CS/CMA faculty, structured study planner, doubt sessions, and a strong all-India rank record. Enrol today and start your journey into India's most rewarding finance careers.";
    }

    // ── 75. SCHOOL TUITION ──
    private static function schoolTuition($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers expert school and college tuitions in {$city} for classes 6 to 12 across CBSE, ICSE, and state board curricula. Subjects include Maths, Physics, Chemistry, Biology, English, Accounts, Economics, Business Studies, Hindi, and Social Science with regular tests and parent-teacher reviews.{$hours} Students and parents across {$area} and {$city} pick {$business} in {$location} for qualified teachers, small batches, doubt-clearing sessions, NCERT-focused teaching, and proven board exam results. Book a free demo class today and improve grades steadily.";
    }

    // ── 76. LANGUAGE CLASSES ──
    private static function languageClasses($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a popular foreign language institute in {$city} offering classes in English, French, German, Spanish, Japanese, Mandarin, Korean, Arabic, Russian, and Italian. Courses follow CEFR levels (A1 to C2) with native-style speaking practice, grammar, writing, and exam preparation.{$hours} Students, working professionals, and travellers across {$area} and {$city} pick {$business} in {$location} for certified trainers, small batches, online and offline modes, and global certifications like DELF, TestDaF, DELE, and JLPT. Enrol today and add a new language to your skill set.";
    }

    // ── 77. TEST PREP ABROAD ──
    private static function testPrepAbroad($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted study-abroad test prep institute in {$city} offering coaching for IELTS, TOEFL, PTE, GRE, GMAT, SAT, ACT, and Duolingo English Test. Programs include strategy sessions, sectional drills, full-length mocks, speaking practice, and personalised score improvement plans.{$hours} Study-abroad aspirants across {$area} and {$city} pick {$business} in {$location} for certified trainers, 90+ verified score record, university shortlisting support, and visa documentation guidance. Book a free demo class today and start your international education journey.";
    }

    // ── 78. SCHOOLS ──
    private static function schools($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a reputed school in {$city} offering quality education from kindergarten to class 12 under CBSE, ICSE, IB, or state board curricula. The school focuses on academic excellence, sports, arts, music, robotics, debate, and overall personality development with experienced teachers and modern infrastructure.{$hours} Parents across {$area} and {$city} trust {$business} in {$location} for safe campus, smart classrooms, transport, mid-day meals, regular PTMs, and strong board exam results. Schedule a school visit today to explore admissions and curriculum details.";
    }

    // ── 79. COLLEGES ──
    private static function colleges($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a respected college in {$city} offering UG and PG programmes in engineering, management, science, commerce, arts, law, hotel management, pharmacy, nursing, journalism, and design with NAAC/AICTE/UGC-approved curriculum, experienced faculty, and modern labs.{$hours} Students across {$area} and {$city} pick {$business} in {$location} for strong placement records, scholarship programmes, industry tie-ups, hostel facilities, and extracurricular exposure. Apply today for the upcoming admission cycle and shape a rewarding career.";
    }

    // ── 80. PLAYSCHOOL ──
    private static function playSchool($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a well-known playschool and day-care in {$city} offering structured learning for kids aged 1.5 to 5 years through play-based curriculum, phonics, story time, music, dance, art, and outdoor activities in safe, CCTV-monitored classrooms with trained teachers and caregivers.{$hours} Parents across {$area} and {$city} trust {$business} in {$location} for child-safe environment, hygienic meals, parent communication apps, and a smooth transition to formal schooling. Book a free school tour today and explore admissions.";
    }

    // ── 81. DISTANCE EDUCATION ──
    private static function distanceEducation($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a UGC-DEB approved distance education centre in {$city} offering BA, BCom, BBA, BCA, MA, MCom, MBA, MCA, and PG diploma programmes from top universities like IGNOU, NMIMS, Symbiosis, Manipal, Amity, and Annamalai University with full admission, study material, and exam support.{$hours} Working professionals and students across {$area} and {$city} pick {$business} in {$location} for verified university tie-ups, EMI fee options, online classes, and continuous admission counselling. Get a free programme suggestion today and continue your education without quitting your job.";
    }

    // ── 82. OVERSEAS EDUCATION ──
    private static function overseasEducation($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a top overseas education consultant in {$city} offering admission assistance to universities in the USA, UK, Canada, Australia, New Zealand, Germany, Ireland, Singapore, Dubai, France, Italy, and more. Services cover course selection, SOP, LOR, visa, education loan, and pre-departure support.{$hours} Aspirants across {$area} and {$city} pick {$business} in {$location} for certified counsellors, transparent fees, scholarship guidance, and a proven visa-success record. Book a free counselling session today and start your study-abroad journey with confidence.";
    }

    // ── 83. DEGREE PROGRAMS ──
    private static function degreePrograms($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers a wide range of accredited degree, diploma, certificate, and doctorate programmes in {$city} across engineering, management, IT, design, healthcare, finance, and arts streams. Programmes are UGC-recognised, with flexible online and on-campus options, dual specialisations, and industry internships.{$hours} Students and working professionals across {$area} and {$city} choose {$business} in {$location} for credible universities, scholarship support, EMI fee structures, and dedicated career mentors. Book a free admission counselling session today and pick the right programme.";
    }

    // ── 84. MUSIC CLASSES ──
    private static function musicClasses($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a popular music academy in {$city} offering classes in vocals (Hindustani, Carnatic, Western), guitar, keyboard, piano, drums, violin, harmonium, tabla, ukulele, and music production. Trinity, Rockschool, and ABRSM exam preparation are available with regular recitals and certifications.{$hours} Students of all ages across {$area} and {$city} pick {$business} in {$location} for experienced gurus, structured curriculum, one-on-one attention, and stage performance exposure. Book a free trial class today and start your musical journey.";
    }

    // ── 85. DANCE CLASSES ──
    private static function danceClasses($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading dance academy in {$city} offering classes in classical (Bharatanatyam, Kathak, Odissi, Kuchipudi), Bollywood, hip-hop, contemporary, salsa, Zumba, freestyle, K-pop, and wedding choreography for kids, teens, adults, and brides.{$hours} Dancers across {$area} and {$city} pick {$business} in {$location} for professional choreographers, structured batches, stage performance opportunities, and competition exposure. Join a free trial class today and start dancing your passion into a craft.";
    }

    // ── 86. DRIVING SCHOOL ──
    private static function drivingSchool($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a government-approved driving school in {$city} offering car and two-wheeler driving lessons for beginners, women, senior citizens, and licence-renewal candidates. The course covers traffic rules, signals, parking, highway driving, night driving, and RTO test preparation.{$hours} Learners across {$area} and {$city} pick {$business} in {$location} for dual-control cars, patient instructors, flexible class timings, RTO licence assistance, and affordable packages. Enrol today and learn to drive safely and confidently.";
    }

    // ── 87. TRANSLATOR SERVICE ──
    private static function translatorService($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a professional translator and interpreter service in {$city} offering certified translations for legal documents, passports, marriage certificates, academic transcripts, business contracts, medical records, and immigration paperwork in English, Hindi, French, German, Spanish, Arabic, Chinese, and more.{$hours} Clients across {$area} and {$city} pick {$business} in {$location} for embassy-accepted certifications, notarised translations, fast turnaround, and confidential handling. Submit your document today for an accurate, certified translation.";
    }

     
    // ── 88. WEDDING PLANNER ──
    private static function weddingPlanner($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a top wedding planning company in {$city} offering end-to-end wedding management including venue selection, theme decor, catering, makeup, photography, mehendi, sangeet, cocktail, bridal entry, baraat coordination, and destination weddings.{$hours} Couples across {$area} and {$city} pick {$business} in {$location} for creative themes, vendor management, on-day execution, budget planning, and stress-free coordination. Book a free consultation today and let your dream wedding unfold flawlessly.";
    }

    // ── 89. EVENT ORGANIZER ──
    private static function eventOrganizer($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a professional event management company in {$city} handling corporate events, product launches, conferences, exhibitions, college fests, birthday parties, baby showers, anniversaries, retirement parties, and theme-based celebrations with full creative and logistics support.{$hours} Clients across {$area} and {$city} pick {$business} in {$location} for experienced event managers, branded equipment, on-time execution, and transparent quotations. Book a free planning session today and turn your next event into a memorable success.";
    }

    // ── 90. BIRTHDAY PARTY ──
    private static function birthdayParty($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} specialises in birthday party planning in {$city} offering kids' theme parties, princess and superhero setups, balloon decorations, magic shows, anchors, character mascots, return gifts, and customised cakes for 1st birthdays, milestone birthdays, and surprise parties.{$hours} Parents across {$area} and {$city} trust {$business} in {$location} for creative themes, hygienic catering, on-time setup, and end-to-end party coordination. Book a free consultation today and make your child's birthday truly unforgettable.";
    }

     

    // ── 92. CATERING ──
    private static function catering($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted catering service in {$city} offering customised menus for weddings, receptions, birthdays, corporate events, house parties, and religious functions. Cuisines include North Indian, South Indian, Mughlai, Chinese, Continental, Rajasthani, live counters, and elaborate dessert spreads.{$hours} Hosts across {$area} and {$city} pick {$business} in {$location} for hygienic kitchens, FSSAI compliance, uniformed serving staff, premium crockery, and on-time food delivery. Book a free menu tasting today and serve a meal your guests will remember.";
    }

    // ── 93. STAGE DECORATOR ──
    private static function stageDecorator($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading stage decoration specialist in {$city} creating breathtaking setups for weddings, sangeet, mehendi, varmala, receptions, baby showers, and corporate events. Themes include royal, floral, pastel, traditional, mandap-style, and Insta-worthy backdrop designs.{$hours} Hosts across {$area} and {$city} trust {$business} in {$location} for skilled designers, premium fresh and artificial flowers, on-time setup, and creative theme customisation. Book a free site visit today and bring your event venue to life.";
    }

    // ── 94. MAKEUP ARTIST ──
    private static function makeupArtist($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a professional makeup artist in {$city} offering bridal makeup, engagement makeup, reception looks, party makeup, HD makeup, airbrush makeup, pre-wedding shoots, and family member makeovers using premium brands like MAC, Huda Beauty, Bobbi Brown, and Charlotte Tilbury.{$hours} Brides and clients across {$area} and {$city} pick {$business} in {$location} for skin-friendly products, custom looks, on-location services, and trial makeup options. Book your slot today and look stunning on your big day with flawless, long-lasting makeup.";
    }

    // ── 95. MEHENDI ARTIST ──
    private static function mehendiArtist($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a renowned mehendi artist in {$city} offering bridal mehendi, dulhan-style intricate designs, Arabic mehendi, minimal designs, family mehendi, and group mehendi services for weddings, sangeet, karwa chauth, teej, and Eid celebrations.{$hours} Brides and families across {$area} and {$city} pick {$business} in {$location} for organic cone mehendi, deep colour stain, fine detailing, on-time service, and on-location convenience. Book your mehendi artist today and adorn your hands with stunning designs.";
    }

    // ── 96. BRIDAL WEAR / WEDDING DRESS ──
    private static function bridalWear($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a top bridal wear and wedding dress store in {$city} offering lehengas, sarees, gowns, sherwanis, indo-westerns, kurta sets, and family wedding outfits in designer collections from leading labels along with customised tailoring, alterations, and bridal styling.{$hours} Brides, grooms, and families across {$area} and {$city} pick {$business} in {$location} for premium fabrics, trending designs, accurate fitting, accessory pairing, and budget-friendly to luxury price ranges. Visit the showroom today and pick your perfect wedding outfit.";
    }

    // ── 97. GHODI BAGGI ──
    private static function ghodiBaggi($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides traditional ghodi and baggi rental in {$city} for baraat and groom entry with decorated horses, royal buggies, vintage horse-drawn carriages, themed chariots, and elephant booking for grand wedding processions.{$hours} Grooms and families across {$area} and {$city} pick {$business} in {$location} for trained horses, ornate decorations, experienced handlers, on-time arrival, and safe baraat coordination. Book your ghodi-baggi today and add a royal touch to the groom's entry.";
    }

    // ── 98. ROAD LIGHT ──
    private static function roadLight($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers professional road light and baraat lighting services in {$city} including LED gas lights, fancy chandeliers, RGB strips, themed lighting panels, generator-backed setups, and live electrician support for wedding processions, street decorations, and DJ baraats.{$hours} Wedding planners and grooms across {$area} and {$city} trust {$business} in {$location} for power-safe wiring, eye-catching designs, on-time setup, and well-coordinated baraat lighting. Book your wedding road light service today for a bright and grand procession.";
    }

    // ── 99. FIREWORK & CRACKERS ──
    private static function firework($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers safe and licensed fireworks and crackers services in {$city} for weddings, receptions, varmala, baraat, baby showers, brand launches, and corporate events. Setups include sky shots, aerial fireworks, fountains, sparklers, ground spinners, and theme-based pyro shows.{$hours} Event hosts across {$area} and {$city} pick {$business} in {$location} for licensed pyro-technicians, safety briefing, fire-safety crew, and tested products. Book your firework display today and end your event with a spectacular finale.";
    }

    // ── 100. HONEYMOON PACKAGE ──
    private static function honeymoonPackage($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers customised honeymoon packages from {$city} to top destinations like Maldives, Bali, Thailand, Dubai, Europe, Mauritius, Switzerland, Andaman, Goa, Kerala, Kashmir, and Himachal. Packages include flights, hotels, transfers, candle-light dinners, sightseeing, and visa assistance.{$hours} Newlyweds across {$area} and {$city} pick {$business} in {$location} for romantic itineraries, verified resorts, transparent pricing, EMI options, and 24×7 on-trip support. Book your honeymoon today and start married life with unforgettable memories.";
    }

    // ── 101. COURT MARRIAGE ──
    private static function courtMarriage($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers complete court marriage services in {$city} under the Special Marriage Act and Hindu Marriage Act, including document preparation, marriage notice, affidavits, witness arrangement, registrar coordination, marriage certificate, and tatkal court marriage where permitted.{$hours} Couples across {$area} and {$city} trust {$business} in {$location} for licensed advocates, end-to-end legal handling, fast registration, and confidential service. Book your court marriage consultation today and complete the process legally and stress-free.";
    }

    // ── 102. DHOL SHEHNAI BAJA ──
    private static function dholShehnai($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} provides traditional dhol, shehnai, and band baja services in {$city} for baraat, sangeet, mehendi, varmala entry, religious functions, and corporate cultural events. Performers include Punjabi dhol players, professional brass bands, shehnai maestros, and folk drummers.{$hours} Hosts across {$area} and {$city} pick {$business} in {$location} for energetic performances, traditional attire, on-time arrival, and customised song requests. Book your dhol-shehnai team today and bring authentic festive sound to your celebration.";
    }

    // ── 103. WEDDING SINGER & DANCER ──
    private static function weddingSinger($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers professional wedding singers, dancers, and live performance artists in {$city} for sangeet, mehendi, cocktail, reception, and DJ nights. The roster includes Bollywood singers, Punjabi performers, Sufi vocalists, anchor hosts, choreographers, and live band setups.{$hours} Couples and event planners across {$area} and {$city} pick {$business} in {$location} for high-energy performances, themed costumes, sound equipment, and curated song lists. Book your wedding singer or dance troupe today and turn every function into a stage show.";
    }

    // ── 104. WEDDING ASTROLOGER ──
    private static function weddingAstrologer($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is an experienced wedding astrologer in {$city} offering kundali matching, gun milan, manglik dosha analysis, shubh muhurat for marriage, vivah panchami, gemstone consultation, and remedies for a happy married life. Online and in-person consultations are available.{$hours} Families across {$area} and {$city} trust {$business} in {$location} for accurate kundali analysis, honest guidance, ritual recommendations, and confidential consultations. Book your astrology session today and start your marriage on auspicious grounds.";
    }

    // ── 105. FLOWER DECORATION ──
    private static function flowerDecoration($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers stunning flower decoration services in {$city} for weddings, mandap, reception stage, varmala, mehendi, sangeet, car decoration, home pooja, and corporate events using fresh roses, marigolds, orchids, lilies, jasmine, and seasonal exotic flowers.{$hours} Wedding planners and hosts across {$area} and {$city} pick {$business} in {$location} for premium fresh flowers, creative theme designs, on-time setup, and budget-friendly to luxury packages. Book a free site visit today and transform your venue with floral magic.";
    }

     
    // ── 107. TENT HOUSE ──
    private static function tentHouse($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted tent house in {$city} offering complete event setups including shamiana, kanat, German hangars, dome tents, stage backdrops, chairs, tables, sofas, carpets, cutlery, generators, and lighting for weddings, receptions, religious functions, and corporate events.{$hours} Hosts across {$area} and {$city} pick {$business} in {$location} for clean tents, branded utensils, prompt setup and dismantling, and affordable per-event pricing. Book your tent house today and get a full venue setup from one reliable team.";
    }

     

    // ── 109. CAR DECORATION ──
    private static function carDecoration($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers stunning wedding car decoration services in {$city} using fresh flowers, artificial flowers, ribbons, themed setups, royal styles, and personalized name plates. Whether it's a vintage car, luxury sedan, SUV, or wedding limousine, every decoration is tailored to match the wedding theme.{$hours} Trusted by hundreds of couples across {$area} and {$city}, {$business} in {$location} ensures timely setup, premium flowers, and elegant designs that turn the bridal car into a memorable centerpiece. Book your wedding car decoration today and add a beautiful finishing touch to your big day.";
    }

    // ── 110. WEDDING CAR RENTAL ──
    private static function weddingCarRental($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} offers premium wedding car rental services in {$city} including luxury sedans (Mercedes, BMW, Audi), classic vintage cars, limousines, Range Rovers, decorated SUVs, and royal couple-entry cars with experienced chauffeurs for baraat, bidaai, and reception.{$hours} Couples across {$area} and {$city} pick {$business} in {$location} for spotlessly clean cars, professional drivers, on-time pickup, and flexible per-day or per-event packages. Book your wedding car today and arrive in royal style.";
    }

    // ── 111. JAGRAN PARTY ──
    private static function jagranParty($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a renowned jagran and bhajan party in {$city} offering Mata ki Chowki, Devi jagran, Sai sandhya, Krishna leela, kirtan, and devotional musical nights with experienced singers, musicians, harmonium, dholak, tabla, and a complete devotional ambience.{$hours} Devotees across {$area} and {$city} pick {$business} in {$location} for soulful performances, traditional setup, on-time arrival, and customised devotional song requests. Book your jagran party today and host a divine, memorable night of devotion.";
    }

  
    // ── 112. SPORTS ACADEMY ──
    private static function sportsAcademy($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a leading sports academy in {$city}, offering professional coaching for all age groups — kids, juniors, teens, and adults. The academy provides certified trainers, structured curriculum, modern equipment, fitness conditioning, match practice, and tournament exposure to help every player reach their full potential.{$hours} Whether you are a beginner looking to learn the basics or an aspiring athlete training for state and national tournaments, {$business} in {$location} offers personalized coaching plans and supportive learning environments. Parents and players across {$area} and {$city} trust {$business} for skill development, discipline, and competitive growth. Enrol today for a free trial session.";
    }

    // ── 113. HOME SERVICES (generic) ──
    private static function homeServices($business, $area, $city, $location, $hours): string
    {
        return "{$business} in {$location} is a trusted home services provider in {$city} offering deep cleaning, electrical work, plumbing, painting, pest control, appliance repair, carpenter, and handyman services under one roof. Skilled professionals, branded tools, and transparent pricing make every visit hassle-free.{$hours} Households across {$area} and {$city} pick {$business} in {$location} for verified staff, on-time service, post-service warranty, and easy online booking. Schedule a service today and keep your home spotless and fully functional.";
    }

       

	
	
}
