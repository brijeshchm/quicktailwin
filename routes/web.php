<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;



 
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Client\HomePageController;
use App\Http\Controllers\Client\SearchListController;
use App\Http\Controllers\Client\CitySlugController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

 
//Route::auth();
//Auth::routes();

 
 


use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Business\EnquiryController;
Route::middleware('auth:clients')->group(function () {
	//Auth::routes();

	Route::get('/business/dashboard', [App\Http\Controllers\Business\BusinessDashboardController::class, 'dashboard']);
	Route::get('/business-owners/get-leads', [EnquiryController::class, 'getLeads']);
	Route::get('/business/enquiry', [EnquiryController::class, 'enquiry']);
	Route::get('/business/lead-follow-up', [EnquiryController::class, 'leadFollowUp']);
	Route::get('/business/new-enquiry', [EnquiryController::class, 'newEnquiry']);
	Route::get('/business/myLead', [EnquiryController::class, 'myLead']);
	Route::get('/business/favorite-enquiry', [EnquiryController::class, 'favoriteEnquiry']);
	Route::get('/business/manage-enquiry', [EnquiryController::class, 'manageEnquiry']);
	Route::get('/business-owners/get-Discussion', [App\Http\Controllers\Business\BusinessDiscussionController::class, 'getDiscussion']);
	Route::get('/business-owners/get-paginated-assigned-keywords', [App\Http\Controllers\Business\BusinessKeywordController::class, 'getPaginatedAssignedKeywords']);

	//Route::get('/business-owners/get-paginated-payment-history',[App\Http\Controllers\Business\BusinessOwnerController::class, 'getPaginatedPaymentHistory']);

	Route::post('/business-owners/export-excel', [App\Http\Controllers\Business\EnquiryController::class, 'getLeadsExcel']);

	//Route::post('/business-owners/discussion',[App\Http\Controllers\Client\BusinessDiscussionController::class, 'discussion']);

	Route::get('/business/personal-details', [App\Http\Controllers\Business\PersonalDetailsController::class, 'personalDetails']);
	Route::get('/business/profileInfo', [App\Http\Controllers\Business\ProfileController::class, 'profileInfo']);
	Route::post('/business/saveProfileInfo/{id}', [App\Http\Controllers\Business\ProfileController::class, 'saveProfileInfo']);
	Route::post('/business/saveBusinessLocation/{id}', [App\Http\Controllers\Business\ProfileController::class, 'saveBusinessLocation']);


	Route::get('/business/business-social', [App\Http\Controllers\Business\ProfileController::class, 'getBusinessSocial']);

	Route::post('/business/editSaveSocials/{id}', [App\Http\Controllers\Business\ProfileController::class, 'saveBusinessSocial']);



	Route::get('/business/business-certificate', [App\Http\Controllers\Business\CertificateController::class, 'getBusinessCertificate']);

	Route::get('/business/business-award', [App\Http\Controllers\Business\CertificateController::class, 'getBusinessAward']);
	Route::post('/business/editSaveCertificate/{id}', [App\Http\Controllers\Business\CertificateController::class, 'saveBusinessCertificate']);
	Route::post('/business/save-certificate-auto', [App\Http\Controllers\Business\CertificateController::class, 'autoSaveCertificate']);

	Route::post('/business/save-award-auto', [App\Http\Controllers\Business\CertificateController::class, 'saveBusinessAward']);



	Route::get('/business/certificate/{slug}/{id}', [App\Http\Controllers\Business\CertificateController::class, 'certificateDel']);
	Route::get('/business/award/{slug}/{id}', [App\Http\Controllers\Business\CertificateController::class, 'awardDel']);




	Route::post('/business/savePersonalDetails/{id}', [App\Http\Controllers\Business\PersonalDetailsController::class, 'savePersonalDetails']);

	Route::get('/business/profile-logo', [App\Http\Controllers\Business\BusinessLogoController::class, 'profileLogo']);
	Route::post('/business/saveProfileLogo', [App\Http\Controllers\Business\BusinessLogoController::class, 'saveProfileLogo']);
	Route::get('/business/profileLogo/logoDel/{id}', [App\Http\Controllers\Business\BusinessLogoController::class, 'logoDel']);
	Route::get('/business/profileLogo/profilePicDel/{id}', [App\Http\Controllers\Business\BusinessLogoController::class, 'profilePicDel']);

	Route::get('/business/gallery-pictures', [App\Http\Controllers\Business\BusinessLogoController::class, 'uploadPictures']);

	Route::post('/business/saveGallary', [App\Http\Controllers\Business\BusinessLogoController::class, 'saveGallary']);


	Route::get('/business/location-information', [App\Http\Controllers\Business\BusinessLocationController::class, 'locationInformation']);
	Route::post('/business/saveLocationInformation', [App\Http\Controllers\Business\BusinessLocationController::class, 'saveLocationInformation']);

	//review
	Route::get('/business/get-business-review', [App\Http\Controllers\Business\ReviewController::class, 'getBusinessReviewPagination']);
	Route::get('/business/review/delete/{id}', [App\Http\Controllers\Business\ReviewController::class, 'reviewDelete']);
	Route::get('/business/business-review', [App\Http\Controllers\Business\ReviewController::class, 'businessReview']);
	Route::get('/business/review/editReview/{id}', [App\Http\Controllers\Business\ReviewController::class, 'getReviewEdit']);
	Route::post('/business/review/update-review/{id}', [App\Http\Controllers\Business\ReviewController::class, 'updateReviewEdit']);


	///

	Route::post('/business/pauseLead', [App\Http\Controllers\Business\EnquiryController::class, 'pauseLead']);
	Route::post('/business/scrapLead', [App\Http\Controllers\Business\EnquiryController::class, 'scrapLead']);
	Route::post('/business/readLead', [App\Http\Controllers\Business\EnquiryController::class, 'readLead']);
	Route::post('/business/favoritleads', [App\Http\Controllers\Business\EnquiryController::class, 'favoritleads']);

	Route::post('/business/cities/getajaxcities', [App\Http\Controllers\Client\BusinessController::class, 'getAjaxCities']);
	Route::post('/business/state/getAjaxSate', [App\Http\Controllers\Client\BusinessController::class, 'getAjaxSate']);
	Route::post('/business/zone/getAjaxZone', [App\Http\Controllers\Client\BusinessController::class, 'getAjaxZone']);
	Route::get('/business/get-assigned-zones', [App\Http\Controllers\Client\BusinessController::class, 'getAssignedZonesPagination']);

	Route::get('/business/assignZone/delete/{id}', [App\Http\Controllers\Client\BusinessController::class, 'assignZoneDelete']);

	Route::post('/business/assignLocation/selectAssignZoneDelete', [App\Http\Controllers\Client\BusinessController::class, 'selectAssignZoneDelete']);


	Route::get('/business/package', [App\Http\Controllers\Business\AccountController::class, 'package']);
	Route::get('/business/account-settings', [App\Http\Controllers\Business\AccountController::class, 'accountSettings']);
	Route::get('/business/business-location', [App\Http\Controllers\Business\BusinessLocationController::class, 'businessLocation']);


	Route::get('/business/buy-package', [App\Http\Controllers\Business\AccountController::class, 'buyPackage']);

	Route::get('/business/billing-history', [App\Http\Controllers\Business\InvoiceController::class, 'billingHistory']);

	Route::get('/business/get-billing-history', [App\Http\Controllers\Business\InvoiceController::class, 'getBillingHistory']);

	//Route::get('/business/getinvoiceBillingPrintPdf/{id}',[App\Http\Controllers\Business\InvoiceController::class, 'getinvoiceBillingPrintPdf']);
	Route::get(
		'business/getinvoiceBillingPrintPdf/{id}',
		[App\Http\Controllers\Business\InvoiceController::class, 'getinvoiceBillingPrintPdf']
	)->name('invoice.billing.pdf');
	Route::get('/business/coinsHistory', [App\Http\Controllers\Business\InvoiceController::class, 'coinsHistory']);

	Route::get('/business/get-paginated-payment-history', [App\Http\Controllers\Business\InvoiceController::class, 'getPaginatedPaymentHistory']);


	Route::get('/business/help', [App\Http\Controllers\Client\BusinessController::class, 'help']);
	Route::get('/business/businessActiveStatus/{id}/{val}', [App\Http\Controllers\Client\BusinessController::class, 'businessActiveStatus']);

	Route::get('/business/get-enquiry', [App\Http\Controllers\Business\EnquiryController::class, 'getPaginatedLeads']);
	Route::get('/business/enquiry/follow-up/{id}', [App\Http\Controllers\Business\EnquiryController::class, 'followUp']);
	Route::post('/business/enquiry/store-follow-up/{id}', [App\Http\Controllers\Business\EnquiryController::class, 'storeFollowUp']);
	Route::get('/business/enquiry/getfollowups/{id}', [App\Http\Controllers\Business\EnquiryController::class, 'getFollowUps']);


	Route::get('/business/get-lead-follow', [App\Http\Controllers\Business\EnquiryController::class, 'getLeadFollow']);


	Route::get('/business/keywords', [App\Http\Controllers\Business\BusinessKeywordController::class, 'keywords']);


	Route::post('/business/saveKeywordAssign/{id}', [App\Http\Controllers\Business\BusinessKeywordController::class, 'saveKeywordAssign']);
	Route::get('/business/assignKeyword/delete/{id}', [App\Http\Controllers\Business\BusinessKeywordController::class, 'assignKeywordDelete']);
	Route::get('/business/get-paginated-assigned-keywords', [App\Http\Controllers\Business\BusinessKeywordController::class, 'getPaginatedAssignedKeywords']);


	Route::get('/business/coins-history', [App\Http\Controllers\Business\InvoiceController::class, 'coinsHistory']);



	/* Change Password - CLIENT */
	Route::get('/business-owners/changepassword', [App\Http\Controllers\Client\ChangePasswordController::class, 'create']);
	Route::post('/business-owners/changepassword', [App\Http\Controllers\Client\ChangePasswordController::class, 'store']);
	/* Change Password - CLIENT */

	/* Change Password - CLIENT */
	Route::get('/business/pay-deposit', [App\Http\Controllers\Client\RazorpayController::class, 'payDeposit']);
	Route::get('/business/subscribe-free', [App\Http\Controllers\Client\RazorpayController::class, 'subscribeFree']);
	Route::post('/business/saveSubscribeFree/{id}', [App\Http\Controllers\Client\RazorpayController::class, 'saveSubscribeFree']);
	Route::post('/business/razorPayCheckout', [App\Http\Controllers\Client\RazorpayController::class, 'razorPayCheckout']);
	Route::post('/business/save-processing', [App\Http\Controllers\Client\RazorpayController::class, 'saveProcessing']);
	Route::get('/business/success', [App\Http\Controllers\Client\RazorpayController::class, 'success']);
	Route::get('/business/failed', [App\Http\Controllers\Client\RazorpayController::class, 'failed']);



	/* Reset Password - CLIENT */
	Route::get('/resetp', [App\Http\Controllers\Client\ChangePasswordController::class, 'forgotPassword']);
	/* Reset Password - CLIENT */
});


/*login otp mobile */
Route::get('/client-login', [App\Http\Controllers\ClientAuth\AuthController::class, 'clientLogin']);
Route::post('/client-login', [App\Http\Controllers\ClientAuth\AuthController::class, 'clientLoginPost'])->name('client.login');

// Route::post('auth/send-otp', [App\Http\Controllers\ClientAuth\AuthController::class, 'sendOtp']);
//Route::post('/client-verify-otp', [App\Http\Controllers\ClientAuth\AuthController::class, 'clientVerifyOtp']);


Route::get('/google-login', [App\Http\Controllers\ClientAuth\AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [App\Http\Controllers\ClientAuth\AuthController::class, 'handleGoogleCallback']);



Route::post('/developer/login', [App\Http\Controllers\Auth\AuthController::class, 'authenticate']);
Route::get('/developer/login', [App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('developer.login');
Route::get('/cities/getajaxcities', [App\Http\Controllers\CitiesController::class, 'getAjaxCities']);
Route::get('/location/getAjaxLocation', [App\Http\Controllers\CitiesController::class, 'getAjaxLocation']);
Route::get('/location/getAjaxService', [App\Http\Controllers\CitiesController::class, 'getAjaxService']);

Route::prefix('developer')->name('developer.')->middleware(['auth:developer'])->as('developer.')->group(function () {
	require __DIR__ . '/developer.php';
});


Route::get('/interviews', [App\Http\Controllers\Client\InterviewController::class, 'index']);
Route::get('/interviews/php-interview-question-answer', [App\Http\Controllers\Client\InterviewController::class, 'phpInterview']);
Route::get('/interviews/mysql-interview-question-answer', [App\Http\Controllers\Client\InterviewController::class, 'mysqlInterview']);
Route::get('/interviews/technical-logic-question-answer', [App\Http\Controllers\Client\InterviewController::class, 'technicalInterview']);
Route::get('/interviews/laravel-interview-question-answer', [App\Http\Controllers\Client\InterviewController::class, 'laravelInterview']);
Route::get('/interviews/javascript-interview-question-answer', [App\Http\Controllers\Client\InterviewController::class, 'javascriptInterview']);
Route::get('/interviews/reactjs-interview-question-answer', [App\Http\Controllers\Client\InterviewController::class, 'reactjsInterview']);
Route::get('/interviews/restapi-interview-question-answer', [App\Http\Controllers\Client\InterviewController::class, 'restapiInterview']);



Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register']);

//businees
Route::get('/business-owners', [App\Http\Controllers\Client\BusinessOwnerController::class, 'index'])->name('login');
Route::post('/business-owners', [App\Http\Controllers\Client\BusinessOwnerController::class, 'store'])->name('business-owners.submit');

//Route::get('/sitemap.xml', [App\Http\Controllers\SitemapsController::class, 'index']);
//Route::get('/sitemap-city.xml', [App\Http\Controllers\SitemapsController::class, 'city']);
//Route::get('/sitemap-blog.xml', [App\Http\Controllers\SitemapsController::class, 'blog']);

//Route::get('/sitemap-online.xml',[App\Http\Controllers\SitemapsController::class, 'online']);

// Route::get('/sitemap-keyword.xml',[App\Http\Controllers\SitemapsController::class, 'keyword']);

//Route::get('/sitemap-allcity.xml',[App\Http\Controllers\SitemapsController::class, 'allcity']);



Route::get('/sitemap-blog.xml', function () {

	$blogs = DB::table('blogdetails')
			->select('title', 'slug', 'updated_at')
			->get();
	return response()
		->view('client.sitemap_blog', compact('blogs'))
		->header('Content-Type', 'text/xml');

});

 Route::get('/sitemap-raipur', function () {
     	$keywords =  DB::table('keyword')
			->where('seo_type', '1')
			->select('slug', 'updated_at')
			->get();
	return response()
        ->view('client.sitemap-common', [
            'city' => 'raipur',
            'keywords' => $keywords
        ])
        ->header('Content-Type', 'application/xml; charset=UTF-8');
});

Route::get('/sitemap.xml', function () {

	 
		$keywords =  DB::table('keyword')
			->where('seo_type', '1')
			->select('slug', 'updated_at')
			->get();
	 

 
		$categories =  DB::table('parent_category')
			->where('status', '1')
			->select('parent_slug', 'updated_at')
			->get();
 
	 
		$childCategories =  DB::table('child_category')
			->where('status', '1')
			->select('child_slug', 'updated_at')
			->get();
	 

	return response()
		->view('client.sitemap', compact('keywords','categories','childCategories'))
	->header('Content-Type', 'application/xml; charset=UTF-8');

});

Route::get('/sitemap', function () {

	 
		$keywords =  DB::table('keyword')
			->where('seo_type', '1')
			->select('slug', 'updated_at')
			->get();
	  
		$categories =  DB::table('parent_category')
			->where('status', '1')
			->select('parent_slug', 'updated_at')
			->get();
	 	 
		$childCategories =  DB::table('child_category')
			->where('status', '1')
			->select('child_slug', 'updated_at')
			->get();
	 
	return response()
		->view('client.sitemap', compact('keywords','categories','childCategories'))
		->header('Content-Type', 'application/xml; charset=UTF-8');

});

Route::get('/sitemap-online.xml', function () {

 
		$keywords =  DB::table('keyword')
			->where('seo_type', '1')
			->select('slug', 'updated_at')
			->get();
	 

	return response()
		->view('client.sitemap_online', compact('keywords'))
		->header('Content-Type', 'text/xml');

});

Route::get('/sitemap-city.xml', function () {

	 
		$keywords =  DB::table('keyword')
			->where('seo_type', '1')
			->select('slug', 'updated_at')
			->get();
 

	return response()
		->view('client.sitemap_city', compact('keywords'))
		->header('Content-Type', 'text/xml');

});

Route::get('/sitemap-city-1.xml', function () {

	 
		$keywords =  DB::table('keyword')
			->where('seo_type', '1')
			->select('slug', 'updated_at')
			->get();
	 

 
		
		 return response()
        ->view('client.sitemap_city_1', compact('keywords'))
        ->header('Content-Type', 'application/xml; charset=UTF-8');

});

Route::get('/sitemap-city-2.xml', function () {

	$keywords = DB::table('keyword')
		->where('seo_type', '1')
		->select('slug', 'updated_at')
		->get();
	return response()
		->view('client.sitemap_city-2', compact('keywords'))
		->header('Content-Type', 'text/xml');

});

Route::get('/sitemap-city-3.xml', function () {

	$keywords = DB::table('keyword')
		->where('seo_type', '1')
		->select('slug', 'updated_at')
		->get();
	return response()
		->view('client.sitemap_city-3', compact('keywords'))
		->header('Content-Type', 'text/xml');

});
Route::get('/sitemap-city-4.xml', function () {

	$keywords = DB::table('keyword')
		->where('seo_type', '1')
		->select('slug', 'updated_at')
		->get();
	return response()
		->view('client.sitemap_city-4', compact('keywords'))
		->header('Content-Type', 'text/xml');

});

Route::get('/quickdialssitemap.xml', function () {
	return response()->view('client.quickdialssitemap')->header('Content-Type', 'text/xml');
});

Route::get('/quickdialssitemap', function () {
	return response()->view('client.quickdialssitemap')->header('Content-Type', 'text/xml');
});







//Route::get('/ads/study-abroad', [App\Http\Controllers\Client\LandingPageController::class, 'studyabroad']);
Route::post('/apiddd/lead/add', [App\Http\Controllers\Client\HomePageController::class, 'addLadsss']);


// Route::get('/coaching/distance-education',[App\Http\Controllers\Client\LandingPageController::class, 'distance_education']);
// Route::get('/coaching/foreign-language',[App\Http\Controllers\Client\LandingPageController::class, 'foreign_language']);
// Route::get('/coaching/multimedia',[App\Http\Controllers\Client\LandingPageController::class, 'multimedia']);
// Route::get('/coaching/it-training',[App\Http\Controllers\Client\LandingPageController::class, 'it_training']);
// Route::get('/coaching/iit-entrance-exam',[App\Http\Controllers\Client\LandingPageController::class, 'iit_entrance_exam']);
//Route::get('/coaching/entrance-exam-coaching', [App\Http\Controllers\Client\LandingPageController::class, 'entrance_exam_coaching']);
 // Route::get('/coaching/thank',[App\Http\Controllers\Client\LandingPageController::class, 'thankyou']);

//Route::get('/ads/entrance-exam-coaching', [App\Http\Controllers\Client\LandingPageController::class, 'entranceexamcoaching']);
// Route::get('/ads/distance-education',[App\Http\Controllers\Client\LandingPageController::class, 'distanceeducation']);
//Route::get('/ads/it-training', [App\Http\Controllers\Client\LandingPageController::class, 'ittraining']);
// Route::get('/free-course/landing',[App\Http\Controllers\Client\LandingPageController::class, 'index']);

//Route::get('/email', [App\Http\Controllers\EmailController::class, 'index']);

Route::get('/about-us', [App\Http\Controllers\Official\OfficialController::class, 'about'])->name('about.us');
//Route::get('/news', [App\Http\Controllers\Official\OfficialController::class, 'news']);
Route::get('/rss', [App\Http\Controllers\Official\OfficialController::class, 'rss']);
Route::get('/features', [App\Http\Controllers\Official\OfficialController::class, 'features']);
Route::get('/faq', [App\Http\Controllers\Official\OfficialController::class, 'faq']);
Route::get('/contact-us', [App\Http\Controllers\Official\OfficialController::class, 'contact'])->name('contact.us');
Route::get('/careers', [App\Http\Controllers\Official\OfficialController::class, 'careers'])->name('careers');
//Route::post('/api/careers/apply', [App\Http\Controllers\Official\OfficialController::class, 'apply'])->name('careers.apply');
Route::get('/pricing', [App\Http\Controllers\Official\OfficialController::class, 'pricing'])->name('pricing');
Route::get('/media', [App\Http\Controllers\Official\OfficialController::class, 'media']);
Route::get('/advertise', [App\Http\Controllers\Official\OfficialController::class, 'advertise']);
Route::get('/blog', [App\Http\Controllers\Official\OfficialController::class, 'blog'])->name('blog.show');
//Route::get('/official/blog-details', [App\Http\Controllers\Official\OfficialController::class, 'blogdetails']);
Route::get('/blog/{slug}', [App\Http\Controllers\Official\OfficialController::class, 'blogdetails'])->name('blog.details');
Route::get('/subscribe', [App\Http\Controllers\Official\OfficialController::class, 'subscribe']);
Route::get('/testimonials', [App\Http\Controllers\Official\OfficialController::class, 'testimonials']);
Route::get('/terms-conditions', [App\Http\Controllers\Official\OfficialController::class, 'termsconditions'])->name('terms.conditions');
Route::get('/privacy-policy', [App\Http\Controllers\Official\OfficialController::class, 'privacypolicy'])->name('privacy.policy');
Route::get('/copyright-policy', [App\Http\Controllers\Official\OfficialController::class, 'copyrightpolicy'])->name('copyright.policy');
Route::get('/refund-policy', [App\Http\Controllers\Official\OfficialController::class, 'refundPolicy'])->name('refund.policy');



Route::get('/', [App\Http\Controllers\Client\HomePageController::class, 'index'])->name('home');
 
Route::post('/newsletter', [App\Http\Controllers\Client\HomePageController::class, 'newsletter']);

// Route::get('/{html}.html', [App\Http\Controllers\Client\HomePageController::class, 'callsssHtml']);
Route::get('/business-services', [App\Http\Controllers\Client\HomePageController::class, 'businessServices'])->name('business.services');
Route::get('/getKWList', [App\Http\Controllers\Client\HomePageController::class, 'getKWList']);
Route::get('/getCityKWList', [App\Http\Controllers\Client\HomePageController::class, 'getCityKWList']);
Route::get('/getCityList', [App\Http\Controllers\Client\HomePageController::class, 'getCountryCode']);

Route::get('/disclaimer', function () {
	return view('client.disclaimer');
});



Route::post('/kw/search', [App\Http\Controllers\Client\HomePageController::class, 'searchKW']);
Route::get('/courses/playwright-automation-training-in-noida', [App\Http\Controllers\Client\HomePageController::class, 'playwrightAutomation']);


Route::get('/wedding-pannel', [App\Http\Controllers\Client\HomePageController::class, 'weddingPannel'])->name('wedding.pannel');





/*login otp mobile */
Route::get('/client-login', [App\Http\Controllers\ClientAuth\AuthController::class, 'clientLogin']);
Route::post('/client-login', [App\Http\Controllers\ClientAuth\AuthController::class, 'clientLoginPost'])->name('client.login');

Route::post('auth/send-otp', [App\Http\Controllers\ClientAuth\AuthController::class, 'sendOtp']);
Route::post('/client-verify-otp', [App\Http\Controllers\ClientAuth\AuthController::class, 'clientVerifyOtp']);

Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF cookie set']);
})->middleware('web'); // 'web' middleware sets cookies



Route::get('/business-details/{slug}', [App\Http\Controllers\Client\ClientDetailController::class, 'index'])->name('business.details');

Route::post('/review', [App\Http\Controllers\Client\ReviewController::class, 'store']);
Route::get('/client/logout', [App\Http\Controllers\LogoutController::class, 'clientLogout']);



Route::get('/categories', [HomePageController::class, 'category'])->name('category.list');
Route::get('/child', [HomePageController::class, 'child'])->name('child.list');
Route::get('/categories/{slug}', [HomePageController::class, 'categories'])->name('categories.show');
Route::get('/child/{slug}', [HomePageController::class, 'childSlus'])->name('child.show');

Route::get('/get-zones/{city_id}', [HomePageController::class, 'getZones'])->name('zones.get');


// // City home
// Route::get('/{city}', [HomePageController::class, 'showCityOrService'])
//     ->name('showCity')
//     ->where(['city' => '[a-z0-9][a-z0-9\-]*']);

// City home
Route::get('/{city}', [CitySlugController::class, 'showCityOrService'])
    ->name('showCity')
    ->where(['city' => '[a-z0-9][a-z0-9\-]*']);

// Route::get('/{city_slug}/{service_slug}', [SearchListController::class, 'showCityWithService'])->name('listing.show');
    // ->where([
    //     'city_slug' => '[a-z0-9\-]+',
    //     'service_slug'  => '[a-z0-9\-]+',
    // ]);
 

Route::get('/{city_slug}/{service_slug}', [CitySlugController::class, 'showCityWithService'])
    ->where('city_slug', '[a-z0-9\-]+')
    ->where('service_slug', '[a-z0-9\-]+')
    ->name('city.slug');



Route::POST('/client/lead/add-lead/', [App\Http\Controllers\Client\HomePageController::class, 'store']);
Route::POST('/client/lead/saveTwoEnquiry', [App\Http\Controllers\Client\HomePageController::class, 'saveTwoEnquiry']);
Route::POST('/client/lead/saveEnquiry', [App\Http\Controllers\Client\HomePageController::class, 'saveEnquiryWithoutZone']);
Route::POST('/form/validate-step', [App\Http\Controllers\Client\HomePageController::class, 'validateStep'])->name('form.validate.step');

Route::POST('/client/lead/saveEnquiryContact', [App\Http\Controllers\Client\HomePageController::class, 'saveEnquiryContact']);


Route::POST('/lead/auto-form-save', [App\Http\Controllers\Client\HomePageController::class, 'autoFormSave']);
Route::POST('/{city}/lead/auto-form-save', [App\Http\Controllers\Client\HomePageController::class, 'autoFormSave']);






// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
