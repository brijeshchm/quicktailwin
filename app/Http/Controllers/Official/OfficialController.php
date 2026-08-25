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
use App\Models\ChildCategory;
use App\Models\NewsArticle;
use App\Models\ParentCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use DB;
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
    public function about()
    {
        $clients = Client::get()->count();
        $keywordCount = Keyword::get()->count();
        $citieslists = Citieslists::get()->count();

        $city = "delhi";
        $metaTitle ="About QuickDials | India’s Leading Local Business Search Directory";
        $metaDescription  ="QuickDials is India’s trusted local business search and service directory, helping users find verified businesses, services, shops, and professionals near them"; 
        $keyword = "About us";

    return view('official.about_us', ['clients' => $clients, 'keywordCount' => $keywordCount, 'citieslists' => $citieslists,'city'=>$city,'metaTitle'=>$metaTitle,'metaDescription'=>$metaDescription,'keyword'=>$keyword]);
    }
  
  
    /**
     * Fetch data from the QuickDials API.
     */
    private function fetchNewsData(): ?array
    {
        try {
            $response = Http::timeout(10)
                ->withoutVerifying()->get('https://api.quickdials.com/api/website/getNews');
 
            return $response->successful() ? $response->json() : null;
        } catch (\Throwable $e) {
            return null;
        }
    }
   
   
    public function news()
    {
        // Cache for 1 hour (matches Next.js revalidate: 3600)       
        $response = $this->fetchNewsData();
        $featuredArticle     = $response['data'] ?? [];      
    
        $popularArticles = array_slice($featuredArticle, 1, 3);
        $tickerArticles  = array_slice($featuredArticle, 4, 10);
        $listArticles    = array_slice($featuredArticle, 1);   
        $firstNews    = $featuredArticle['0'];   
        $categories = NewsArticle::select('category_name as name', DB::raw('COUNT(*) as count'))
        ->whereNotNull('category_name')
        ->where('category_name', '!=', '')
        ->groupBy('category_name')
        ->orderBy('count', 'DESC')
        ->get();
 
        // $tags = [
        //     'SAP S/4HANA', 'FICO', 'ABAP', 'Python', 'AWS',
        //     'Azure', 'Machine Learning', 'DevOps', 'Database', 'Security',
        // ];
        $tags ="";
        $city = "delhi";
        $metaTitle = "QuickDials News | Latest Business Updates, Tips & Insights";
        $metaDescription = "Read the latest QuickDials news, business updates, service guides, local market insights, and helpful tips to find trusted services near you.";
        $keyword = "News";

        return view('official.news', compact(
            'featuredArticle',
            'firstNews',
            'popularArticles',
            'tickerArticles',
            'listArticles',
            'categories',
            'tags','city','metaTitle','metaDescription','keyword'
        ));
        
    }
    public function newsDetails(Request $request, $slug)
    {
        $cacheKey = 'news_article_' . md5($slug); 
        $data = Cache::remember($cacheKey, 3600, function () use ($slug) {
            try {
                $response = Http::timeout(10)->withoutVerifying()
                    ->get('https://api.quickdials.com/api/website/news', [
                        'news_slug' => $slug,
                    ]);
                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                \Log::error('News detail API failed: ' . $e->getMessage());
            }
            return null;
        });
 
        if (!$data) abort(410);
 
        // Handle both { data: {} } and { data: [{}] }
        $raw = $data['data'] ?? null;
        if (is_array($raw) && isset($raw[0])) {
            $raw = $raw[0];
        }
        if (!$raw) abort(410);
 
        $newsDetails = $raw['newsDetails'] ?? [];

       
        $newsList    = $raw['newsList']    ?? [];
        $tickerItems = array_slice($newsList, 4, 10);
 
        // Build FAQ — filter empty pairs
        $faqs = [];
        for ($i = 1; $i <= 6; $i++) {
            $q = $newsDetails["faqq{$i}"] ?? null;
            $a = $newsDetails["faqa{$i}"] ?? null;
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
        $authorColor = $gradients[(int)($newsDetails['id'] ?? 0) % count($gradients)];
 
        // Paragraphs — filter blank
        $paragraphs = array_values(array_filter([
            $newsDetails['paragraph1'] ?? '',
            $newsDetails['paragraph2'] ?? '',
            $newsDetails['paragraph3'] ?? '',
            $newsDetails['paragraph4'] ?? '',
            $newsDetails['paragraph5'] ?? '',
            $newsDetails['paragraph6'] ?? '',
        ], fn($p) => trim($p) !== ''));
 
            $categories = [];
        if(!empty($newsDetails['category_name'])){
            $categories = NewsArticle::select('category_name as name', DB::raw('COUNT(*) as count'))
            ->whereNotNull('category_name')
            ->where('status', '1')
            ->where('category_name',$newsDetails['category_name'])
            ->where('category_name', '!=', '')
            ->groupBy('category_name')
            ->orderBy('count', 'DESC')
            ->get();
        }

        $metaTitle = $newsDetails['title'];
        $metaDescription =  $newsDetails['meta_description'];
        $keyword = $newsDetails['name'];
        $city = "delhi";
        return view('official.news-details', compact(
            'newsDetails','newsList','tickerItems','categories',
            'faqs','authorColor','paragraphs','slug','metaTitle','metaDescription','keyword','city'
        ));
         
    }

    public function newsCategory(Request $request, $slug)
    {

   
        $news = NewsArticle::where('status', '1')->where('category_name',$slug)->orderBy('id', 'DESC')->get();
 
        $categories = NewsArticle::select('category_name as name', DB::raw('COUNT(*) as count'))
        ->whereNotNull('category_name')
        ->where('status', '1')
        ->where('category_name',$slug)
        ->where('category_name', '!=', '')
        ->groupBy('category_name')
        ->orderBy('count', 'DESC')
        ->get();
        $childCategory  = ChildCategory::where('child_slug',$slug)->first();

        if (!empty($childCategory->meta_title)) {
        $meta_title = $childCategory->meta_title;
        } else {
        $meta_title = $childCategory->parent_category ." | Find Trusted Services, Businesses & Professionals Near You | Quickdials ";

        }

        if (!empty($childCategory->h1_heading)) {
			$h1_heading = $childCategory->h1_heading;
		} else {
			 
						
			$h1_heading = $childCategory->parent_category . ", " .
                 $childCategory->parent_category . " near me, " .
                 "best " . $childCategory->parent_category . ", " .
                 "top " . $childCategory->parent_category . ", " .
                 "local " . $childCategory->parent_category . ", " .
                 "trusted " . $childCategory->parent_category . ", " .
                 "affordable " . $childCategory->parent_category . ", " .
                 $childCategory->parent_category . " services, " .
                 $childCategory->parent_category . " providers, Quickdials";

		}


		if (!empty($parentCategory->meta_description)) {
			$meta_description = $childCategory->meta_description;


		} else {
			 
			   $meta_description = "Find the best ".$childCategory->parent_category." near you on Quickdials. Compare trusted providers, read reviews, check details, and connect with top-rated businesses and professionals for your needs.";

		}


        $child_banner = config('app.website') . 'client/images/computer-courses-training.jpg';
		$alt = "";
		$pc_icon ="";
		if (!empty($childCategory->child_banner)) {
			$cicons = unserialize($childCategory->child_banner);

			if (!empty($cicons)) {
				$child_banner = config('app.website') . $cicons['child_banner']['src'];
				$alt = $cicons['child_banner']['name'];
			}
		}if (!empty($childCategory->pc_icon)) {
			$catIcons = unserialize($childCategory->pc_icon);

			if (!empty($catIcons)) {
				$pc_icon = config('app.website') . $catIcons['pc_icon']['src'];
				$alt = $catIcons['pc_icon']['name'];
			}
		}
			
        $kwData = array(
			'parent_category' => $childCategory->parent_category,
			'parent_slug' => $childCategory->parent_slug,
			'child_banner' => $child_banner,
			'category_icon' => $pc_icon,
			'alt' => $alt,
			'meta_title' => $meta_title,
			'h1_heading' => $h1_heading,
			'meta_description' => $meta_description,
			'top_description' => $childCategory->top_description,
			'bottom_description' => $childCategory->bottom_description,
			'bottom_heading' => $childCategory->bottom_heading,
			'top_heading' => $childCategory->top_heading,
			'faqq1' => $childCategory->faqq1,
			'faqa1' => $childCategory->faqa1,
			'faqq2' => $childCategory->faqq2,
			'faqa2' => $childCategory->faqa2,
			'faqq3' => $childCategory->faqq3,
			'faqa3' => $childCategory->faqa3,
			'faqq4' => $childCategory->faqq4,
			'faqa4' => $childCategory->faqa4,
			'faqq5' => $childCategory->faqq5,
			'faqa5' => $childCategory->faqa5,
			'ratingvalue' => $childCategory->ratingvalue,
			'ratingcount' => $childCategory->ratingcount,

		);
 
             
        return view('official.news-category', ['categories' => $categories,'news'=>$news,'kwData'=>$kwData,'metaTitle'=>$meta_title,'metaDescription'=>$meta_description,'keyword'=>$childCategory->parent_category]);
    }
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function rss()
    {
        $blogrecents = Blogdetails::where('status', '1')->limit(8)->orderBy('id', 'DESC')->get();
            
        $city = "delhi";
        $metaTitle = "QuickDials RSS | Latest Business Updates, Tips & Insights";
        $metaDescription = "Read the latest QuickDials RSS, business updates, service guides, local market insights, and helpful tips to find trusted services near you.";
        $keyword = "RSS";
        return view('official.rss', ['blogrecents' => $blogrecents,'city'=>$city,'metaTitle'=>$metaTitle,'metaDescription'=>$metaDescription,'keyword'=>$keyword]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function features()
    {

       $city = "delhi";
        $metaTitle = "QuickDials features | Latest Business Updates, Tips & Insights";
        $metaDescription = "Read the latest QuickDials features, business updates, service guides, local market insights, and helpful tips to find trusted services near you.";
        $keyword = "features";
        return view('official.features',compact('metaTitle','metaDescription','keyword','city'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function faq()
    {
        $city = "delhi";
        $metaTitle = "QuickDials FAQ | Frequently Asked Questions & Support";
        $metaDescription = "Find answers to common questions about QuickDials, business listings, services, user support, advertising, pricing, and local service search.";
        $keyword = "Faq";
        return view('official.faq',compact('metaTitle','metaDescription','keyword','city'));
    }

    public function contact()
    {
        $city = "delhi";
        $metaTitle ="Contact QuickDials | India’s Leading Local Business Search Directory";
        $metaDescription  ="QuickDials is India’s trusted local business search and service directory, helping users find verified businesses, services, shops, and professionals near them"; 
        $keyword = "Contact us";
        return view('official.contact-us',compact('city','metaTitle','metaDescription','keyword'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function careers()
    {

     $city = "delhi";
        $metaTitle ="Careers QuickDials | India’s Leading Local Business Search Directory";
        $metaDescription  ="QuickDials is India’s trusted local business search and service directory, helping users find verified businesses, services, shops, and professionals near them"; 
        $keyword = "careers us";

        return view('official.careers',compact('city','metaTitle','metaDescription','keyword'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pricing()
    {

     $city = "delhi";
        $metaTitle ="Pricing QuickDials | India’s Leading Local Business Search Directory";
        $metaDescription  ="QuickDials is India’s trusted local business search and service directory, helping users find verified businesses, services, shops, and professionals near them"; 
        $keyword = "Pricing us";


        return view('official.pricing',compact('city','metaTitle','metaDescription','keyword'));
    } 
    
      
    /**
      * Show the application dashboard.
      *
      * @return \Illuminate\Http\Response
      */
    public function advertise()
    {
           $city = "delhi";
        $metaTitle ="advertise QuickDials | India’s Leading Local Business Search Directory";
        $metaDescription  ="QuickDials is India’s trusted local business search and service directory, helping users find verified businesses, services, shops, and professionals near them"; 
        $keyword = "advertise us";
        return view('official.advertise',compact('city','metaTitle','metaDescription','keyword'));
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
        $categories = Blogdetails::select('category_name as name', DB::raw('COUNT(*) as count'))
        ->whereNotNull('category_name')
        ->where('category_name', '!=', '')
        ->groupBy('category_name')
        ->orderBy('count', 'DESC')
        ->get();
 
   
        $tags ="";

        $city = "delhi";
        $metaTitle = "QuickDials Blog | Local Business Tips, Guides & Updates";
        $metaDescription = "Read QuickDials blogs for local business tips, service guides, market updates, and helpful information to find trusted businesses and services near you.";
        $keyword = "Blog";
        return view('official.blog', compact(
            'featuredArticle',
            'firstBlog',
            'popularArticles',
            'tickerArticles',
            'listArticles',
            'categories',
            'tags','city','metaTitle','metaDescription','keyword'
        ));
        
    }
    public function blogdetails(Request $request, $slug)
    {
        $data = null;
        try {
            $response = Http::timeout(10)
                ->withoutVerifying()
                ->get('https://api.quickdials.com/api/website/blog', [
                    'blog_slug' => $slug,
                ]);

            if ($response->successful()) {
                $data = $response->json();
            }
        } catch (\Exception $e) {
            \Log::error('Blog detail API failed: ' . $e->getMessage());
        }

        if (!$data) abort(410);
 
        // Handle both { data: {} } and { data: [{}] }
        $raw = $data['data'] ?? null;
        if (is_array($raw) && isset($raw[0])) {
            $raw = $raw[0];
        }
        if (!$raw) abort(410);
 
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
 
            $categories = [];
        if(!empty($blogDetails['category_name'])){
            $categories = Blogdetails::select('category_name as name', DB::raw('COUNT(*) as count'))
            ->whereNotNull('category_name')
            ->where('status', '1')
            ->where('category_name',$blogDetails['category_name'])
            ->where('category_name', '!=', '')
            ->groupBy('category_name')
            ->orderBy('count', 'DESC')
            ->get();
        }

        $city = "delhi";
        $metaTitle =$blogDetails['meta_title'];
        $metaDescription =  $blogDetails['meta_description'];
        $keyword = $blogDetails['title'];
        return view('official.blog-details', compact(
            'blogDetails','blogList','tickerItems','categories',
            'faqs','authorColor','paragraphs','slug','city','metaTitle','metaDescription','keyword'
        ));
         
    }

    public function blogCategory(Request $request, $slug)
    {
    $childCategory = ChildCategory::where('child_slug', $slug)->first();

    // Bug #2 & #6 fix — bail out cleanly instead of null-property errors
    if (!$childCategory) {
        abort(404);
    }

    $blogs = Blogdetails::where('status', '1')
        ->where('category_name', $slug)
        ->orderBy('id', 'DESC')
        ->get();

    // Bug #3 fix — get ALL categories (for sidebar/related list), not just the current slug
    $categories = Blogdetails::select('category_name as name', DB::raw('COUNT(*) as count'))
        ->whereNotNull('category_name')
        ->where('status', '1')
        ->where('category_name', '!=', '')
        ->groupBy('category_name')
        ->orderBy('count', 'DESC')
        ->get();

    $meta_title = !empty($childCategory->meta_title)
        ? $childCategory->meta_title
        : "Find Trusted Services, Businesses & Professionals Near You | Quickdials";

    $h1_heading = !empty($childCategory->h1_heading)
        ? $childCategory->h1_heading
        : implode(', ', [                      
            "best " . $childCategory->child_category,            
        ]);
 
    // Bug #1 fix — was checking $parentCategory (undefined)
    $meta_description = !empty($childCategory->meta_description)
        ? $childCategory->meta_description
        : "Find the best {$childCategory->parent_category} near you on Quickdials. Compare trusted providers, read reviews, check details, and connect with top-rated businesses and professionals for your needs.";

    $child_banner = config('app.website') . 'client/images/computer-courses-training.jpg';
    $alt = "";
    $pc_icon = "";

    // Bug #4 fix — safe unserialize, no object injection risk
    if (!empty($childCategory->child_banner)) {
        $cicons = @unserialize($childCategory->child_banner, ['allowed_classes' => false]);
        if (!empty($cicons['child_banner']['src'])) {
            $child_banner = config('app.website') . $cicons['child_banner']['src'];
            $alt = $cicons['child_banner']['name'] ?? '';
        }
    }

    if (!empty($childCategory->pc_icon)) {
        $catIcons = @unserialize($childCategory->pc_icon, ['allowed_classes' => false]);
        if (!empty($catIcons['pc_icon']['src'])) {
            $pc_icon = config('app.website') . $catIcons['pc_icon']['src'];
            $alt = $catIcons['pc_icon']['name'] ?? '';
        }
    }
//$keyword="";
    $kwData = [
        'parent_category'    => $childCategory->parent_category,
         'child_category'    => $childCategory->child_category,
        'parent_slug'        => $childCategory->parent_slug,
        'child_banner'       => $child_banner,
        'keyword'       => $childCategory->child_category,
        'category_icon'      => $pc_icon,
        'alt'                => $alt,
        'meta_title'         => $meta_title,
        'title'         => $h1_heading,
        'h1_heading'      => $h1_heading,
        'meta_description'  => $meta_description,
        'top_description'    => $childCategory->top_description,
        'bottom_description' => $childCategory->bottom_description,
        'bottom_heading'     => $childCategory->bottom_heading,
        'top_heading'        => $childCategory->top_heading,
        'faqq1' => $childCategory->faqq1, 'faqa1' => $childCategory->faqa1,
        'faqq2' => $childCategory->faqq2, 'faqa2' => $childCategory->faqa2,
        'faqq3' => $childCategory->faqq3, 'faqa3' => $childCategory->faqa3,
        'faqq4' => $childCategory->faqq4, 'faqa4' => $childCategory->faqa4,
        'faqq5' => $childCategory->faqq5, 'faqa5' => $childCategory->faqa5,
        'ratingvalue' => $childCategory->ratingvalue,
        'ratingcount' => $childCategory->ratingcount,
    ];

    // Bug #5 — hardcoded city, see note below
    $city = $request->get('city', 'delhi');

    return view('client.blog-category', [
        'categories'      => $categories,
        'blogs'           => $blogs,
        'kwData'          => $kwData,
        'city'            => $city,
        'metaTitle'       => $meta_title,
        'metaDescription' => $meta_description,
        'keyword'         => $childCategory->child_category,
    ]);
}
 
    public function termsconditions()
    {

        $city ="delhi";
        $metaTitle = "Terms and Conditions | QuickDials";
        $metaDescription = "Read QuickDials terms and conditions to understand our website usage policies, business listing rules, user responsibilities, and service guidelines.";
        $keyword = "Terms and Conditions";
        return view('official.terms-conditions', compact('city','metaTitle','metaDescription','keyword'));
    }

    public function privacypolicy()
    {
        $city ="delhi";
        $metaTitle = "Privacy Policy | QuickDials";
        $metaDescription = "Read QuickDials Privacy Policy to understand our website usage policies, business listing rules, user responsibilities, and service guidelines.";
        $keyword = "Privacy Policy";
        return view('official.privacy-policy',compact('city','metaTitle','metaDescription','keyword'));
    }

    public function copyrightpolicy()
    {
        $city ="delhi";
        $metaTitle = "Copyright Policy | QuickDials";
        $metaDescription = "Read QuickDials Copyright Policy to understand our website usage policies, business listing rules, user responsibilities, and service guidelines.";
        $keyword = "Copyright Policy";
        return view('official.copyright-policy',compact('city','metaTitle','metaDescription','keyword'));
    }
    public function refundPolicy()
    {
        $city ="delhi";
        $metaTitle = "Refund Policy | QuickDials";
        $metaDescription = "Read QuickDials Refund Policy to understand our website usage policies, business listing rules, user responsibilities, and service guidelines.";
        $keyword = "Refund Policy";
        return view('official.refund-policy',compact('city','metaTitle','metaDescription','keyword'));
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
