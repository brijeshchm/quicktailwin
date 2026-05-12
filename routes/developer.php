<?php
Route::get('/logout',[App\Http\Controllers\Auth\AuthController::class,'logout']);
Route::get('/dashboard',[App\Http\Controllers\DashboardController::class, 'index']);
Route::get('/dashboard/get-paid-client', [App\Http\Controllers\DashboardController::class, 'getPaidClients']);	

Route::get('/lead/updateremaining',[App\Http\Controllers\LeadController::class, 'updateremaining']);
/* Meetings */
	Route::get('/clients/meetings',[App\Http\Controllers\MeetingController::class, 'index'])->middleware('auth');
	Route::get('/clients/meeting/{client_id}',[App\Http\Controllers\MeetingController::class, 'getClientMeetingForm'])->middleware('auth');
	Route::post('/clients/storemeeting/{id}',[App\Http\Controllers\MeetingController::class, 'followUpStore'])->middleware('auth');
	Route::get('/clients/all-meetings/{client_id}',[App\Http\Controllers\MeetingController::class, 'viewAllMeetings'])->middleware('auth');
	Route::get('/clients/meeting/status/{meeting_id}',[App\Http\Controllers\MeetingController::class, 'changeMeetingStatus'])->middleware('auth');
	Route::get('/clients/meeting/getTeleCollerFollowups/{meeting_id}',[App\Http\Controllers\MeetingController::class, 'getTeleCollerFollowups'])->middleware('auth');
/* Meetings */

// *****************
// ROLES PERMISSIONS
	use App\Http\Controllers\RolesPermissionsController;
	Route::get('/permission',[RolesPermissionsController::class, 'permissionIndex'])->middleware('auth');
	Route::post('/permission',[RolesPermissionsController::class, 'permissionStore'])->middleware('auth');
	Route::get('/permission/getpermission',[RolesPermissionsController::class,'getPaginatedPermissions'])->middleware('auth');
	Route::get('/permission/update/{id}',[RolesPermissionsController::class, 'editPermission'])->middleware('auth');
	Route::post('/permission/update/{id}',[RolesPermissionsController::class, 'updatePermission'])->middleware('auth');
	Route::get('/permission/delete/{id}',[RolesPermissionsController::class, 'destroyPermission'])->middleware('auth');	
	Route::get('/role-permission',[RolesPermissionsController::class, 'rolePermissionIndex'])->middleware('auth');
	Route::post('/role-permission',[RolesPermissionsController::class, 'rolePermissionStore'])->middleware('auth');
	Route::get('/role-permission/getpermission',[RolesPermissionsController::class, 'getPaginatedRolesPermissions'])->middleware('auth');
	Route::get('/role-permission/update/{id}',[RolesPermissionsController::class, 'editRolePermission'])->middleware('auth');
	Route::post('/role-permission/update/{id}',[RolesPermissionsController::class, 'updateRolePermission'])->middleware('auth');
	Route::get('/role-permission/delete/{id}',[RolesPermissionsController::class, 'destroyRolePermission'])->middleware('auth');
	Route::get('/role-permission/{id}',[RolesPermissionsController::class, 'getRolePermissions'])->middleware('auth');	
	use App\Http\Controllers\RolesAndCapabilitiesController;
	Route::get('/roles-and-capabilities', [RolesAndCapabilitiesController::class, 'index'])->middleware('auth');
	Route::get('/roles-and-capabilities/update/{id}', [RolesAndCapabilitiesController::class, 'update'])->middleware('auth');
	Route::post('/roles-and-capabilities/update/{id}', [RolesAndCapabilitiesController::class, 'update'])->middleware('auth');
// ROLES PERMISSIONS
// *****************
Route::get('/cities/getajaxcities',[App\Http\Controllers\CitiesController::class, 'getAjaxCities']);
Route::post('/city/getAjaxCity',[App\Http\Controllers\CitiesController::class, 'getAjaxCity']);
Route::post('/zone/getAjaxZone',[App\Http\Controllers\CitiesController::class, 'getAjaxZone']);

Route::get('/kw/search/cc', [App\Http\Controllers\Client\HomePageController::class, 'searchKWcc']);

Route::get('/register',[App\Http\Controllers\userController::class, 'getRegister']);
Route::post('/saveRegister',[App\Http\Controllers\userController::class, 'postRegister']);
Route::get('/get-paid-client', [App\Http\Controllers\DashboardController::class, 'getPaidClients'])->middleware('auth:developer');
 
 Route::get('/lead-dashboard/',[App\Http\Controllers\LeadDashboardController::class, 'index'])->middleware('auth:developer');

Route::get('/lead-dashboard/counsellor/{id?}',[App\Http\Controllers\LeadDashboardController::class, 'leadDashboard'])->middleware('auth')->name('dashboard');
Route::get('/lead-dashboard/get-pending-leads-dashboard',[App\Http\Controllers\LeadDashboardController::class, 'getpendingLeadsDashboard'])->middleware('auth:developer');
Route::get('/lead-conversion/', [App\Http\Controllers\LeadDashboardController::class, 'leadconversion'])->middleware(middleware: 'auth');
Route::get('/lead-conversion/get-pending-leads-conversion',[App\Http\Controllers\LeadDashboardController::class, 'getpendingLeadConversion'])->middleware('auth:developer');

Route::post('/lead-dashboard/daily-calling-status/{id?}', [App\Http\Controllers\LeadDashboardController::class, 'getCallingStatus'])->middleware('auth');
Route::get('/list-users',[App\Http\Controllers\userController::class, 'getUsers']);
Route::get('/list-users/delete/{id}',[App\Http\Controllers\userController::class, 'deleteUser'])->middleware('auth');
Route::get('/update-user/{id}',[App\Http\Controllers\userController::class, 'updateUser'])->middleware('auth');
Route::post('/update-user/{id}',[App\Http\Controllers\userController::class, 'updateThisUser'])->middleware('auth');


/* Cities */
	Route::get('/cities', [App\Http\Controllers\CitiesController::class, 'index'])->middleware('auth');
	Route::post('/cities', [App\Http\Controllers\CitiesController::class, 'store'])->middleware('auth');
	Route::get('/cities/delete/{id}', [App\Http\Controllers\CitiesController::class, 'destroy'])->middleware('auth');
	Route::get('/cities/updatecity/{id}',[App\Http\Controllers\CitiesController::class, 'edit'])->middleware('auth');
	Route::post('/cities/update', [App\Http\Controllers\CitiesController::class, 'update'])->middleware('auth');
	Route::get('/cities/getcities', [App\Http\Controllers\CitiesController::class, 'getCitiesPagination'])->middleware('auth');
	
/* Cities */

/* Parent Category */
	Route::get('/parent_category',[App\Http\Controllers\ParentCategoryController::class, 'index'])->middleware('auth');
	Route::get('/get-parent-category',[App\Http\Controllers\ParentCategoryController::class, 'getParentCategoryPagination'])->middleware('auth');
	Route::post('/parent_category', [App\Http\Controllers\ParentCategoryController::class, 'store'])->middleware('auth');
	Route::get('/parent_category/delete/{id}', [App\Http\Controllers\ParentCategoryController::class, 'destroy'])->middleware('auth');
	Route::get('/parent_category/update_parent_category/{id}',[App\Http\Controllers\ParentCategoryController::class, 'edit'])->middleware('auth');
	Route::post('/parent_category/update', [App\Http\Controllers\ParentCategoryController::class, 'update'])->middleware('auth');	
	Route::get('/editCategory/{id}',[App\Http\Controllers\ParentCategoryController::class, 'editCategory'])->middleware('auth');
	Route::post('/editStoreCategory',[App\Http\Controllers\ParentCategoryController::class, 'editStoreCategory'])->middleware('auth');
	Route::get('/category/del_icon/{id}', [App\Http\Controllers\ParentCategoryController::class, 'imageDeleted'])->middleware('auth'); 
	Route::get('/category/status/{id}/{val}', [App\Http\Controllers\ParentCategoryController::class, 'status'])->middleware('auth:developer');
	Route::get('/category/del_banner/{id}', [App\Http\Controllers\ParentCategoryController::class, 'imageBannerDeleted'])->middleware('auth'); 
	
/* Parent Category */

/* Child Category */
	Route::get('/child_category',[App\Http\Controllers\ChildCategoryController::class, 'index'])->middleware('auth');
	Route::get('/get-child-category',[App\Http\Controllers\ChildCategoryController::class, 'getchildCategoryPagination'])->middleware('auth');
	Route::post('/child_category',[App\Http\Controllers\ChildCategoryController::class, 'store'])->middleware('auth');
	Route::post('/updateAboutChildCategory/{id}',[App\Http\Controllers\ChildCategoryController::class, 'updateAboutChildCategory'])->middleware('auth');
	 
	/* Child Category */
	Route::get('/editChildCategory/{id}',[App\Http\Controllers\ChildCategoryController::class, 'editChildCategory'])->middleware('auth');	
	Route::get('/childCategory/del_icon/{id}',[App\Http\Controllers\ChildCategoryController::class, 'imageDeleted'])->middleware('auth');
		Route::get('/childCategory/del_child_banner/{id}',[App\Http\Controllers\ChildCategoryController::class, 'bannerDeleted'])->middleware('auth');
	
	Route::post('/storeChildCategory', [App\Http\Controllers\ChildCategoryController::class, 'storeChildCategory'])->middleware('auth');	
	Route::get('/child_category/delete/{id}', [App\Http\Controllers\ChildCategoryController::class, 'destroy'])->middleware('auth');
	Route::get('/child_category/update_child_category/{id}',[App\Http\Controllers\ChildCategoryController::class, 'edit'])->middleware('auth');
	Route::post('/child_category/update', [App\Http\Controllers\ChildCategoryController::class, 'update'])->middleware('auth');
	Route::get('/child_category/status/{id}/{val}', [App\Http\Controllers\ChildCategoryController::class, 'status'])->middleware('auth:developer');
	/* Parent Category */

/* Keywords */
	Route::get('/keyword/getkwds',[App\Http\Controllers\KeywordController::class, 'getPaginatedKwds'])->middleware('auth');
	Route::post('/keyword/getkwdsexcel', [App\Http\Controllers\KeywordController::class, 'getKwdsExcel'])->middleware('auth');
	Route::get('/keyword', [App\Http\Controllers\KeywordController::class, 'index'])->middleware('auth');
	Route::post('/keyword', [App\Http\Controllers\KeywordController::class, 'store'])->middleware('auth');
	Route::get('/keyword/delete/{id}',[App\Http\Controllers\KeywordController::class, 'destroy'])->middleware('auth');
	Route::get('/keyword/update_keyword/{id}',[App\Http\Controllers\KeywordController::class, 'edit'])->middleware('auth');
	
	Route::post('/keyword/edit',[App\Http\Controllers\KeywordController::class, 'edit'])->middleware('auth');
		
	Route::get('/keyword/editIcon/{id}',[App\Http\Controllers\KeywordController::class, 'editIcon'])->middleware('auth');
	Route::post('/keyword/updateIcon/{id}',[App\Http\Controllers\KeywordController::class, 'updateIcon'])->middleware('auth');
	Route::get('/keyword/icon_del/{id}', [App\Http\Controllers\KeywordController::class, 'deleteIcon']);
	Route::post('/keyword/update',[App\Http\Controllers\KeywordController::class, 'update'])->middleware('auth');
	Route::get('/keyword/getChildCategories/{id}',[App\Http\Controllers\KeywordController::class, 'getChildCategories'])->middleware('auth');
	Route::get('/keyword/view_kw_detail/{id}', [App\Http\Controllers\KeywordController::class, 'viewKW_Details'])->middleware('auth');
	Route::get('/keyword/showBucketViewCityZone/{kid}/{assigncity_id}/{assignone_id}',[App\Http\Controllers\KeywordController::class, 'showBucketViewCityZone'])->middleware('auth');
	Route::get('/keyword/bucket/{kw_id}/{bucket_id}',[App\Http\Controllers\KeywordController::class, 'viewBucket_Details'])->middleware('auth');
	Route::get('/keyword/showBucketcz/{kw_id}/{cityid}/{zoneid}/{bucket_id}', [App\Http\Controllers\KeywordController::class, 'showBucketcz'])->middleware('auth');
	Route::get('/keyword/bucketCityZone/{kw_id}',[App\Http\Controllers\KeywordController::class, 'bucketCityZone'])->middleware('auth');
	Route::get('/keyword/assigin-get-zones/{city_id}/{kwID}',[App\Http\Controllers\KeywordController::class, 'assigingetzones'])->middleware('auth');
	Route::get('/keyword/seoStatus/{id}/{val}', [App\Http\Controllers\KeywordController::class, 'seoStatus'])->middleware('auth:developer');
	

	/* Keywords */

/* SEO */
	Route::get('/seo-report',[App\Http\Controllers\KeywordController::class, 'seoReport'])->middleware('auth');
	Route::get('/seo-report-popup/{id}',[App\Http\Controllers\KeywordController::class, 'seoReportPopup'])->middleware('auth');
	Route::get('/seo',[App\Http\Controllers\KeywordController::class, 'indexSEO'])->middleware('auth');
	Route::get('/seo/{keyword}',[App\Http\Controllers\KeywordController::class, 'editSEO'])->middleware('auth');
	Route::post('/seo/{keyword}',[App\Http\Controllers\KeywordController::class, 'updateSEO'])->middleware('auth');
	Route::post('/seo/updateMetaInformation/{id}',[App\Http\Controllers\KeywordController::class, 'updateMetaInformation'])->middleware('auth');
	Route::post('/seo/updateAboutKeyword/{id}',[App\Http\Controllers\KeywordController::class, 'updateAboutKeyword'])->middleware('auth');
	Route::post('/seo/updatePageContent/{id}',[App\Http\Controllers\KeywordController::class, 'updatePageContent'])->middleware('auth');
	Route::post('/seo/updateFaqKeyword/{id}',[App\Http\Controllers\KeywordController::class, 'updateFaqKeyword'])->middleware('auth');

	/* SEO */
 	Route::get('/seo-work', [App\Http\Controllers\SeoWorkController::class, 'index']);

		

	//seoWork
	Route::get('seo-work', [App\Http\Controllers\SeoWorkController::class, 'index'])->middleware('auth:developer');
	Route::get('seo-work/add', [App\Http\Controllers\SeoWorkController::class, 'seoWorkAdd'])->middleware('auth:developer');
	Route::post('seo-work/saveSeoWork', [App\Http\Controllers\SeoWorkController::class, 'seoWorkSave'])->middleware('auth:developer');
	Route::get('seo-work/edit/{id}', [App\Http\Controllers\SeoWorkController::class, 'edit'])->middleware('auth:developer');
	Route::post('seo-work/editSaveSeoWork/{id}', [App\Http\Controllers\SeoWorkController::class, 'seoWorkEditSave'])->middleware('auth:developer');
 
	Route::get('seo-work/get-seo-work', [App\Http\Controllers\SeoWorkController::class, 'getSeoWorkPagination'])->middleware('auth:developer');
	Route::get('seo-work/delete/{id}', [App\Http\Controllers\SeoWorkController::class, 'destroy'])->middleware('auth:developer');
	
 
	//seoWork
	Route::get('classified-profile', [App\Http\Controllers\ClassifiedProfileController::class, 'index'])->middleware('auth:developer');
	Route::get('classified-profile/add', [App\Http\Controllers\ClassifiedProfileController::class, 'classifiedProfileAdd'])->middleware('auth:developer');
	Route::post('classified-profile/saveClassifiedProfile', [App\Http\Controllers\ClassifiedProfileController::class, 'classifiedProfileSave'])->middleware('auth:developer');
	Route::get('classified-profile/edit/{id}', [App\Http\Controllers\ClassifiedProfileController::class, 'edit'])->middleware('auth:developer');
	Route::post('classified-profile/editSaveClassifiedProfile/{id}', [App\Http\Controllers\ClassifiedProfileController::class, 'classifiedProfileEditSave'])->middleware('auth:developer');
 
	Route::get('classified-profile/get-classified-profile', [App\Http\Controllers\ClassifiedProfileController::class, 'getclassifiedProfilePagination'])->middleware('auth:developer');
	Route::get('classified-profile/delete/{id}', [App\Http\Controllers\ClassifiedProfileController::class, 'destroy'])->middleware('auth:developer');
	//

	
	Route::get('/seo-kwd-assign',[App\Http\Controllers\SeoKwdAssignController::class, 'index'])->middleware('auth');
	Route::post('/seo-kwd-assign',[App\Http\Controllers\SeoKwdAssignController::class, 'store'])->middleware('auth');
	Route::get('/seo-kwd-assign/get-seo-kwd-assign',[App\Http\Controllers\SeoKwdAssignController::class, 'getPaginatedSeoKwdAssign'])->middleware('auth');
	Route::get('/seo-kwd-assign/edit/{id}',[App\Http\Controllers\SeoKwdAssignController::class, 'edit'])->middleware('auth');
	Route::post('/seo-kwd-assign/update/{id}',[App\Http\Controllers\SeoKwdAssignController::class, 'update'])->middleware('auth');
	Route::get('/seo-kwd-assign/delete/{id}',[App\Http\Controllers\SeoKwdAssignController::class, 'destroy'])->middleware('auth');
	Route::get('/seo-kwd-assign/{id}',[App\Http\Controllers\SeoKwdAssignController::class, 'getRolePermissions'])->middleware('auth');	
	 
 	Route::get('/assignSeoKeyword',[App\Http\Controllers\SeoKwdAssignController::class, 'assignSeoKeyword']);
	Route::get('/team-kwd-assign/get-team-assign-seo-keyword',[App\Http\Controllers\SeoKwdAssignController::class, 'getPaginatedAssignSeoKeyword']);

//


/* form type */
 
	Route::get('form-type', [App\Http\Controllers\FormTypeController::class, 'index'])->middleware('auth:developer');
	Route::get('form-type/add', [App\Http\Controllers\FormTypeController::class, 'formTypeAdd'])->middleware('auth:developer');
	Route::post('form-type/saveFormType', [App\Http\Controllers\FormTypeController::class, 'formTypeSave'])->middleware('auth:developer');
	Route::get('form-type/edit/{id}', [App\Http\Controllers\FormTypeController::class, 'edit'])->middleware('auth:developer');
	Route::post('form-type/editSaveFormType/{id}', [App\Http\Controllers\FormTypeController::class, 'formTypeEditSave'])->middleware('auth:developer');
 
	Route::get('form-type/get-form-type', [App\Http\Controllers\FormTypeController::class, 'getFormTypePagination'])->middleware('auth:developer');
	Route::get('/form-type/status/{id}/{val}', [App\Http\Controllers\FormTypeController::class, 'status'])->middleware('auth:developer');

	Route::get('form-type/delete/{id}', [App\Http\Controllers\FormTypeController::class, 'destroy'])->middleware('auth:developer');
	 
/* form type */
  

/* form type */
 
	Route::get('home_slider', [App\Http\Controllers\HomeSliderController::class, 'index'])->middleware('auth:developer');
	Route::get('home_slider/add', [App\Http\Controllers\HomeSliderController::class, 'sliderAdd'])->middleware('auth:developer');
	Route::post('home_slider/saveSlider', [App\Http\Controllers\HomeSliderController::class, 'store'])->middleware('auth:developer');
	Route::get('home_slider/edit/{id}', [App\Http\Controllers\HomeSliderController::class, 'edit'])->middleware('auth:developer');
	Route::post('home_slider/editSaveSlider/{id}', [App\Http\Controllers\HomeSliderController::class, 'update'])->middleware('auth:developer');
	Route::get('home_slider/del_img/{id}', [App\Http\Controllers\HomeSliderController::class, 'imageDeleted'])->middleware('auth:developer');
 
	Route::get('home_slider/get-home_slider', [App\Http\Controllers\HomeSliderController::class, 'getHomeSliderPagination'])->middleware('auth:developer');
	Route::get('/home_slider/status/{id}/{val}', [App\Http\Controllers\HomeSliderController::class, 'status'])->middleware('auth:developer');

	Route::get('home_slider/delete/{id}', [App\Http\Controllers\HomeSliderController::class, 'destroy'])->middleware('auth:developer');
	 
/* form type */

/* form type */
 
	Route::get('author', [App\Http\Controllers\AuthorController::class, 'index'])->middleware('auth:developer');
	Route::get('author/add', [App\Http\Controllers\AuthorController::class, 'authorAdd'])->middleware('auth:developer');
	Route::post('author/saveAuthor', [App\Http\Controllers\AuthorController::class, 'store'])->middleware('auth:developer');
	Route::get('author/edit/{id}', [App\Http\Controllers\AuthorController::class, 'edit'])->middleware('auth:developer');
	Route::post('author/editSaveAuthor/{id}', [App\Http\Controllers\AuthorController::class, 'update'])->middleware('auth:developer');
	Route::get('author/del_img/{id}', [App\Http\Controllers\AuthorController::class, 'imageDeleted'])->middleware('auth:developer'); 
	Route::get('author/get-author', [App\Http\Controllers\AuthorController::class, 'getAuthorPagination'])->middleware('auth:developer');
	Route::get('/author/status/{id}/{val}', [App\Http\Controllers\AuthorController::class, 'status'])->middleware('auth:developer');
	Route::get('author/delete/{id}', [App\Http\Controllers\AuthorController::class, 'destroy'])->middleware('auth:developer');
	 
/* form type */
  
	Route::get('/category/seo',[App\Http\Controllers\KeywordController::class, 'indexCategotySEO'])->middleware('auth');
	Route::get('/categoryEdit/seo/{id}',[App\Http\Controllers\KeywordController::class, 'editCategorySEO'])->middleware('auth');
	Route::post('/updateCategorySEO/seo/{id}',[App\Http\Controllers\KeywordController::class, 'updateCategorySEO'])->middleware('auth');
	
	Route::get('/childcategory/seo',[App\Http\Controllers\KeywordController::class, 'indexChildcategorySEO'])->middleware('auth');
	Route::get('/childcategoryEdit/seo/{id}',[App\Http\Controllers\KeywordController::class, 'editChildcategorySEO'])->middleware('auth');
	Route::post('/updateChildcategorySEO/seo/{id}',[App\Http\Controllers\KeywordController::class, 'updateChildcategorySEO'])->middleware('auth');
	 
	Route::post('/updateAboutCategory/{id}',[App\Http\Controllers\ParentCategoryController::class, 'updateAboutCategory'])->middleware('auth');
	
 

/* Leads */
	Route::get('/lead',[App\Http\Controllers\LeadController::class, 'index'])->middleware('auth:developer');
	Route::get('/new-lead', [App\Http\Controllers\LeadController::class, 'newlead']);
	Route::get('/getnewlead',[App\Http\Controllers\LeadController::class, 'getnewlead'])->middleware('auth');
	Route::post('/lead',[App\Http\Controllers\LeadController::class, 'store'])->middleware('auth');
	Route::post('/lead/getleadssexcel',[App\Http\Controllers\LeadController::class,'getLeadsExcel'])->middleware('auth');
	Route::get('/lead/add-lead',[App\Http\Controllers\LeadController::class,'create'])->middleware('auth');
	
	Route::post('/lead/add-lead',[App\Http\Controllers\LeadController::class,'store'])->middleware('auth');
	Route::get('/lead/repost/{id}', [App\Http\Controllers\LeadController::class,'leadRepost'])->middleware('auth');
	Route::get('/lead/edit/{id}',[App\Http\Controllers\LeadController::class,'edit'])->middleware('auth');
	Route::post('/lead/update/{id}',[App\Http\Controllers\LeadController::class,'updateSaveLead'])->middleware('auth');
	Route::get('/lead/leadFollowupForm/{id}',[App\Http\Controllers\LeadController::class,'followUp'])->middleware('auth');
	Route::post('/lead/submitLeadFollowup/{id}',[App\Http\Controllers\LeadController::class,'storeLeadFollowup'])->middleware('auth');
	Route::get('/lead/getfollowups/{id}',[App\Http\Controllers\LeadController::class,'getFollowUps'])->middleware('auth');
	 
/* Leads */
// ********
// TRANSFER
	Route::get('/permanent-transfer',[App\Http\Controllers\TransferController::class,'index'])->middleware('auth');
	Route::post('/permanent-transfer',[App\Http\Controllers\TransferController::class,'transfer'])->middleware('auth');
// TRANSFER
// ********
/* Payment Mode */
	Route::get('/mode',[App\Http\Controllers\ModeController::class,'index'])->middleware('auth');
	Route::get('/mode/add-mode', [App\Http\Controllers\ModeController::class,'create'])->middleware('auth');
	Route::post('/mode/add-mode',[App\Http\Controllers\ModeController::class,'store'])->middleware('auth'); 

	Route::post('/bank',[App\Http\Controllers\BanksController::class,'index'])->middleware('auth');
	Route::get('/bank/add-bank',[App\Http\Controllers\BanksController::class,'create'])->middleware('auth');
	Route::post('/bank/add-bank',[App\Http\Controllers\BanksController::class,'store'])->middleware('auth');
	 
/* Payment Mode */

/* Zone */
	Route::get('/zone',[App\Http\Controllers\ZoneController::class,'index'])->middleware('auth');
	Route::post('/zone',[App\Http\Controllers\ZoneController::class,'store'])->middleware('auth');
	Route::get('/zone/update/{id}',[App\Http\Controllers\ZoneController::class,'edit'])->middleware('auth');
	Route::post('/zone/update/{id}',[App\Http\Controllers\ZoneController::class,'update'])->middleware('auth');
	Route::get('/zone/delete/{id}',[App\Http\Controllers\ZoneController::class,'destroy'])->middleware('auth:developer');
	Route::get('/state/get-cityes/{state_id}',[App\Http\Controllers\ZoneController::class,'getState'])->middleware('auth');
	Route::get('/zone/get-zones/{city_id}',[App\Http\Controllers\ZoneController::class,'getZones'])->middleware('auth');
/* Zone */

/* Area */
	Route::get('/area', [App\Http\Controllers\AreaController::class,'index'])->middleware('auth:developer');
	Route::get('/area/update/{id}',[App\Http\Controllers\AreaController::class,'edit'])->middleware('auth');
	Route::post('/area/update/{id}',[App\Http\Controllers\AreaController::class,'update'])->middleware('auth');
	Route::post('/area',[App\Http\Controllers\AreaController::class,'store'])->middleware('auth');
	Route::get('/area/delete/{id}',[App\Http\Controllers\AreaController::class,'destroy'])->middleware('auth');
	Route::get('/area/get-areas/{zone_id}', [App\Http\Controllers\AreaController::class,'getAreas'])->middleware('auth');
	Route::get('/area/get-ajax-areas',[App\Http\Controllers\AreaController::class,'getAjaxAreas'])->middleware('auth:developer');
/* Area */

/* Transaction */
	Route::get('/transactions', [App\Http\Controllers\TransactionController::class,'index'])->middleware('auth');
	Route::get('/order-history',[App\Http\Controllers\OrderHistoryController::class,'index'])->middleware('auth');
	Route::get('/order-history/update/{order_id}',[App\Http\Controllers\OrderHistoryController::class,'edit'])->middleware('auth');
	Route::post('/order-history/update',[App\Http\Controllers\OrderHistoryController::class,'update'])->middleware('auth');
	Route::get('/clientOrderHistoryDelete/delete/{id}',[App\Http\Controllers\OrderHistoryController::class,'clientOrderHistoryDelete'])->middleware('auth');
	Route::get('/clientOrderHistoryStatus/status/{id}',[App\Http\Controllers\OrderHistoryController::class,'status'])->middleware('auth');
	Route::post('/orderhistory/getorderhistoryexcel',[App\Http\Controllers\OrderHistoryController::class,'getorderhistoryexcel'])->middleware('auth');
	
	 
/* Transaction */

/* Push Lead */
	Route::get('/push-lead',[App\Http\Controllers\PushLeadController::class,'index'])->middleware('auth');
	Route::post('/push-lead',[App\Http\Controllers\PushLeadController::class,'store'])->middleware('auth');
	
	
	Route::post('/push-lead-query-form',[App\Http\Controllers\PushLeadController::class,'storeFromQueryForm'])->middleware('auth');
	Route::get('/push-lead/update/{id}',[App\Http\Controllers\PushLeadController::class,'edit'])->middleware('auth');
	Route::post('/push-lead/update/{id}',[App\Http\Controllers\PushLeadController::class,'update'])->middleware('auth');
// 	Route::get('/push-lead/delete/{id}', 'PushLeadController@destroy')->middleware('auth');
	Route::get('/new-lead/delete/{id}',[App\Http\Controllers\LeadController::class,'newleaddelete'])->middleware('auth');
	Route::get('/clientAssignleaddelete/delete/{id}', [App\Http\Controllers\LeadController::class,'clientAssignleaddelete'])->middleware('auth');
 
	Route::get('/push-lead/push/{id}',[App\Http\Controllers\LeadController::class,'pushLeadWithoutZone'])->middleware('auth');
	
	Route::post('/assignlead/push', [App\Http\Controllers\LeadController::class,'assignlead'])->middleware('auth:developer');
	Route::post('/assignleadAPI/push/', [App\Http\Controllers\LeadController::class,'assignleadAPI'])->middleware('auth');
	Route::get('new-lead/update/{id}', [App\Http\Controllers\LeadController::class,'edit'])->middleware('auth');
	Route::post('new-lead/update/{id}', [App\Http\Controllers\LeadController::class,'updateNewLead'])->middleware('auth');
	
	Route::post('/new-lead/move-not-interested', [App\Http\Controllers\LeadController::class,'moveNotInterested'])->middleware('auth');	
	Route::get('/new-lead/not-interested', [App\Http\Controllers\LeadController::class,'indexNotInterested'])->middleware('auth');	
	Route::post('/new-lead/move-to-lead',[App\Http\Controllers\LeadController::class,'moveToLeads'])->middleware('auth');
	Route::post('/new-lead/selectDeleteParmanent',[App\Http\Controllers\LeadController::class,'selectDeleteParmanent'])->middleware('auth');
	
	
	
/* Push Lead */


/* Business Keywords */
 Route::get('/business_keyword',[App\Http\Controllers\BusinessKeywordController::class,'index'])->middleware('auth');
Route::post('/business_keyword',[App\Http\Controllers\BusinessKeywordController::class,'store'])->middleware('auth');
Route::get('/business_keyword/delete/{id}',[App\Http\Controllers\BusinessKeywordController::class,'destroy'])->middleware('auth');
Route::get('/business_keyword/update_keyword/{id}', [App\Http\Controllers\BusinessKeywordController::class,'edit'])->middleware('auth');  
Route::post('/business_keyword/update',[App\Http\Controllers\BusinessKeywordController::class,'update'])->middleware('auth');
Route::get('/business_keyword/getKeywords/{id}',[App\Http\Controllers\BusinessKeywordController::class,'getKeywords'])->middleware('auth');  
/* Business Keywords */

/* Keyword Sell Count */
	Route::get('/keyword_sell_count',[App\Http\Controllers\KeywordSellCountController::class,'index'])->middleware('auth');
	Route::get('/keyword_sell_count/add',[App\Http\Controllers\KeywordSellCountController::class,'add'])->middleware('auth');
	Route::post('/saveKeywordSellCount',[App\Http\Controllers\KeywordSellCountController::class,'store'])->middleware('auth');
	Route::get('/keyword_sell_count/delete/{id}',[App\Http\Controllers\KeywordSellCountController::class,'destroy'])->middleware('auth');
	Route::get('/keyword_sell_count/edit/{id}',[App\Http\Controllers\KeywordSellCountController::class,'edit'])->middleware('auth'); //ajax
	Route::post('/keyword_sell_count/editSaveKeywordSellCount/{id}', [App\Http\Controllers\KeywordSellCountController::class,'update'])->middleware('auth');
	Route::get('keywordSellCounts/get-keywordSellCounts', [App\Http\Controllers\KeywordSellCountController::class, 'getKeywordSellCountPagination'])->middleware('auth:developer');
	Route::get('keyword_sell_count/status/{id}/{val}', [App\Http\Controllers\KeywordSellCountController::class, 'status'])->middleware('auth:developer');
	
	/* Keyword Sell Count */


 
// Route::post('/password/email',[App\Http\Controllers\Auth\PasswordController::class,'sendResetLinkEmail']);
// Route::post('/password/reset',[App\Http\Controllers\Auth\PasswordController::class,'reset']);
// Route::get('/password/reset/{token?}',[App\Http\Controllers\Auth\PasswordController::class,'showResetForm']);

	


//Route::auth();
 
 

		
	Route::get('/user/search', [App\Http\Controllers\Client\HomePageController::class, 'searchUser'])->middleware('auth');
	 
	 
	 
/* Client Routes */

/* Admin side client handling routes */
	Route::get('/clients/delkw/{id}', [App\Http\Controllers\BackEndClientsController::class, 'delKW'])->middleware('auth');
	Route::get('/clients/search', [App\Http\Controllers\BackEndClientsController::class, 'searchForm'])->middleware('auth');
	Route::get('/clients/categories', [App\Http\Controllers\ClientCategoryController::class, 'index'])->middleware('auth');
	Route::get('/clients/categories/update/{id}', [App\Http\Controllers\ClientCategoryController::class, 'edit'])->middleware('auth');
	Route::post('/clients/categories/update/{id}', [App\Http\Controllers\ClientCategoryController::class, 'update'])->middleware('auth');
	Route::post('/clients/add_client_category', [App\Http\Controllers\ClientCategoryController::class, 'store'])->middleware('auth');
	 
 	
	 	 
	Route::get('/clients/delete_client_category/{id}',[App\Http\Controllers\ClientCategoryController::class, 'destroy'])->middleware('auth');
	 
	Route::get('/clients/register',[App\Http\Controllers\BackEndClientsController::class, 'create'])->middleware('auth');
	Route::post('/clients/register',[App\Http\Controllers\BackEndClientsController::class, 'store'])->middleware('auth');
	Route::post('/clients/remark/{id}',[App\Http\Controllers\BackEndClientsController::class, 'remark'])->middleware('auth');
	Route::post('/clients/discussion/{id}',[App\Http\Controllers\BackEndClientsController::class, 'remarkDiscussion'])->middleware('auth');
	Route::post('/clients/payment',action: [App\Http\Controllers\BackEndClientsController::class, 'paymentClient'])->middleware('auth');
	Route::get('/clients/getpaymentPrintfile',[App\Http\Controllers\BackEndClientsController::class, 'getpaymentPrintfile'])->middleware('auth');
	Route::post('/clients/getpaymentPrint',[App\Http\Controllers\BackEndClientsController::class, 'getpaymentPrint'])->middleware('auth');
	Route::get('/clients/geteditpayment/{id}', [App\Http\Controllers\BackEndClientsController::class, 'geteditpayment'])->middleware('auth');  
	Route::post('/clients/getinvoicePrintPdf',[App\Http\Controllers\BackEndClientsController::class, 'getinvoicePrintPdf'])->middleware('auth');
	Route::post('/clients/getproformaPrintPdf',[App\Http\Controllers\BackEndClientsController::class, 'getproformaPrintPdf'])->middleware('auth');
	Route::get('/clients/restore/{id?}',[App\Http\Controllers\BackEndClientsController::class, 'restore'])->middleware('auth');
	Route::get('/clients/list/deleted-clients/{id?}',[App\Http\Controllers\BackEndClientsController::class, 'deletedClients'])->middleware('auth');
	Route::get('/clients/list/getclients',[App\Http\Controllers\BackEndClientsController::class, 'getPaginatedClients']);
	Route::post('/clients/list/getclientsexcel',[App\Http\Controllers\BackEndClientsController::class, 'getClientsExcel'])->middleware('auth');
	Route::get('/clients/list/{id?}',[App\Http\Controllers\BackEndClientsController::class, 'index'])->middleware('auth');
	Route::get('/clients/list/{id?}/sendpass',[App\Http\Controllers\BackEndClientsController::class, 'generateNewPass'])->middleware('auth');
	Route::get('/clients/update/{id}',[App\Http\Controllers\BackEndClientsController::class, 'update'])->middleware('auth');
	Route::get('/clients/update/{id}/getleads',[App\Http\Controllers\BackEndClientsController::class, 'getPaginatedLeads'])->middleware('auth');
	Route::get('/clients/update/{id}/getdescussion',[App\Http\Controllers\BackEndClientsController::class, 'getDescussion'])->middleware('auth');
	Route::get('/clients/update/{id}/get-paginated-assigned-keywords',[App\Http\Controllers\BackEndClientsController::class, 'getPaginatedAssignedKeywords'])->middleware('auth');
	Route::post('/clients/update/{id}/delete-selected-assigned-kwds',[App\Http\Controllers\BackEndClientsController::class, 'deleteSelectedAssignedKwds'])->middleware('auth');
	Route::get('/clients/update/{id}/update-price-assigned-kwds',[App\Http\Controllers\BackEndClientsController::class, 'updatePriceAssignedKwds'])->middleware('auth');
	Route::get('/clients/update/{id}/get-paginated-transactions',[App\Http\Controllers\BackEndClientsController::class, 'getPaginatedTransactions'])->middleware('auth');
	Route::get('/clients/update/{id}/get-paginated-payment-history',[App\Http\Controllers\BackEndClientsController::class, 'getPaginatedPaymentHistory'])->middleware('auth');
	Route::get('/clients/update/{id}/edit-assigned-keyword/{record_id}',[App\Http\Controllers\BackEndClientsController::class, 'editAssignedKeyword'])->middleware('auth');
	Route::post('/clients/update/{id}/update-assigned-keyword/{record_id}',[App\Http\Controllers\BackEndClientsController::class, 'updateAssignedKeyword'])->middleware('auth');
	Route::get('/clients/update/{id}/get-assigned-areas',[App\Http\Controllers\BackEndClientsController::class, 'getAssignedAreas'])->middleware('auth');
	Route::get('/clients/update/{id}/get-assigned-zones',[App\Http\Controllers\BackEndClientsController::class, 'getAssignedZones'])->middleware('auth');
	Route::post('/clients/update/{id}/add-area-to-client',[App\Http\Controllers\BackEndClientsController::class, 'addAreaToClient'])->middleware('auth');
	
	Route::post('/clients/addZoneToClient/{id}',[App\Http\Controllers\BackEndClientsController::class, 'addZoneToClient'])->middleware('auth');
	Route::post('/clients/editSaveClientProfileLogo/{id}',[App\Http\Controllers\BackEndClientsController::class, 'editSaveClientProfileLogo'])->middleware('auth:developer');
	Route::post('/clients/uploadClientGalleryPics/{id}',[App\Http\Controllers\BackEndClientsController::class, 'uploadClientGalleryPics'])->middleware('auth:developer');
	Route::post('/clients/uploadClientGallery/{id}',[App\Http\Controllers\BackEndClientsController::class, 'uploadClientGalleryPics'])->middleware('auth:developer');
	 
	Route::get('/clients/update/profileLogo/logoDel/{id}',[App\Http\Controllers\BackEndClientsController::class, 'logoDel']);
	Route::get('/clients/update/profileLogo/profilePicDel/{id}',[App\Http\Controllers\BackEndClientsController::class, 'profilePicDel']);
	
	
	Route::get('/clients/update/{id}/editZoneClient/edit-assigned-zone/{assigned_zone_id}',[App\Http\Controllers\BackEndClientsController::class, 'editAssignedZoneClient'])->middleware('auth');
	 
	Route::post('/clients/update/{id}/update-assigned-zone-areas',[App\Http\Controllers\BackEndClientsController::class, 'updateAssignedZoneAreas'])->middleware('auth');
	
	Route::get('/clients/update/{id}/area/delete/{assigned_area_id}',[App\Http\Controllers\BackEndClientsController::class, 'destroyAreaFromClient'])->middleware('auth');
	Route::get('/clients/update/{id}/zone/delete/{assigned_zone_id}',[App\Http\Controllers\BackEndClientsController::class, 'destroyZoneFromClient'])->middleware('auth');
	Route::post('/assignLocation/selectAssignZoneDelete',[App\Http\Controllers\BackEndClientsController::class, 'selectAssignZoneDelete'])->middleware('auth');
	Route::post('/clients/update/{id}',[App\Http\Controllers\BackEndClientsController::class, 'update'])->middleware('auth');
	Route::post('/clients/editSavePersonalDetails/{id}',[App\Http\Controllers\BackEndClientsController::class, 'editSavePersonalDetails'])->middleware('auth:developer');
	Route::post('/clients/ediSaveBusinessInfo/{id}',[App\Http\Controllers\BackEndClientsController::class, 'ediSaveBusinessInfo'])->middleware('auth:developer');
	Route::post('/clients/clientConversionStatus/{id}',[App\Http\Controllers\BackEndClientsController::class, 'clientConversionStatus'])->middleware('auth:developer');
	  
	Route::post('/clients/editSaveUploadPics/{id}',[App\Http\Controllers\BackEndClientsController::class, 'editSaveUploadPics'])->middleware('auth:developer');
	Route::post('/clients/save-certificate-auto/{id}',[App\Http\Controllers\BackEndClientsController::class, 'autoSaveCertificate'])->middleware('auth:developer');
	Route::post('/clients/save-award-auto/{id}',[App\Http\Controllers\BackEndClientsController::class, 'autoSaveAward'])->middleware('auth:developer');
	
	
	Route::get('/clients/certificate/{slug}/{id}',[App\Http\Controllers\BackEndClientsController::class, 'certificateDel']);
	Route::get('/clients/award/{slug}/{id}',[App\Http\Controllers\BackEndClientsController::class, 'awardDel']);
 



	Route::post('/clients/assignClientToEmployee/{id}',[App\Http\Controllers\BackEndClientsController::class, 'assignClientToEmployee'])->middleware('auth:developer');
	Route::post('/clients/conversionClientStatus/{id}',[App\Http\Controllers\BackEndClientsController::class, 'conversionClientStatus'])->middleware('auth:developer');
	Route::post('/clients/clientPaidStatus/{id}',[App\Http\Controllers\BackEndClientsController::class, 'conversionClientStatus'])->middleware('auth:developer');
	Route::post('/clients/clientCertifiedStatus/{id}',[App\Http\Controllers\BackEndClientsController::class, 'clientCertifiedStatus'])->middleware('auth:developer');
	Route::post('/clients/clientPackegeStatus/{id}',[App\Http\Controllers\BackEndClientsController::class, 'clientPackegeStatus'])->middleware('auth:developer');
	Route::post('/clients/clientMaxKw/{id}',[App\Http\Controllers\BackEndClientsController::class, 'clientMaxKw'])->middleware('auth:developer');
	Route::post('/clients/clientMaxKw/{id}',[App\Http\Controllers\BackEndClientsController::class, 'clientMaxKw'])->middleware('auth:developer');
	Route::post('/clients/clientLeadsCount/{id}',[App\Http\Controllers\BackEndClientsController::class, 'clientLeadsCount'])->middleware('auth:developer');
	Route::post('/clients/clientBalanceAmount/{id}',[App\Http\Controllers\BackEndClientsController::class, 'clientBalanceAmount'])->middleware('auth:developer');
	Route::post('/clients/clientYrlySubsStartingSate/{id}',[App\Http\Controllers\BackEndClientsController::class, 'clientYrlySubsStartingSate'])->middleware('auth:developer');
	Route::get('/clients/{delete}/{id}',[App\Http\Controllers\BackEndClientsController::class, 'destroy'])->middleware('auth');
	Route::post('/clients/get/{what}/{id?}',[App\Http\Controllers\BackEndClientsController::class, 'getField'])->middleware('auth');
	Route::get('/clientTransactionDelete/delete/{id}',[App\Http\Controllers\BackEndClientsController::class, 'clientTransactionDelete'])->middleware('auth');
/* Admin side client handling routes */

/* Bulk Upload */
	Route::get('/bulkupload/keyword',[App\Http\Controllers\BulkUploadController::class, 'createBulkUploadKeyword'])->middleware('auth');
	Route::post('/bulkupload/keyword',[App\Http\Controllers\BulkUploadController::class, 'storeBulkUploadKewyword'])->middleware('auth');
	Route::post('/bulkupload/downloadexcelformate',[App\Http\Controllers\BulkUploadController::class, 'downloadExcelFormate']); 
	Route::post('/bulkupload/downloadexcellead',[App\Http\Controllers\BulkUploadController::class, 'downloadExcelLead']); 
	Route::post('/keyword/getparentcategory', [App\Http\Controllers\BulkUploadController::class, 'getparentcategory'])->middleware('auth');
	Route::post('/keyword/getchildcategory',[App\Http\Controllers\BulkUploadController::class, 'getchildcategory'])->middleware('auth');
	
	Route::get('/bulkupload/lead',[App\Http\Controllers\BulkUploadController::class, 'createBulkUploadLead'])->middleware('auth');
	Route::post('/bulkupload/lead',[App\Http\Controllers\BulkUploadController::class, 'storeBulkUploadLead'])->middleware('auth');

Route::get('/bulkupload/zone',[App\Http\Controllers\ZoneController::class, 'createBulkUploadZone'])->middleware('auth');
	Route::post('/bulkupload/zone',[App\Http\Controllers\ZoneController::class, 'importExcelZone'])->middleware('auth');

	/* Bulk Upload */

/* developer Mode routing */
Route::get('mode/modedetails',[App\Http\Controllers\ModeController::class, 'index'])->middleware('auth');



Route::match(['get','post'],'mode/add', [App\Http\Controllers\ModeController::class, 'add'])->middleware('auth');
Route::match(['get','post'],'mode/edit/{id}', [App\Http\Controllers\ModeController::class, 'edit'])->middleware('auth');
Route::get('mode/getmode', [App\Http\Controllers\ModeController::class, 'getPaginationMode'])->middleware('auth');
Route::get('/mode/delete/{id}', [App\Http\Controllers\ModeController::class, 'deleted'])->middleware('auth');
Route::get('mode/status/{id}/{val}',[App\Http\Controllers\ModeController::class, 'status'])->middleware('auth');
/* developer Mode routing */

/* developer Banks routing */
Route::get('banks/banksdetails', [App\Http\Controllers\BanksController::class, 'index'])->middleware('auth');
Route::match(['get','post'],'banks/add', [App\Http\Controllers\BanksController::class, 'add'])->middleware('auth');
Route::match(['get','post'],'banks/edit/{id}', [App\Http\Controllers\BanksController::class, 'edit'])->middleware('auth');
Route::get('banks/getbanksdetails', [App\Http\Controllers\BanksController::class, 'getPaginationBanks'])->middleware('auth');
Route::get('/banks/delete/{id}', [App\Http\Controllers\BanksController::class, 'deleted'])->middleware('auth'); 
Route::get('banks/status/{id}/{val}',[App\Http\Controllers\BanksController::class, 'status'])->middleware('auth');
/* developer Banks routing */

/* developer Blog routing */
Route::get('blog/blogdetails', [App\Http\Controllers\BlogController::class, 'index'])->middleware('auth');
Route::get('blog/addBlog', [App\Http\Controllers\BlogController::class, 'add'])->middleware('auth');
Route::post('blog/addBlog', [App\Http\Controllers\BlogController::class, 'addBlog'])->middleware('auth');
Route::get('blog/editBlog/{id}', [App\Http\Controllers\BlogController::class, 'edit'])->middleware('auth');
Route::post('blog/updateBlogMeta/{id}', [App\Http\Controllers\BlogController::class, 'updateBlogMeta'])->middleware('auth');
Route::post('blog/updateAboutBlog/{id}', [App\Http\Controllers\BlogController::class, 'updateAboutBlog'])->middleware('auth');
Route::post('blog/updatePageContent/{id}', [App\Http\Controllers\BlogController::class, 'updatePageContent'])->middleware('auth');
Route::post('blog/updatePageContent/{id}', [App\Http\Controllers\BlogController::class, 'updatePageContent'])->middleware('auth');
Route::post('blog/updateBlogImage/{id}', [App\Http\Controllers\BlogController::class, 'updateBlogImage'])->middleware('auth');
Route::post('blog/updateFaqBlog/{id}', [App\Http\Controllers\BlogController::class, 'updateFaqBlog'])->middleware('auth');
Route::get('blog/getblogdetails', [App\Http\Controllers\BlogController::class, 'getPaginationBlog'])->middleware('auth');
Route::get('/blog/delete/{id}', [App\Http\Controllers\BlogController::class, 'deleted'])->middleware('auth'); 
Route::get('/blog/del_icon/{id}', [App\Http\Controllers\BlogController::class, 'imageDeleted'])->middleware('auth'); 
Route::get('/blog/del_blog_banner/{id}', [App\Http\Controllers\BlogController::class, 'delBlogBanner'])->middleware('auth'); 
Route::get('blog/status/{id}/{val}',[App\Http\Controllers\BlogController::class, 'status'])->middleware('auth');
/* developer Blog routing */

/* developer testimonials routing */
Route::get('testimonials/testimonialsdetails', [App\Http\Controllers\TestimonialsController::class, 'index'])->middleware('auth');
Route::match(['get','post'],'testimonials/add', [App\Http\Controllers\TestimonialsController::class, 'add'])->middleware('auth');
Route::match(['get','post'],'testimonials/edit/{id}', [App\Http\Controllers\TestimonialsController::class, 'edit'])->middleware('auth');
Route::get('testimonials/gettestimonialsdetails', [App\Http\Controllers\TestimonialsController::class, 'getPaginationTestimonials'])->middleware('auth');
Route::get('/testimonials/delete/{id}', [App\Http\Controllers\TestimonialsController::class, 'deleted'])->middleware('auth'); 
Route::get('/testimonials/del_icon/{id}', [App\Http\Controllers\TestimonialsController::class, 'imageDeleted'])->middleware('auth'); 
Route::get('testimonials/status/{id}/{val}',[App\Http\Controllers\TestimonialsController::class, 'status'])->middleware('auth');
/* developer testimonials routing */
//Route::resource('posts', 'API\PostAPIController');





//occupation
Route::get('occupation', [App\Http\Controllers\OccupationController::class, 'index'])->middleware('auth:developer');
Route::get('occupationAdd/add', [App\Http\Controllers\OccupationController::class, 'occupationAdd'])->middleware('auth:developer');
Route::post('occupationSave', [App\Http\Controllers\OccupationController::class, 'occupationSave'])->middleware('auth:developer');
Route::get('occupationEdit/edit/{id}', [App\Http\Controllers\OccupationController::class, 'Edit'])->middleware('auth:developer');
Route::post('occupationEditSave/{id}', [App\Http\Controllers\OccupationController::class, 'occupationEditSave'])->middleware('auth:developer');
Route::get('occupation/status/{id}/{val}', [App\Http\Controllers\OccupationController::class, 'status'])->middleware('auth:developer');
Route::get('occupation/get-occupation', [App\Http\Controllers\OccupationController::class, 'getOccupationPagination'])->middleware('auth:developer');
Route::get('occupation/delete/{id}', [App\Http\Controllers\OccupationController::class, 'delete'])->middleware('auth:developer');
 
 
 


//seoCity
Route::get('seoCity', [App\Http\Controllers\SeoCityController::class, 'index'])->middleware('auth:developer');
Route::get('seoCity/add', [App\Http\Controllers\SeoCityController::class, 'seoCityAdd'])->middleware('auth:developer');
Route::post('saveSeoCity', [App\Http\Controllers\SeoCityController::class, 'seoCitySave'])->middleware('auth:developer');
Route::get('seoCity/edit/{id}', [App\Http\Controllers\SeoCityController::class, 'Edit'])->middleware('auth:developer');
Route::post('seoCity/editSaveSeoCity/{id}', [App\Http\Controllers\SeoCityController::class, 'seoCityEditSave'])->middleware('auth:developer');
Route::get('seoCity/status/{id}/{val}', [App\Http\Controllers\SeoCityController::class, 'status'])->middleware('auth:developer');
Route::get('seoCity/get-seoCity', [App\Http\Controllers\SeoCityController::class, 'getSeoCityPagination'])->middleware('auth:developer');
Route::get('seoCity/delete/{id}', [App\Http\Controllers\SeoCityController::class, 'delete'])->middleware('auth:developer');
 
 
 
