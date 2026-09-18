<?php
namespace App\Support;
use Illuminate\Support\Arr;
final class DemoStore
{
    private const KEY = 'quickdials_dashboard_demo';
    public static function data(): array
    {
        if (!session()->has(self::KEY)) session()->put(self::KEY, self::defaults());
        return session(self::KEY);
    }
    public static function get(string $key, mixed $default = null): mixed { return Arr::get(self::data(), $key, $default); }
    public static function put(string $key, mixed $value): void { $d=self::data(); Arr::set($d,$key,$value); session()->put(self::KEY,$d); }
    public static function updateItem(string $collection, int $id, array $changes): void
    {
        $items=self::get($collection,[]);
        foreach($items as &$item) if((int)$item['id']===$id){$item=array_merge($item,$changes);break;}
        self::put($collection,$items);
    }
    public static function addItem(string $collection, array $item): array
    {
        $items=self::get($collection,[]); $max=collect($items)->max('id') ?? 0; $item['id']=$max+1; $items[]=$item; self::put($collection,$items); return $item;
    }
    public static function deleteItem(string $collection, int $id): void { self::put($collection,array_values(array_filter(self::get($collection,[]),fn($x)=>(int)$x['id']!==$id))); }
    public static function reset(): void { session()->forget(self::KEY); }
    public static function defaults(): array
    {
        $today=now(); $series=[]; for($i=29;$i>=0;$i--){$series[]=['date'=>$today->copy()->subDays($i)->format('Y-m-d'),'views'=>220 + (($i*47)%190) + (($i%5)*28)];}
        return [
          'profile'=>['name'=>'QuickFix Home Services','category'=>'Home Services','verified'=>true,'profileCompletion'=>89,'yearEstablished'=>'2017','description'=>'Trusted home repair and maintenance services for busy families.','overview'=>'QuickFix Home Services connects customers with trained technicians for plumbing, electrical work, appliance repair, painting and preventive maintenance. We focus on transparent pricing, fast response and dependable workmanship.','ownerName'=>'Abhimanyu Sharma','ownerPhone'=>'+91 98765 43210','ownerEmail'=>'owner@quickfix.in','phone'=>'+91 98765 43210','email'=>'hello@quickfix.in','website'=>'https://quickfix.example','city'=>'Bengaluru','address'=>'203, Oxford Towers, HAL Old Airport Road, Kodihalli, Bengaluru','hours'=>'Mon-Sat: 9:00 AM - 7:00 PM','metaTitle'=>'QuickFix Home Services in Bengaluru | Trusted Repair Experts','metaDescription'=>'Book verified plumbing, electrical and appliance repair professionals in Bengaluru with QuickFix Home Services.','metaKeyword'=>'home services, plumber, electrician, appliance repair','logoUrl'=>'','bannerUrl'=>'','facebookUrl'=>'https://facebook.com/quickfix','instagramUrl'=>'https://instagram.com/quickfix','twitterUrl'=>'','linkedinUrl'=>'https://linkedin.com/company/quickfix','youtubeUrl'=>'','pinterestUrl'=>''],
          'account'=>['coins'=>555,'pauseLeads'=>false,'activeStatus'=>true,'paidStatus'=>true,'certifiedStatus'=>true,'trustedStatus'=>true,'gstStatus'=>false,'chatFeature'=>true,'clientContactStatus'=>true,'clientTransferStatus'=>false,'clientGSTStatus'=>false,'postingAndReceivingStatus'=>true,'membershipType'=>'gold','packageName'=>'Gold','memberSince'=>'2024-03-14','membershipEndsOn'=>$today->copy()->addMonths(8)->format('Y-m-d'),'dailyLeadLimit'=>25,'leadsUsedToday'=>8],
          'stats'=>['profileViews'=>12480,'viewsChangePct'=>18,'totalLeads'=>286,'leadsChangePct'=>12,'totalCalls'=>174,'avgRating'=>4.8],
          'series'=>$series,
          'activities'=>[
            ['id'=>1,'type'=>'lead','text'=>'New lead received from Rahul Verma for AC repair','createdAt'=>$today->copy()->subMinutes(18)->toDateTimeString()],
            ['id'=>2,'type'=>'review','text'=>'Priya Nair left a 5-star review','createdAt'=>$today->copy()->subHours(2)->toDateTimeString()],
            ['id'=>3,'type'=>'view_milestone','text'=>'Your profile crossed 12,000 total views','createdAt'=>$today->copy()->subHours(7)->toDateTimeString()],
            ['id'=>4,'type'=>'listing','text'=>'Emergency Plumbing listing was updated','createdAt'=>$today->copy()->subDay()->toDateTimeString()],
            ['id'=>5,'type'=>'lead','text'=>'A lead was assigned to Neha Singh','createdAt'=>$today->copy()->subDays(2)->toDateTimeString()],
          ],
          'team'=>[
            ['id'=>1,'name'=>'Neha Singh','email'=>'neha@quickfix.in','phone'=>'+91 98111 22334','role'=>'manager','active'=>true],
            ['id'=>2,'name'=>'Arjun Mehta','email'=>'arjun@quickfix.in','phone'=>'+91 98222 33445','role'=>'agent','active'=>true],
            ['id'=>3,'name'=>'Kavya Rao','email'=>'kavya@quickfix.in','phone'=>'+91 98333 44556','role'=>'agent','active'=>false],
          ],
          'leads'=>[
            ['id'=>1,'customerName'=>'Rahul Verma','phone'=>'+91 98990 11223','email'=>'rahul.verma@example.com','service'=>'AC Repair','message'=>'My split AC is not cooling properly and makes a rattling sound. Need a technician today.','status'=>'new','favorite'=>true,'archived'=>false,'assignedTo'=>2,'createdAt'=>$today->copy()->subMinutes(40)->toDateTimeString()],
            ['id'=>2,'customerName'=>'Priya Nair','phone'=>'+91 98880 22446','email'=>'priya.nair@example.com','service'=>'Plumbing','message'=>'Kitchen sink pipe is leaking under the cabinet. Please share the visit charge.','status'=>'new','favorite'=>false,'archived'=>false,'assignedTo'=>null,'createdAt'=>$today->copy()->subHours(3)->toDateTimeString()],
            ['id'=>3,'customerName'=>'Sandeep Kumar','phone'=>'+91 98770 33669','email'=>'','service'=>'Electrical Work','message'=>'Need rewiring and new modular switches for two rooms.','status'=>'contacted','favorite'=>false,'archived'=>false,'assignedTo'=>1,'createdAt'=>$today->copy()->subDay()->toDateTimeString()],
            ['id'=>4,'customerName'=>'Meera Joshi','phone'=>'+91 98660 44882','email'=>'meera@example.com','service'=>'Water Purifier Service','message'=>'Annual RO service and filter replacement required.','status'=>'converted','favorite'=>true,'archived'=>false,'assignedTo'=>2,'createdAt'=>$today->copy()->subDays(2)->toDateTimeString()],
            ['id'=>5,'customerName'=>'Amit Patel','phone'=>'+91 98550 55005','email'=>'amit@example.com','service'=>'House Painting','message'=>'Looking for an estimate for painting a 2BHK apartment.','status'=>'closed','favorite'=>false,'archived'=>true,'assignedTo'=>3,'createdAt'=>$today->copy()->subDays(5)->toDateTimeString()],
          ],
          'followups'=>[
            ['id'=>1,'leadId'=>1,'notes'=>'Call customer after 6 PM and confirm technician slot.','outcome'=>'callback','dueAt'=>$today->copy()->addHours(3)->format('Y-m-d\TH:i'),'done'=>false,'assignedTo'=>2,'createdAt'=>$today->copy()->subMinutes(20)->toDateTimeString()],
            ['id'=>2,'leadId'=>2,'notes'=>'Share inspection charges over WhatsApp.','outcome'=>'callback','dueAt'=>$today->copy()->subHour()->format('Y-m-d\TH:i'),'done'=>false,'assignedTo'=>1,'createdAt'=>$today->copy()->subHours(2)->toDateTimeString()],
            ['id'=>3,'leadId'=>3,'notes'=>'Estimate sent. Follow up after customer discusses with family.','outcome'=>'interested','dueAt'=>$today->copy()->addDay()->format('Y-m-d\TH:i'),'done'=>false,'assignedTo'=>1,'createdAt'=>$today->copy()->subDay()->toDateTimeString()],
            ['id'=>4,'leadId'=>4,'notes'=>'Job completed and payment collected.','outcome'=>'converted','dueAt'=>$today->copy()->subDays(2)->format('Y-m-d\TH:i'),'done'=>true,'assignedTo'=>2,'createdAt'=>$today->copy()->subDays(2)->toDateTimeString()],
          ],
          'listings'=>[
            ['id'=>1,'title'=>'Emergency Plumbing Services','category'=>'Plumbing','description'=>'24/7 leakage repair, pipe fitting and drain cleaning.','status'=>'active','views'=>3580,'leads'=>94,'createdAt'=>$today->copy()->subMonths(7)->toDateTimeString()],
            ['id'=>2,'title'=>'AC Repair & Installation','category'=>'Appliance Repair','description'=>'AC servicing, gas refill, installation and repair by trained technicians.','status'=>'active','views'=>2910,'leads'=>76,'createdAt'=>$today->copy()->subMonths(5)->toDateTimeString()],
            ['id'=>3,'title'=>'Residential Electrical Work','category'=>'Electrical','description'=>'Wiring, switchboards, fan installation and fault diagnosis.','status'=>'paused','views'=>1640,'leads'=>41,'createdAt'=>$today->copy()->subMonths(3)->toDateTimeString()],
          ],
          'reviews'=>[
            ['id'=>1,'customerName'=>'Priya Nair','rating'=>5,'comment'=>'Very quick response. The technician fixed the leak neatly and cleaned the area before leaving.','reply'=>'Thank you, Priya! We are glad we could help.','createdAt'=>$today->copy()->subDays(2)->toDateTimeString()],
            ['id'=>2,'customerName'=>'Vikram Shah','rating'=>4,'comment'=>'Professional AC service and transparent pricing. Arrival was around 20 minutes late.','reply'=>'','createdAt'=>$today->copy()->subDays(6)->toDateTimeString()],
            ['id'=>3,'customerName'=>'Ananya Das','rating'=>5,'comment'=>'Excellent electrical work. Everything was explained clearly before starting.','reply'=>'Thank you for your kind feedback!','createdAt'=>$today->copy()->subDays(10)->toDateTimeString()],
          ],
          'keywords'=>[['id'=>1,'keyword'=>'AC Repair','parentCategory'=>'Home Services','childCategory'=>'Appliance Repair'],['id'=>2,'keyword'=>'Emergency Plumber','parentCategory'=>'Home Services','childCategory'=>'Plumbing'],['id'=>3,'keyword'=>'Electrician','parentCategory'=>'Home Services','childCategory'=>'Electrical']],
          'locations'=>[['id'=>1,'state'=>'Karnataka','city'=>'Bengaluru','area'=>'Indiranagar'],['id'=>2,'state'=>'Karnataka','city'=>'Bengaluru','area'=>'Whitefield'],['id'=>3,'state'=>'Karnataka','city'=>'Bengaluru','area'=>'Koramangala']],
          'gallery'=>[['id'=>1,'url'=>'/gallery/ac-service.jpg','caption'=>'AC servicing'],['id'=>2,'url'=>'/gallery/plumbing-work.jpg','caption'=>'Plumbing repair'],['id'=>3,'url'=>'/gallery/electrical-work.jpg','caption'=>'Electrical installation']],
          'awards'=>[['id'=>1,'name'=>'Best Home Service Provider 2025','imageUrl'=>''],['id'=>2,'name'=>'Customer Choice Award','imageUrl'=>'']],
          'certificates'=>['panNo'=>'ABCDE1234F','gstNo'=>'29ABCDE1234F1Z5','cinNo'=>'U74999KA2017PTC123456','msmeNo'=>'UDYAM-KR-03-0012345','isoNo'=>'ISO 9001:2015','coiNo'=>'COI-2017-123456'],
          'packages'=>[['id'=>1,'name'=>'₹1,000 Pack','coins'=>1111,'amount'=>1000],['id'=>2,'name'=>'₹2,000 Pack','coins'=>2272,'amount'=>2000],['id'=>3,'name'=>'₹3,000 Pack','coins'=>3529,'amount'=>3000],['id'=>4,'name'=>'₹5,000 Pack','coins'=>6099,'amount'=>5000],['id'=>5,'name'=>'₹10,000 Pack','coins'=>12500,'amount'=>10000],['id'=>6,'name'=>'₹20,000 Pack','coins'=>27777,'amount'=>20000],['id'=>7,'name'=>'₹40,000 Pack','coins'=>57777,'amount'=>40000],['id'=>8,'name'=>'₹50,000 Pack','coins'=>76923,'amount'=>50000]],
          'invoices'=>[['id'=>10025,'paidAmount'=>999,'gst'=>180,'totalAmount'=>1179,'createdAt'=>$today->copy()->subMonth()->toDateTimeString()],['id'=>10014,'paidAmount'=>499,'gst'=>90,'totalAmount'=>589,'createdAt'=>$today->copy()->subMonths(3)->toDateTimeString()]],
          'coinUsage'=>[['id'=>1,'description'=>'Lead contact unlocked - Rahul Verma','coins'=>10,'createdAt'=>$today->copy()->subHours(4)->toDateTimeString()],['id'=>2,'description'=>'Featured listing boost','coins'=>50,'createdAt'=>$today->copy()->subDays(2)->toDateTimeString()],['id'=>3,'description'=>'Lead contact unlocked - Priya Nair','coins'=>10,'createdAt'=>$today->copy()->subDays(3)->toDateTimeString()]],
          'transactions'=>[['id'=>1,'type'=>'bonus','description'=>'Monthly membership bonus','amount'=>100,'createdAt'=>$today->copy()->subDays(4)->toDateTimeString()],['id'=>2,'type'=>'usage','description'=>'Lead contact unlocks','amount'=>-30,'createdAt'=>$today->copy()->subDays(5)->toDateTimeString()],['id'=>3,'type'=>'purchase','description'=>'Purchased 1,200 coins package','amount'=>1200,'createdAt'=>$today->copy()->subMonth()->toDateTimeString()]],
        ];
    }
}
