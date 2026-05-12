<?php

namespace App\Http\Controllers\Official;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\LeadEnquery;
use App\EnquiryFollowUp;
use App\Subscribe;
use App\Models\Blogdetails;
use App\Models\Client\Client; //model
use App\Models\Keyword;
use App\Models\Citieslists;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
class OfficialController extends Controller
{

    public function __construct()
    {

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('official.index');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        $clients = Client::get()->count();
        $keyword = Keyword::get()->count();
        $citieslists = Citieslists::get()->count();
        return view('official.about-us', ['clients' => $clients, 'keyword' => $keyword, 'citieslists' => $citieslists]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function news()
    {
        return view('official.news');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function rss()
    {
        $blogrecents = Blogdetails::limit(8)->orderBy('id', 'DESC')->get();
        return view('official.rss', ['blogrecents' => $blogrecents]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function features()
    {
        return view('official.features');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function faq()
    {
        return view('official.faq');
    }

    public function contact()
    {
        return view('official.contact-us');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function careers()
    {
        return view('official.careers');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pricing()
    {
        return view('official.pricing');
    } /**
      * Show the application dashboard.
      *
      * @return \Illuminate\Http\Response
      */
    public function media()
    {
        return view('official.index');
    } /**
      * Show the application dashboard.
      *
      * @return \Illuminate\Http\Response
      */
    public function advertise()
    {
        return view('official.advertise');
    }


    /**
     * Fetch data from the QuickDials API.
     */
    private function fetchBlogData(): ?array
    {
        try {
            $response = Http::timeout(10)
                ->withoutVerifying()->get('https://api.quickdials.com/api/website/getBlog');
 
            return $response->successful() ? $response->json() : null;
        } catch (\Throwable $e) {
            return null;
        }
    }
    public function blog()
    {
        // Cache for 1 hour (matches Next.js revalidate: 3600)       
        $response = $this->fetchBlogData();
        $featuredArticle     = $response['data'] ?? [];      
    
        $popularArticles = array_slice($featuredArticle, 1, 3);
        $tickerArticles  = array_slice($featuredArticle, 4, 10);
        $listArticles    = array_slice($featuredArticle, 1);   
        $firstBlog    = $featuredArticle['0'];   
 
        $categories = [
            ['name' => 'SAP Certification',    'count' => 42],
            ['name' => 'Business Technology',  'count' => 28],
            ['name' => 'Cloud Computing',      'count' => 19],
            ['name' => 'Programming',          'count' => 15],
            ['name' => 'Data Science',         'count' => 24],
            ['name' => 'IT Administration',    'count' => 11],
        ];
 
        // $tags = [
        //     'SAP S/4HANA', 'FICO', 'ABAP', 'Python', 'AWS',
        //     'Azure', 'Machine Learning', 'DevOps', 'Database', 'Security',
        // ];
        $tags ="";
        return view('official.blog', compact(
            'featuredArticle',
            'firstBlog',
            'popularArticles',
            'tickerArticles',
            'listArticles',
            'categories',
            'tags'
        ));
        
    }
    public function blogdetails(Request $request, $slug)
    {
        $cacheKey = 'blog_article_' . md5($slug); 
        $data = Cache::remember($cacheKey, 3600, function () use ($slug) {
            try {
                $response = Http::timeout(10)->withoutVerifying()
                    ->get('https://api.quickdials.com/api/website/blog', [
                        'blog_slug' => $slug,
                    ]);
                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                \Log::error('Blog detail API failed: ' . $e->getMessage());
            }
            return null;
        });
 
        if (!$data) abort(404);
 
        // Handle both { data: {} } and { data: [{}] }
        $raw = $data['data'] ?? null;
        if (is_array($raw) && isset($raw[0])) {
            $raw = $raw[0];
        }
        if (!$raw) abort(404);
 
        $blogDetails = $raw['blogDetails'] ?? [];
        $blogList    = $raw['blogList']    ?? [];
        $tickerItems = array_slice($blogList, 4, 10);
 
        // Build FAQ — filter empty pairs
        $faqs = [];
        for ($i = 1; $i <= 6; $i++) {
            $q = $blogDetails["faqq{$i}"] ?? null;
            $a = $blogDetails["faqa{$i}"] ?? null;
            if ($q && $a) {
                $faqs[] = ['q' => $q, 'a' => $a];
            }
        }
 
        // Author gradient colour (rotated by article id)
        $gradients = [
            'linear-gradient(135deg,#1e3a5f 0%,#2563eb 50%,#0891b2 100%)',
            'linear-gradient(135deg,#14532d 0%,#16a34a 50%,#0d9488 100%)',
            'linear-gradient(135deg,#4c1d95 0%,#7c3aed 50%,#db2777 100%)',
            'linear-gradient(135deg,#7c2d12 0%,#ea580c 50%,#d97706 100%)',
            'linear-gradient(135deg,#064e3b 0%,#0f766e 50%,#0284c7 100%)',
            'linear-gradient(135deg,#581c87 0%,#a21caf 50%,#db2777 100%)',
        ];
        $authorColor = $gradients[(int)($blogDetails['id'] ?? 0) % count($gradients)];
 
        // Paragraphs — filter blank
        $paragraphs = array_values(array_filter([
            $blogDetails['paragraph1'] ?? '',
            $blogDetails['paragraph2'] ?? '',
            $blogDetails['paragraph3'] ?? '',
            $blogDetails['paragraph4'] ?? '',
            $blogDetails['paragraph5'] ?? '',
            $blogDetails['paragraph6'] ?? '',
        ], fn($p) => trim($p) !== ''));
 
        return view('official.blog-details', compact(
            'blogDetails','blogList','tickerItems',
            'faqs','authorColor','paragraphs','slug'
        ));
         
    }

    public function testimonials()
    {
        $testimonialsdetails = Testimonialsdetail::orderBy('id', 'DESC')->get();
        return view('official.testimonials', ['testimonialsdetails' => $testimonialsdetails]);
    }
    public function termsconditions()
    {


        return view('official.terms-conditions');
    }

    public function privacypolicy()
    {
        return view('official.privacy-policy');
    }

    public function copyrightpolicy()
    {
        return view('official.copyright-policy');
    }
    public function refundPolicy()
    {
        return view('official.refund-policy');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function enquerystore(Request $request)
    {

        $lead = new LeadEnquery;
        $lead->business = $request->input('business');
        $lead->name = $request->input('name');
        $lead->mobile = $request->input('mobile');
        $lead->email = $request->input('email');
        $lead->city = $request->input('city');

        if ($lead->save()) {
            $followUp = new EnquiryFollowUp;
            $followUp->remark = $request->input('message');
            $followUp->enquiry_id = $lead->id;

            if ($followUp->save()) {
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                // Additional headers

                $headers .= 'From: QuickDials <info@quickdials.com>' . "\r\n";
                $to = "info@quickdials.com" . "\r\n";
                //	$to="care@quickdials.com". "\r\n";
                $subject = "New Enquiry" . "\r\n";
                //	$message=view('site.send_enquiry_mail_thanks');

                $message = '<html>
<body>
<table class="m_-3031551356041827469MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
    <tbody>
        <tr>
            <td style="padding:0in 0in 0in 0in">
                <div align="center">
                    <table class="m_-3031551356041827469MsoNormalTable" border="1" cellspacing="0" cellpadding="0" width="630" style="width:472.5pt;background:white;border:solid #cccccc 1.0pt">
                        <tbody>
                            <tr>
                                <td colspan="3" style="border:none;padding:0in 0in 0in 0in">
                                    <div align="center">
                                        <table class="m_-3031551356041827469MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
                                            <tbody>
                                                <tr style="height:3.75pt">
                                                    <td style="background:#06A2E3;padding:0in 0in 0in 0in;height:3.75pt"></td>
                                                    <td style="background:#B12642;padding:0in 0in 0in 0in;height:3.75pt"></td>
                                                    <td style="background:#06A2E3;padding:0in 0in 0in 0in;height:3.75pt"></td>
                                                    <td style="background:#B12642;padding:0in 0in 0in 0in;height:3.75pt"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr style="height:60.0pt">
                                <td width="55%" style="width:55.0%;border:none;padding:0in 7.5pt 0in 7.5pt;height:60.0pt">
                                    <p class="MsoNormal" style="line-height:0%"><span style="font-size:1.0pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333"><a href="http://quickdials.com/" title="quickdials" target="_blank"><span style="text-decoration:none"><img loading="lazy" border="0" id="m_-3031551356041827469_x0000_i1025" src="http://quickdials.com/assets/images/logo.png" alt="quickdials" class="CToWUd" width="100px"></span></a>
                                        </span><u></u><u></u></p>
                                </td>
                                <td width="45%" style="border:none;padding:0in 7.5pt 0in 0in;height:60.0pt">
                                    <p class="MsoNormal" align="right" style="text-align:right;line-height:0%"><span style="font-size:1.0pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333"><a href="http://quickdials.com/" title="quickdials" target="_blank"><span style="text-decoration:none"><img loading="lazy" border="0" width="56%" height="auto" id="m_-3031551356041827469_x0000_i1026" src="http://quickdials.com/assets/images/ISO_9001_Logo.png" alt="ISO" class="CToWUd"></span></a>
                                        </span><u></u><u></u></p>
                                </td>
                                <td style="border:none;padding:0in 0in 0in 0in;height:60.0pt"></td>
                            </tr>
                            <tr style="height:.75pt">
                                <td colspan="3" style="border:none;background:#e5e5e5;padding:0in 7.5pt 0in 7.5pt;height:.75pt"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="border:none;padding:0in 0in 0in 0in">
                                    <table class="m_-3031551356041827469MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
                                        <tbody>
                                            <tr>
                                                <td style="background:#232222;padding:12.5pt 6.0pt 12.5pt 6.0pt">
                                                    <p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:14.0pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:white">Enquiry From quickdials.</span><u></u><u></u></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:22.5pt 15.0pt 22.5pt 15.0pt">
                                                    <div>
                                                        <p class="MsoNormal"><b><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Hi Team,</span></b><u></u><u></u></p>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0in 15.0pt 0in 15.0pt;border-radius:10px">
                                                    <table class="m_-3031551356041827469MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border:solid #cccccc 1.0pt;padding:11.25pt 11.25pt 11.25pt 11.25pt">
                                                                    <table class="m_-3031551356041827469MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 15.0pt 0in">
                                                                                    <p class="MsoNormal"><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">You have received an enquiry from our client. Here are the details:</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 7.5pt 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Campany Name:</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">
																					' . $request->input('business') . '</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
																			
																			<tr>
                                                                                <td style="padding:0in 0in 7.5pt 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Name:</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">
																					' . $request->input('name') . '</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 7.5pt 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Email:</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">
																					' . $request->input('email') . '</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 7.5pt 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Mobile:</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333"> ' . $request->input('mobile') . '</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            
                                                                           
																			<tr>
                                                                                <td style="padding:0in 0in 7.5pt 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">City:</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333"> ' . $request->input('city') . '</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
																			<tr>
                                                                                <td style="padding:0in 0in 7.5pt 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Message:</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333"> ' . $request->input('message') . '</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                       
																			<tr><td style="padding:18pt 0in 0in 0in;"></td></tr>
																			<tr>
                                                                                <td style="padding:0in 0in 7.5pt 0in">
                                                                                    <p class="MsoNormal" style="text-decoration:underline"><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Note:</span><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333"> This is a system generated email. Please do not reply.</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="border:none;border-bottom:dashed #cccccc 1.0pt;padding:0in 0in 5.0pt 0in"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:11.25pt 0in 11.25pt 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Contact Details of quickdials:</span></strong><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 0in 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Address :</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">
          UNIT 101 OXFORD TOWERS, 139/88 HAL OLD AIRPORT RD, H.A.L II Stage, Bangalore North, Bangalore- 560008, Karnataka</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 0in 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Email ID :</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">
          info@quickdials.com</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 0in 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Mobile number:</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">
          +91-9058100001</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 0in 0in">
                                                                                    <p class="MsoNormal">&nbsp;<u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 0in 0in">
                                                                                    <p class="MsoNormal"><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Contact us on the above details for any confussion or clarification. </span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:22.5pt 15.0pt 22.5pt 15.0pt">
                                                    <div>
                                                        <p class="MsoNormal" style="line-height:18.75pt"><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Regards,<br>
      quickdials (P) Ltd. </span><u></u><u></u></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>';

                //	$message=file_get_contents($message);
                /*$message=preg_replace('NA',$request->input('name'),$message);
            $message=preg_replace('EM',$request->input('email'),$message);
                $message=preg_replace('MB',$request->input('mobile'),$message);
                $message=preg_replace('CI',$request->input('city'),$message);
                $message=preg_replace('ME',$request->input('message'),$message);*/

                mail($to, $subject, $message, $headers);


                if ($lead->email) {

                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    // Additional headers
                    //	$headers .= 'From: enquiry@quickdials.com' . "\r\n";
                    $headers .= 'From: quickdials <care@quickdials.com>';
                    //$headers .= "CC: info@gmail.com\r\n";
                    $to = $lead->email;
                    $subject = "Thanks for quickdials Enquiry";
                    $message = '<html>
<body>
<table class="m_-3031551356041827469MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
    <tbody>
        <tr>
            <td style="padding:0in 0in 0in 0in">
                <div align="center">
                    <table class="m_-3031551356041827469MsoNormalTable" border="1" cellspacing="0" cellpadding="0" width="630" style="width:472.5pt;background:white;border:solid #cccccc 1.0pt">
                        <tbody>
                            <tr>
                                <td colspan="3" style="border:none;padding:0in 0in 0in 0in">
                                    <div align="center">
                                        <table class="m_-3031551356041827469MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
                                            <tbody>
                                                <tr style="height:3.75pt">
                                                    <td style="background:#06A2E3;padding:0in 0in 0in 0in;height:3.75pt"></td>
                                                    <td style="background:#B12642;padding:0in 0in 0in 0in;height:3.75pt"></td>
                                                    <td style="background:#06A2E3;padding:0in 0in 0in 0in;height:3.75pt"></td>
                                                    <td style="background:#B12642;padding:0in 0in 0in 0in;height:3.75pt"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr style="height:60.0pt">
                                <td width="55%" style="width:55.0%;border:none;padding:0in 7.5pt 0in 7.5pt;height:60.0pt">
                                    <p class="MsoNormal" style="line-height:0%"><span style="font-size:1.0pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333"><a href="http://quickdials.com/" title="quickdials" target="_blank"><span style="text-decoration:none"><img loading="lazy" border="0" id="m_-3031551356041827469_x0000_i1025" src="http://quickdials.com/assets/images/logo.png" alt="quickdials" class="CToWUd" width="100px"></span></a>
                                        </span><u></u><u></u></p>
                                </td>
                                <td width="45%" style="border:none;padding:0in 7.5pt 0in 0in;height:60.0pt">
                                    <p class="MsoNormal" align="right" style="text-align:right;line-height:0%"><span style="font-size:1.0pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333"><a href="http://quickdials.com/" title="quickdials" target="_blank"><span style="text-decoration:none"><img loading="lazy" border="0" width="56%" height="auto" id="m_-3031551356041827469_x0000_i1026" src="http://quickdials.com/assets/images/ISO_9001_Logo.png" alt="ISO" class="CToWUd" width="100px"></span></a>
                                        </span><u></u><u></u></p>
                                </td>
                                <td style="border:none;padding:0in 0in 0in 0in;height:60.0pt"></td>
                            </tr>
                            <tr style="height:.75pt">
                                <td colspan="3" style="border:none;background:#e5e5e5;padding:0in 7.5pt 0in 7.5pt;height:.75pt"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="border:none;padding:0in 0in 0in 0in">
                                    <table class="m_-3031551356041827469MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
                                        <tbody>
                                            <tr>
                                                <td style="background:#232222;padding:12.5pt 6.0pt 12.5pt 6.0pt;height: 160px;">
                                                    <p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:20.0pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:white">Thank You !!</span><u></u><u></u></p> 

													<p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:20.0pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:white">Your Enquiry has been received.</span><u></u><u></u></p>
													
											<p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:10.0pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:white">We will get back to you soon.</span><u></u><u></u></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:22.5pt 15.0pt 22.5pt 15.0pt">
                                                    <div>
                                                        <p class="MsoNormal"><b><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333"></span></b><u></u><u></u></p>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0in 15.0pt 0in 15.0pt;border-radius:10px">
                                                    <table class="m_-3031551356041827469MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border:solid #cccccc 1.0pt;padding:11.25pt 11.25pt 11.25pt 11.25pt">
                                                                    <table class="m_-3031551356041827469MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
                                                                        <tbody>
                                                                       
																			 
																			<tr><td class="m_8854432245175541298sectionTitle" style="font-family:sans-serif;color:#313a42;border-collapse:collapse;text-align:center;font-size:26px;padding:0px 10px 10px 10px">Helpline No.</td></tr>

																			<tr><td class="m_-5925867924380956427sectionTitle" style="font-family:sans-serif;color:#313a42;border-collapse:collapse;text-align:center;font-size:26px;padding:0px 10px 10px 10px"><strong>+91-9058-100-001</strong></td></tr>																 <tr><td class="m_-5925867924380956427button" style="font-family:sans-serif;color:#313a42;border-collapse:collapse;padding:10px 5px 10px 5px;text-align:center;background-color:#ff6b6b;border-radius:4px"><a href="http://quickdials.com/" title="quickdials" style="color:#ffffff;text-decoration:none;display:block;text-transform:uppercase" target="_blank" data-saferedirecturl="">Visit Us</a></td></tr>
																			   
																			<tr><td style="padding:18pt 0in 0in 0in;"></td></tr>
																			
																		 
                                                                            <tr>
                                                                                <td style="border:none;border-bottom:dashed #cccccc 1.0pt;padding:0in 0in 5.0pt 0in"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:11.25pt 0in 11.25pt 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Contact Details of quickdials:</span></strong><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 0in 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Address :</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">
       UNIT 101 OXFORD TOWERS, 139/88 HAL OLD AIRPORT RD, H.A.L II Stage, Bangalore North, Bangalore- 560008, Karnataka </span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 0in 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Email ID :</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">
          info@quickdials.com</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 0in 0in">
                                                                                    <p class="MsoNormal"><strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Mobile number:</span></strong><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">
          +91-9058100001</span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding:0in 0in 0in 0in">
                                                                                    <p class="MsoNormal">&nbsp;<u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                         
																			
																			<tr>
                                                                                <td style="padding:0in 0in 0in 0in">
                                                                                    <p class="MsoNormal"><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Contact us on the above details for any confussion or clarification. </span><u></u><u></u></p>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:22.5pt 15.0pt 22.5pt 15.0pt">
                                                    <div>
                                                        <p class="MsoNormal" style="line-height:18.75pt"><span style="font-size:10.5pt;font-family:&quot;Tahoma&quot;,&quot;sans-serif&quot;;color:#333333">Regards,<br>
      quickdials (P) Ltd. </span><u></u><u></u></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>';
                    mail($to, $subject, $message, $headers);
                }

                return response()->json(['status' => 1], 200);

            } else {

                return response()->json(['status' => 0, 'errors' => 'Enquiry not added'], 400);
            }
        } else {
            return response()->json(['status' => 0], 200);

        }


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contactform(Request $request)
    {

        $lead = new LeadEnquery;
        $lead->business = $request->input('subject');
        $lead->name = $request->input('name');
        $lead->mobile = $request->input('mobile');
        $lead->email = $request->input('email');
        $lead->city = $request->input('city');

        if ($lead->save()) {
            $followUp = new EnquiryFollowUp;
            $followUp->remark = $request->input('message');
            $followUp->enquiry_id = $lead->id;
            $followUp->save();
            return response()->json(['status' => 1], 200);
        } else {
            return response()->json(['status' => 0], 200);

        }


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {

        $subscribe = new Subscribe;
        $subscribe->email = $request->input('email');
        if ($subscribe->save()) {
            return response()->json(['status' => 1], 200);
        } else {
            return response()->json(['status' => 0], 200);

        }


    }

}
