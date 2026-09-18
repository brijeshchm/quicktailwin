<?php

// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
 
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Client\HomePageController;
use App\Http\Controllers\Client\SearchListController;
use App\Http\Controllers\Client\CitySlugController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ServiceController;
use App\Http\Controllers\User\VouchersController;
use App\Http\Controllers\User\RewardController;
  
Route::middleware('auth:guest')->group(function () {
		Route::get('dashboard',       [ProfileController::class, 'dashbord'])->name('user.show.dashbord');
		Route::get('user/personal-details',       [ProfileController::class, 'edit'])->name('user.personal.details');
		Route::post('user/profile/update',     [ProfileController::class, 'autosave'])->name('user.profile.autosave');          
		Route::get('user/service',          [ServiceController::class, 'service'])->name('user.service.index');         
		Route::get('user/vouchers',         [VouchersController::class, 'vouchers'])->name('user.vouchers.index');
		Route::get('user/rewards',         [RewardController::class, 'index'])->name('user.rewards.index');
		Route::post('/rewards/redeem',                      [RewardController::class, 'redeem'])->name('user.rewards.redeem');
    	
		Route::post('/rewards/redemptions/{redemption}/confirm', [RewardController::class, 'confirmRedemption'])->name('user.rewards.confirm');

		Route::get('user/admin-dashboard',         [VouchersController::class, 'adminDashboard'])->name('user.admindashboard.index');	
		

		Route::post('user/autosave-avatar', [ProfileController::class, 'autosaveAvatar'])->name('user.profile.autosave-avatar');
        
        Route::post('user/profile/send-otp',  [ProfileController::class, 'sendOtp'])->name('user.userprofile.send-otp');
        Route::post('user/profile/verify-otp',[ProfileController::class, 'verifyOtp'])->name('user.profile.verify-otp');

		Route::get('/vouchers/my',       [VouchersController::class, 'myVouchers'])->name('user.vouchers.my');
		Route::post('vouchers/claim',   [VouchersController::class, 'claim'])->name('user.vouchers.claim');
		Route::post('vouchers/continue',[VouchersController::class, 'continue'])->name('user.vouchers.continue');
		
		Route::get('/user/logout',       [ProfileController::class, 'userLogout'])->name('user.userLogout');

});

// Language switcher
Route::post('/language/change', function (\Illuminate\Http\Request $request) {
    $locale = $request->input('locale', 'en');
    if (in_array($locale, ['en', 'hi', 'es'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('language.change');


 Route::get('/cache-clear/', function () {

	$exitCode = Artisan::call('config:clear');
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('cache:clear');
	//$exitCode = Artisan::call('route:cache');
	Artisan::call('optimize:clear');
	// $exitCode = Artisan::call('optimize');
	return '<h1>Cache cleared</h1>';
});



use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Business\EnquiryController;

Route::get('/client/dashboard', [App\Http\Controllers\ClientAuth\AuthController::class, 'clientDashboard'])->name('client.dashboard');
Route::get('/user/dashboard', [App\Http\Controllers\ClientAuth\AuthController::class, 'userDashboard'])->name('user.dashboard');

























use App\Http\Controllers\Business\DashboardController;

Route::middleware('auth:clients')->group(function () {

// Auth::routes();

Route::controller(DashboardController::class)->group(function(){
	
 
 
 Route::get('/business/leads/{tab?}','leads')->name('leads');

//   Route::patch('/leads/{id}','updateLead')->name('leads.update');
 Route::post('/business/leads/{lead}/follow-ups','addFollowUp')->name('followups.add'); 
 Route::patch('/business/follow-ups/{id}','updateFollowUp')->name('followups.update'); 
 Route::delete('/business/follow-ups/{id}','deleteFollowUp')->name('followups.delete');
 Route::get('/business/leads/{leadId}/follow-ups/list', 'followUpsList')->name('leads.followups.list');
 Route::get('/business/follow-ups','followUps')->name('followups');
 Route::get('/business/listings','listings')->name('listings'); 
 Route::post('/business/listings','addListing')->name('listings.add'); 
 Route::patch('/business/listings/{id}','updateListing')->name('listings.update');
 Route::delete('/business/listings/{id}','deleteListing')->name('listings.delete');
 Route::get('/business/reviews','reviews')->name('reviews');
 Route::get('/business/pending-profile','pendingProfile')->name('pending-profile');
  
 Route::post('/business/reviews/{id}/reply','replyReview')->name('reviews.reply');
 Route::get('/business/team','team')->name('team'); Route::post('/team','addMember')->name('team.add'); 
 Route::patch('/business/team/{id}','updateMember')->name('team.update');
 Route::delete('/business/team/{id}','deleteMember')->name('team.delete');
 
 Route::get('/business/profile/{tab?}','profile')->name('profile'); 
 
 Route::patch('/business/profile','updateProfile')->name('profile.update');
 
Route::delete('/business/profile/gallery/{id}','deleteGallery')->name('profile.gallery.delete');
Route::post('/profile/awards/add','addAward')->name('profile.awards.add');
Route::delete('/business/profile/awards/{id}','deleteAward')->name('profile.awards.delete'); 
Route::patch('/business/profile/certificates','updateCertificates')->name('profile.certificates.update');
Route::get('/business/account/{tab?}','account')->name('account');
Route::patch('/business/account','updateAccount')->name('account.update');
Route::post('/business/account/buy-package','buyPackage')->name('account.buy');
Route::get('/business/invoices/{id}/download','invoice')->name('invoice.download');
Route::get('/business/contact','contact')->name('contact');
Route::post('/business/reset-demo','reset')->name('demo.reset');
Route::post('/business/sign-out','signOut')->name('signout');
});

	
	Route::get('/business/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
	// Route::get('/business/leads', [EnquiryController::class, 'getLeads']);
	Route::get('/business/enquiry', [EnquiryController::class, 'enquiry']);
	Route::get('/business/lead-follow-up', [EnquiryController::class, 'leadFollowUp']);
	//Route::get('/business/new-enquiry', [DashboardController::class, 'newEnquiry'])->name('new.enquiry');
	Route::get('/business/myLead', [EnquiryController::class, 'myLead']);
	Route::get('/business/favorite-enquiry', [EnquiryController::class, 'favoriteEnquiry']);
	Route::get('/business/manage-enquiry', [EnquiryController::class, 'manageEnquiry']);
	Route::get('/business-owners/get-Discussion', [App\Http\Controllers\Business\BusinessDiscussionController::class, 'getDiscussion']);
	Route::get('/business-owners/get-paginated-assigned-keywords', [App\Http\Controllers\Business\BusinessKeywordController::class, 'getPaginatedAssignedKeywords']);

	 
	Route::post('/business-owners/export-excel', [App\Http\Controllers\Business\EnquiryController::class, 'getLeadsExcel']);

	 
	//Route::get('/business/personal-details', [App\Http\Controllers\Business\PersonalDetailsController::class, 'personalDetails']);
	Route::get('/business/profileInfo', [App\Http\Controllers\Business\ProfileController::class, 'profileInfo']);
	Route::post('/business/saveProfileInfo', [App\Http\Controllers\Business\ProfileController::class, 'saveProfileInfo'])->name('business.profile.info');
	Route::post('/business/saveBusinessLocation', [App\Http\Controllers\Business\ProfileController::class, 'saveBusinessLocation'])->name('profile.locations.add');
	Route::delete('/business/assignZoneDelete/{id}', [App\Http\Controllers\Business\ProfileController::class, 'assignZoneDelete'])->name('profile.locations.delete');


	Route::get('/business/business-social', [App\Http\Controllers\Business\ProfileController::class, 'getBusinessSocial']);

	Route::post('/business/editSaveSocials', [App\Http\Controllers\Business\ProfileController::class, 'saveBusinessSocial'])->name('profile.socials.save');



	Route::get('/business/business-certificate', [App\Http\Controllers\Business\CertificateController::class, 'getBusinessCertificate']);

	Route::post('/business/editSaveCertificate/{id}', [App\Http\Controllers\Business\CertificateController::class, 'saveBusinessCertificate']);
	Route::post('/business/save-certificate-auto', [App\Http\Controllers\Business\CertificateController::class, 'autoSaveCertificate']);

	


	Route::get('/business/certificate/{slug}/{id}', [App\Http\Controllers\Business\CertificateController::class, 'certificateDel']);

	Route::post('/business/save-award-auto', [App\Http\Controllers\Business\CertificateController::class, 'saveBusinessAward']);
	Route::get('/business/award/{slug}/{id}', [App\Http\Controllers\Business\CertificateController::class, 'awardDel']);
	Route::get('/business/business-award', [App\Http\Controllers\Business\CertificateController::class, 'getBusinessAward']);
	
	Route::post('/business/save-recent-activity-auto', [App\Http\Controllers\Business\CertificateController::class, 'saveBusinessRecentActivity'])->name('recent.activity.save');
	Route::delete('/business/recent/{slug}/{id}', [App\Http\Controllers\Business\CertificateController::class, 'recentActivityDel']);
	Route::get('/business/recent-activity', [App\Http\Controllers\Business\CertificateController::class, 'getBusinessRecentActivity']);
	


	Route::post('/business/savePersonalDetails', [App\Http\Controllers\Business\PersonalDetailsController::class, 'savePersonalDetails'])->name('business.profile.update');

	Route::get('/business/profile-logo', [App\Http\Controllers\Business\BusinessLogoController::class, 'profileLogo']);
	Route::post('/business/saveProfileLogo', [App\Http\Controllers\Business\BusinessLogoController::class, 'saveProfileLogo'])->name('profile.logo.upload');
	Route::get('/business/profileLogo/logoDel/{id}', [App\Http\Controllers\Business\BusinessLogoController::class, 'logoDel'])->name('profile.logo.delete');
	Route::get('/business/profileLogo/profilePicDel/{id}', [App\Http\Controllers\Business\BusinessLogoController::class, 'profilePicDel'])->name('profile.banner.remove');

	Route::get('/business/gallery-pictures', [App\Http\Controllers\Business\BusinessLogoController::class, 'uploadPictures']);

	Route::post('/business/saveGallary', [App\Http\Controllers\Business\BusinessLogoController::class, 'saveGallary'])->name('profile.gallery.upload');


	Route::get('/business/location-information', [App\Http\Controllers\Business\BusinessLocationController::class, 'locationInformation']);
	Route::post('/business/saveLocationInformation', [App\Http\Controllers\Business\BusinessLocationController::class, 'saveLocationInformation']);

	//review
	Route::get('/business/get-business-review', [App\Http\Controllers\Business\ReviewController::class, 'getBusinessReviewPagination']);
	Route::get('/business/review/delete/{id}', [App\Http\Controllers\Business\ReviewController::class, 'reviewDelete']);
	Route::get('/business/business-review', [App\Http\Controllers\Business\ReviewController::class, 'businessReview']);
	Route::get('/business/review/editReview/{id}', [App\Http\Controllers\Business\ReviewController::class, 'getReviewEdit']);
	Route::post('/business/review/update-review/{id}', [App\Http\Controllers\Business\ReviewController::class, 'updateReviewEdit']);


	Route::post('/business/pauseLead', [App\Http\Controllers\Business\EnquiryController::class, 'pauseLead'])->name('pause.lead');
	Route::post('/business/scrapLead', [App\Http\Controllers\Business\EnquiryController::class, 'scrapLead']);
	Route::post('/business/readLead', [App\Http\Controllers\Business\EnquiryController::class, 'readLead']);
	Route::post('/business/favoritleads', [App\Http\Controllers\Business\EnquiryController::class, 'favoritleads']);

	Route::post('/business/cities/getajaxcities', [App\Http\Controllers\Client\BusinessController::class, 'getAjaxCities'])->name('business.cities.ajax');
	Route::post('/business/state/getAjaxSate', [App\Http\Controllers\Client\BusinessController::class, 'getAjaxSate']);
	Route::post('/business/zone/getAjaxZone', [App\Http\Controllers\Client\BusinessController::class, 'getAjaxZone'])->name('business.zone.ajax');
	Route::get('/business/get-assigned-zones', [App\Http\Controllers\Client\BusinessController::class, 'getAssignedZonesPagination']);

	Route::get('/business/assignZone/delete/{id}', [App\Http\Controllers\Client\BusinessController::class, 'assignZoneDelete']);

	Route::post('/business/assignLocation/selectAssignZoneDelete', [App\Http\Controllers\Client\BusinessController::class, 'selectAssignZoneDelete']);


	Route::get('/business/package', [App\Http\Controllers\Business\AccountController::class, 'package'])->name('business.package');
	Route::get('/business/account-settings', [App\Http\Controllers\Business\AccountController::class, 'accountSettings']);
	Route::get('/business/business-location', [App\Http\Controllers\Business\BusinessLocationController::class, 'businessLocation']);
	
	Route::get('/business/business-overview', [App\Http\Controllers\Business\BusinessController::class, 'businessOverview']);
	Route::post('/business/saveBusinessOverview/{id}', [App\Http\Controllers\Business\BusinessController::class, 'saveBusinessOverview']);

	Route::get('/business/business-meta', [App\Http\Controllers\Business\BusinessController::class, 'businessMeta']);
	Route::post('/business/saveBusinessMeta', [App\Http\Controllers\Business\BusinessController::class, 'saveBusinessMeta'])->name('updateBusiness.meta');

	Route::get('/business/buy-package', [App\Http\Controllers\Business\AccountController::class, 'buyPackage']);

	Route::get('/business/billing-history', [App\Http\Controllers\Business\InvoiceController::class, 'billingHistory']);

	Route::get('/business/get-billing-history', [App\Http\Controllers\Business\InvoiceController::class, 'getBillingHistory']);


	Route::get('/business/rewards-dashboard', [App\Http\Controllers\Business\RewardsController::class, 'getBusinessRewardsDashboard']);
	Route::get('/business/rewards-pending', [App\Http\Controllers\Business\RewardsController::class, 'getBusinessRewardsPending']);
	Route::get('/business/rewards-completed', [App\Http\Controllers\Business\RewardsController::class, 'getBusinessRewardsCompleted']);
	Route::get('/business/rewards-history', [App\Http\Controllers\Business\RewardsController::class, 'getBusinessRewardsHistory']);
 
 
    Route::post('business/enquiries/{enquiry}/accept', [App\Http\Controllers\Business\RewardsController::class, 'acceptEnquiry'])
        ->name('enquiries.accept');
 
    Route::post('business/enquiries/{enquiry}/complete', [App\Http\Controllers\Business\RewardsController::class, 'completeEnquiry'])
        ->name('enquiries.complete');
 
    Route::post('business/redemptions/{redemption}/complete', [App\Http\Controllers\Business\RewardsController::class, 'completeRedemption'])
        ->name('redemptions.complete');

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
	Route::get('/business/faqs', [App\Http\Controllers\Business\BusinessController::class, 'businessFaqs']);
	Route::post('/business/saveBusinessFaqs', [App\Http\Controllers\Business\BusinessController::class, 'saveBusinessFaqs'])->name('business.faqs.save');


	Route::post('/business/saveKeywordAssign', [App\Http\Controllers\Business\BusinessKeywordController::class, 'saveKeywordAssign'])->name('profile.keywords.add');
	Route::post('/business/assignKeyword/delete/{id}', [App\Http\Controllers\Business\BusinessKeywordController::class, 'assignKeywordDelete'])->name('profile.keywords.delete');
	Route::get('/business/get-paginated-assigned-keywords', [App\Http\Controllers\Business\BusinessKeywordController::class, 'getPaginatedAssignedKeywords']);


	Route::get('/business/coins-history', [App\Http\Controllers\Business\InvoiceController::class, 'coinsHistory']);



	/* Change Password - CLIENT */
	Route::get('/business-owners/changepassword', [App\Http\Controllers\Client\ChangePasswordController::class, 'create']);
	Route::post('/business-owners/changepassword', [App\Http\Controllers\Client\ChangePasswordController::class, 'store']);
	/* Change Password - CLIENT */

	/* Change Password - CLIENT */
	Route::get('/business/pay-deposit', [App\Http\Controllers\Business\RazorpayController::class, 'payDeposit'])->name('business.pay-deposit');
	Route::get('/business/subscribe-free', [App\Http\Controllers\Business\RazorpayController::class, 'subscribeFree']);
	Route::post('/business/saveSubscribeFree/{id}', [App\Http\Controllers\Business\RazorpayController::class, 'saveSubscribeFree']);
	Route::post('/business/razorPayCheckout', [App\Http\Controllers\Business\RazorpayController::class, 'razorPayCheckout'])->name('business.razorpay.checkout');
	Route::post('/business/save-processing', [App\Http\Controllers\Business\RazorpayController::class, 'saveProcessing']);
	Route::get('/business/success', [DashboardController::class, 'success'])->name('pay.success');
	Route::get('/business/failed', [DashboardController::class, 'failed'])->name('pay.failed');



	/* Reset Password - CLIENT */
	Route::get('/resetp', [App\Http\Controllers\Client\ChangePasswordController::class, 'forgotPassword']);
	/* Reset Password - CLIENT */
});


/*login otp mobile */
//Route::get('/client-login', [App\Http\Controllers\ClientAuth\AuthController::class, 'clientLogin'])->name('clientAuth.Login');

 

Route::get('/google-login', [App\Http\Controllers\ClientAuth\AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [App\Http\Controllers\ClientAuth\AuthController::class, 'handleGoogleCallback']);



Route::post('/developer/login', [App\Http\Controllers\Auth\AuthController::class, 'authenticate']);
Route::get('/developer/login', [App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('developer.login');
Route::get('/developer/check/login',[App\Http\Controllers\Auth\AuthController::class, 'checklogin']);
Route::post('/developer/check/login',[App\Http\Controllers\Auth\AuthController::class, 'authenticate']);
//Route::get('/login/otp',function(){return view('auth.otp');});
Route::get('/developer/login/otp',[App\Http\Controllers\Auth\AuthController::class,'getOTP']);
Route::post('/developer/login/otp',[App\Http\Controllers\Auth\AuthController::class,'authenticate']);




Route::post('/sales/login', [App\Http\Controllers\Auth\AuthSalesController::class, 'authenticate']);
Route::get('/sales/login', [App\Http\Controllers\Auth\AuthSalesController::class, 'showLoginForm'])->name('developer.login');
Route::get('/sales/check/login',[App\Http\Controllers\Auth\AuthSalesController::class, 'checklogin']);
Route::post('/sales/check/login',[App\Http\Controllers\Auth\AuthSalesController::class, 'authenticate']);
//Route::get('/login/otp',function(){return view('auth.otp');});
Route::get('/sales/login/otp',[App\Http\Controllers\Auth\AuthSalesController::class,'getOTP']);
Route::post('/sales/login/otp',[App\Http\Controllers\Auth\AuthSalesController::class,'authenticate']);








Route::get('/cities/getajaxcities', [App\Http\Controllers\CitiesController::class, 'getAjaxCities']);
Route::get('/location/getAjaxLocation', [App\Http\Controllers\CitiesController::class, 'getAjaxLocation']);
Route::get('/location/getAjaxService', [App\Http\Controllers\CitiesController::class, 'getAjaxService']);

Route::prefix('developer')->name('developer.')->middleware(['auth:developer'])->as('developer.')->group(function () {
	require __DIR__ . '/developer.php';
});


Route::prefix('sales')->name('sales.')->middleware(['auth:sales'])->group(function () {
	require __DIR__ . '/sales.php';
});


Route::get('/interviews', [App\Http\Controllers\Client\InterviewController::class, 'index'])->name('interviews');
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
 


Route::get('/sitemap-blog.xml', function () {

	$blogs = DB::table('blogdetails')
			->select('title', 'slug', 'updated_at')
			->get();
	return response()
		->view('client.sitemap_blog', compact('blogs'))
		->header('Content-Type', 'application/xml; charset=UTF-8');

});
 

Route::get('/llms.txt', function () {
    return response()
        ->view('client.llms', [], 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('llms');


// Route::get('/sitemap.xml', function () {
 
// 		$keywords =  DB::table('keyword')
// 			->where('seo_type', '1')
// 			->select('slug', 'updated_at')
// 			->get();
	 
// 		$categories =  DB::table('parent_category')
// 			->where('status', '1')
// 			->select('parent_slug', 'updated_at')
// 			->get();
 
	 
// 		$childCategories =  DB::table('child_category')
// 			->where('status', '1')
// 			->select('child_slug', 'updated_at')
// 			->get();
	 

// 	return response()
// 		->view('client.sitemap', compact('keywords','categories','childCategories'))
// 	 ->header('Content-Type', 'application/xml; charset=UTF-8');

// });
 
Route::get('/top-city.xml', function () {
	 
	return response()
        ->view('client.top_city')
        ->header('Content-Type', 'application/xml; charset=UTF-8');
});

// Route::get('/sitemap-online.xml', function () { 
// 	$keywords =  DB::table('keyword')
// 			->where('seo_type', '1')
// 			->select('slug', 'updated_at')
// 			->get(); 

// 	return response()
// 		->view('client.sitemap_online', compact('keywords'))
// 		->header('Content-Type', 'application/xml; charset=UTF-8');

// });

// Route::get('/sitemap-city.xml', function () {

	 
// 		$keywords =  DB::table('keyword')
// 			->where('seo_type', '1')
// 			->select('slug', 'updated_at')
// 			->get();
 

// 	return response()
// 		->view('client.sitemap_city', compact('keywords'))
// 		->header('Content-Type', 'application/xml; charset=UTF-8');

// });

// Route::get('/sitemap-city-1.xml', function () {

	 
// 		$keywords =  DB::table('keyword')
// 			->where('seo_type', '1')
// 			->select('slug', 'updated_at')
// 			->get();
// 	 	 return response()
//         ->view('client.sitemap_city_1', compact('keywords'))
//         ->header('Content-Type', 'application/xml; charset=UTF-8');

// });

// Route::get('/sitemap-city-2.xml', function () {

// 	$keywords = DB::table('keyword')
// 		->where('seo_type', '1')
// 		->select('slug', 'updated_at')
// 		->get();
// 	return response()
// 		->view('client.sitemap_city-2', compact('keywords'))
// 		->header('Content-Type', 'application/xml; charset=UTF-8');

// });


// Route::get('/sitemap-businesses.xml', function () {

// 	$clients = DB::table('clients')
// 		->where('active_status', '1')
// 		->select('business_slug', 'updated_at')
// 		->get();
// 	return response()
// 		->view('client.sitemap-businesses', compact('clients'))
// 		->header('Content-Type', 'application/xml; charset=UTF-8');

// });

// Route::get('/sitemap-city-3.xml', function () {

// 	$keywords = DB::table('keyword')
// 		->where('seo_type', '1')
// 		->select('slug', 'updated_at')
// 		->get();
// 	return response()
// 		->view('client.sitemap_city-3', compact('keywords'))
// 		->header('Content-Type', 'application/xml; charset=UTF-8');

// });

// Route::get('/sitemap-city-4.xml', function () {

// 	$keywords = DB::table('keyword')
// 		->where('seo_type', '1')
// 		->select('slug', 'updated_at')
// 		->get();
// 	return response()
// 		->view('client.sitemap_city-4', compact('keywords'))
// 		->header('Content-Type', 'application/xml; charset=UTF-8');

// });

// Route::get('/quickdialssitemap.xml', function () {
// 	return response()->view('client.quickdialssitemap')
// 	->header('Content-Type', 'application/xml; charset=UTF-8');
// });
 
Route::post('/apiddd/lead/add', [App\Http\Controllers\Client\HomePageController::class, 'addLadsss']);

Route::get('/about-us', [App\Http\Controllers\Official\OfficialController::class, 'about'])->name('aboutUs');
 
Route::get('/rss', [App\Http\Controllers\Official\OfficialController::class, 'rss']);
Route::get('/features', [App\Http\Controllers\Official\OfficialController::class, 'features']);
Route::get('/faq', [App\Http\Controllers\Official\OfficialController::class, 'faq']);
Route::get('/contact-us', [App\Http\Controllers\Official\OfficialController::class, 'contact'])->name('contactUs');
Route::get('/careers', [App\Http\Controllers\Official\OfficialController::class, 'careers'])->name('careers');
//Route::post('/api/careers/apply', [App\Http\Controllers\Official\OfficialController::class, 'apply'])->name('careers.apply');
Route::get('/pricing', [App\Http\Controllers\Official\OfficialController::class, 'pricing'])->name('pricing');

Route::get('/advertise', [App\Http\Controllers\Official\OfficialController::class, 'advertise'])->name('advertise');
Route::get('/blog', [App\Http\Controllers\Official\OfficialController::class, 'blog'])->name('blog.show');
 
Route::get('/blog/{slug}', [App\Http\Controllers\Official\OfficialController::class, 'blogdetails'])->name('blog.details');
Route::get('/blog/category/{url}',[App\Http\Controllers\Official\OfficialController::class, 'blogCategory'])->name('category.blog');
Route::get('/subscribe', [App\Http\Controllers\Official\OfficialController::class, 'subscribe']);
 
Route::get('/terms-conditions', [App\Http\Controllers\Official\OfficialController::class, 'termsconditions'])->name('terms.conditions');
Route::get('/privacy-policy', [App\Http\Controllers\Official\OfficialController::class, 'privacypolicy'])->name('privacy.policy');
Route::get('/copyright-policy', [App\Http\Controllers\Official\OfficialController::class, 'copyrightpolicy'])->name('copyright.policy');
Route::get('/refund-policy', [App\Http\Controllers\Official\OfficialController::class, 'refundPolicy'])->name('refund.policy');

Route::get('/', [App\Http\Controllers\Client\HomePageController::class, 'index'])->name('home');
 
Route::post('/newsletter', [App\Http\Controllers\Client\HomePageController::class, 'newsletter']);
Route::get('/news', [App\Http\Controllers\Official\OfficialController::class, 'news'])->name('news.list');
Route::get('/news/{slug}', [App\Http\Controllers\Official\OfficialController::class, 'newsDetails'])->name('news.details');
Route::get('/news/category/{url}', [App\Http\Controllers\Official\OfficialController::class, 'newsCategory'])->name('news.category');


Route::get('/business-services', [App\Http\Controllers\Client\HomePageController::class, 'businessServices'])->name('business.services');
Route::get('/getKWList', [App\Http\Controllers\Client\HomePageController::class, 'getKWList']);
Route::get('/getCityKWList', [App\Http\Controllers\Client\HomePageController::class, 'getCityKWList']);
Route::get('/getCityList', [App\Http\Controllers\Client\HomePageController::class, 'getCountryCode']);

Route::get('/disclaimer', function () {
	return view('client.disclaimer');
});


Route::get('/courses/playwright-automation-training-in-noida', [App\Http\Controllers\Client\HomePageController::class, 'playwrightAutomation']);



Route::get('/wedding-planning', [App\Http\Controllers\Client\HomePageController::class, 'weddingPannel'])->name('wedding.planning');
//Route::get('/doctor-hub', [App\Http\Controllers\Client\DoctorController::class, 'doctorHub'])->name('doctor.hub');

Route::get('/doctor-details', [App\Http\Controllers\Client\DoctorController::class, 'clinicDetails'])->name('clinic.details');

Route::get('/spa-hub', [App\Http\Controllers\Client\HomePageController::class, 'spaHub'])->name('spa.hub');
Route::get('/saloon-hub', [App\Http\Controllers\Client\HomePageController::class, 'saloonHub'])->name('saloon.hub');

/*login otp mobile */
 
Route::post('/client-login', [App\Http\Controllers\ClientAuth\AuthController::class, 'clientLoginPost'])->name('client.login');

Route::post('auth/send-otp', [App\Http\Controllers\ClientAuth\AuthController::class, 'sendOtp']);
Route::post('/client-verify-otp', [App\Http\Controllers\ClientAuth\AuthController::class, 'clientVerifyOtp']);

Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF cookie set']);
})->middleware('web'); // 'web' middleware sets cookies



Route::get('/businessdetails/{slug}', [App\Http\Controllers\Client\ClientDetailController::class, 'index'])->name('business.details');
Route::get('/businessdetails', [App\Http\Controllers\Client\ClientDetailController::class, 'businessDetails'])->name('lists.business');

Route::post('/review', [App\Http\Controllers\Client\ReviewController::class, 'store']);
Route::get('/client/logout', [App\Http\Controllers\LogoutController::class, 'clientLogout']);



//Route::get('/categories', [HomePageController::class, 'category'])->name('category.list');
//Route::get('/child', [HomePageController::class, 'child'])->name('child.list');
//Route::get('/categories/{slug}', [HomePageController::class, 'categories'])->name('categories.show');
//Route::get('/child/{slug}', [HomePageController::class, 'childSlus'])->name('child.show');
Route::get('location/getAjaxCity', [HomePageController::class, 'getAjaxLocation'])->name('get.location');
Route::get('service/getAjaxKeyword', [HomePageController::class, 'getAjaxKeyword'])->name('search.keyword');

Route::get('/get-zones/{city_id}', [HomePageController::class, 'getZones'])->name('zones.get');
Route::get('payment/checkout', [App\Http\Controllers\Client\WebsiteRazorpayController::class, 'razCheckOut'])->name('raz.checkout');;
//?status=correction&encrypt=

Route::get('package', [App\Http\Controllers\Client\WebsiteRazorpayController::class, 'getPackage'])->name('package.list');;
//	


Route::post('razorPayCheckout', [App\Http\Controllers\Client\WebsiteRazorpayController::class, 'razorPayCheckout']);
Route::get('/payment-done', [App\Http\Controllers\Client\WebsiteRazorpayController::class, 'success']);
Route::get('/failed', [App\Http\Controllers\Client\WebsiteRazorpayController::class, 'failed']);
 
// Route::match(['GET', 'HEAD'], '/business-details/{slug}', function () {
//     abort(410, 'This business listing has been permanently removed.');
// })->where('slug', '.*');

// Route::get('search', [App\Http\Controllers\Client\CitySlugController::class, 'searchKW'])->name('kw.search');
Route::get('/{city}', [CitySlugController::class, 'showCityOrService'])
    ->name('showCity');
 

Route::get('/{city_slug}/{service_slug}', [CitySlugController::class, 'showCityWithService']) 
    ->name('city.slug');

Route::POST('/client/lead/add-lead/', [App\Http\Controllers\Client\HomePageController::class, 'store']);
Route::POST('/client/lead/saveTwoEnquiry', [App\Http\Controllers\Client\HomePageController::class, 'saveTwoEnquiry']);
Route::POST('/client/enquirySendOtp', [App\Http\Controllers\Client\HomePageController::class, 'enquirySendOtp']);
Route::POST('/client/lead/saveEnquiry', [App\Http\Controllers\Client\HomePageController::class, 'saveEnquiryWithoutZone']);
Route::POST('/form/validate-step', [App\Http\Controllers\Client\HomePageController::class, 'validateStep'])->name('form.validate.step');

Route::POST('/client/lead/saveEnquiryContact', [App\Http\Controllers\Client\HomePageController::class, 'saveEnquiryContact']);


Route::POST('/lead/auto-form-save', [App\Http\Controllers\Client\HomePageController::class, 'autoFormSave']);
//Route::POST('/{city}/lead/auto-form-save', [App\Http\Controllers\Client\HomePageController::class, 'autoFormSave']);

 


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';



