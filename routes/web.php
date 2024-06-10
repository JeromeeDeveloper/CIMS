<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\DeceasedController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingPageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Landing Page Routes
Route::get('/', [LandingPageController::class, 'index'])->name('landing.page');

// Forgot Password Module 
Route::post('/users/reset/submit/newpassword', [UserController::class, 'submitNewPassword'])->name("users.submitNewPassword");
Route::post('/users/reset/submit/email', [UserController::class, 'submitEmail'])->name("users.submitEmail");
Route::get('/users/reset/password/page', [UserController::class, 'passwordResetPage'])->name('users.passwordReset');
Route::get('/users/reset/changepassword/page/{id}', [UserController::class, 'changePasswordPage'])->name('users.changePasswordPage');

//Landing Page
Route::post('/landingpage/deceased/search', [LandingPageController::class, 'search'])->name('landingpage.searchdeceased');
Route::get('/landingpage/deceased/get_info/{id}', [LandingPageController::class, 'deceasedinfo'])->name('landingpage.deceasedinfo');
Route::get('/landingpage/deceaseds/show/{id}', [DeceasedController::class, 'show']);

// Admin Routes
Route::group(['middleware' => 'prevent-back-history'], function(){  

	Auth::routes();

	// Route::get('/home', 'HomeController@index');
    Route::get('/adminlogin', [LoginController::class, 'index'])->name('admin.login');
    Route::post('/login_user', [LoginController::class, 'login'])->name('user.login');

    Route::group(['middleware' => ['adminAccess']], function(){
        Route::get('/manager/dashboard', [DashboardController::class, 'manager_index'])->name('managers.dashboard');
        
        Route::get('api/users', [UserController::class, 'data']);
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::post('users/add', [UserController::class, 'store'])->name('users.store');
        Route::put('users/update/{id}', [UserController::class, 'update']);
        Route::get('users/activate/{id}', [UserController::class, 'activate']);
        Route::get('users/deactivate/{id}', [UserController::class, 'deactivate']);
        Route::get('users/show/{id}', [UserController::class, 'show']);

        Route::get('users/get/contactpeople', [UserController::class, 'get_allcontactpeople'])->name('users.contactpeople');
        //services
        Route::resource('services', ServicesController::class);
        Route::get('services/alldata/byjson', [ServicesController::class, 'alldata_bydatatable'])->name('services.all_dataByDatatable');
        Route::get('/services', [ServicesController::class, 'index'])->name('services');
        Route::get('/get/records', [ServicesController::class, 'get_allRecords'])->name('get_allServices');
        Route::get('/services/show/{id}', [ServicesController::class, 'show']);
        Route::get('/services/classified/{id}', [ServicesController::class, 'classified']);
        Route::get('/services/delete/{id}', [ServicesController::class, 'destroy']);

        //deceaseds
        Route::get('/deceased/printpage/{deceased_id}', [DeceasedController::class, 'printpage']);
        Route::get('/deceased/nearing/maturity', [DeceasedController::class, 'nearingmaturity'])->name('deceaseds.nearingmaturity');
        Route::get('/deceaseds/allmaturity', [DeceasedController::class, 'get_allMaturity'])->name('deceaseds.get_allMaturity');
        Route::get('/deceaseds/updateNofication', [DeceasedController::class, 'updatenotification'])->name('deceaseds.updateNotification');
        Route::get('deceaseds/forApproval', [DeceasedController::class, 'deceasedForApproval'])->name('deceaseds.forApproval');
        Route::resource('deceaseds', DeceasedController::class);
        Route::put('deceaseds/update/{id}', [DeceasedController::class, 'update_deceased']);
        Route::get('/deceaseds/show/{id}', [DeceasedController::class, 'show']);
        Route::get('/get/deceaseds/records', [DeceasedController::class, 'get_allData'])->name('deceaseds.get_allData');
        Route::get('/get/deceaseds/records/forLandingPage', [DeceasedController::class, 'get_allDataByJson'])->name('deceaseds.get_allDataByJson');
        Route::get('/get/deceaseds/notificationCount', [DeceasedController::class, 'notificationCount'])->name('deceaseds.notificationCount');
        Route::get('/get/deceaseds/notificationCount/NearingMaturity', [DeceasedController::class, 'notificationCount_NearingMaturity'])->name('deceaseds.nearingMaturityNotifCount');
        Route::get('/get/deceaseds/data/NearingMaturity', [DeceasedController::class, 'get_allMaturityByDatatable'])->name('deceaseds.get_allMaturityByDatatable');
        
        Route::get('/get/deceaseds/forApproval', [DeceasedController::class, 'forApproval'])->name('deceaseds.data_forApproval');
        Route::put('/deceaseds/assign_block/{id1}/{id2}', [DeceasedController::class, 'assign_block']);
        Route::put('/deceaseds/designation/{id1}/{id2}', [DeceasedController::class, 'designation']);
        Route::get('/deceased/approve/{id1}', [DeceasedController::class, 'approve']);
        Route::get('/deceased/disapprove/{id1}', [DeceasedController::class, 'disapprove']);
      
        //Space areas
        Route::resource('spaceareas', BlockController::class);
        Route::get('blocks/alldeceasedsbyblock/{id}', [BlockController::class, 'get_alldeceasedsByBlockInJson']);
        Route::get('blocks/alldata/byjson', [BlockController::class, 'alldata_bydatatable'])->name('blocks.all_dataByDatatable');
        Route::post('/spaceareas/updatewithimage', [BlockController::class, 'update_withImage']);
        Route::post('/submitdeceased', [BlockController::class, 'submitdeceased'])->name('spaceareas.submitdeceased');
        Route::get('/spaceAreas/show/{id}', [BlockController::class, 'show']);
        Route::get('/spaceAreas/delete/{id}', [BlockController::class, 'destroy']);
        Route::get('/get/blocks', [BlockController::class, 'get_allBlocks'])->name('spaceareas.get_allBlocks');
        Route::get('/get/classifiedBlocks/{id1}', [BlockController::class, 'get_classifiedBlocks']);

        
        Route::get('/logout', [LoginController::class, 'logout'])->name('system.logout');
    });

    Route::group(['middleware' => ['staffAccess']], function(){
        Route::get('/staff/dashboard', [DashboardController::class, 'staff_index'])->name('staff.dashboard');
    });

});


