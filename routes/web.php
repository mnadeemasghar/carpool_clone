<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\RideController as AdminRideController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AddressController as AdminAddressController;
use App\Http\Controllers\Admin\WalletController as AdminWalletController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\MailNotificationController as AdminMailNotificationController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\RideContoller;
use App\Http\Controllers\StopController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

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

Route::get('/',[Controller::class,'welcome'])->name('welcome');
Route::get('/sitemap',[Controller::class,'siteMap'])->name('site.map');
Route::get('/faqs',[Controller::class,'faqs'])->name('faqs');
Route::get('/about-us',[Controller::class,'aboutUs'])->name('about.us');
Route::get('/contact-us',[Controller::class,'contactUs'])->name('contact.us');

// Route::post('ride/guest-store', [RideContoller::class, "guestStore"])->name('ride.store.guest');
// Route::resource('ride', RideContoller::class);
Route::post('ride/store', [RideContoller::class, "store"])->name('ride.store');
Route::get('ride/create', [RideContoller::class, "create"])->name('ride.create');
Route::get('ride/map', [RideContoller::class, "map"])->name('ride.map');
Route::get('ride/{ride}', [RideContoller::class, "show"])->name('ride.show');
Route::get('/search-ride',[RideContoller::class,'search'])->name('ride.search');
Route::get('/get-drop-locations', [RideContoller::class, 'getDropLocations'])->name('get.drop.locations');

Route::get('/user/{user}', [UserController::class,'show'])->name('user.show');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('ride', [RideContoller::class, "index"])->name('ride.index');
    Route::get('ride/{ride}/edit', [RideContoller::class, "edit"])->name('ride.edit');
    Route::get('ride/{ride_id}/status', [RideContoller::class, "status"])->name('ride.status');
    Route::post('ride/{ride}/update', [RideContoller::class, "update"])->name('ride.update');
    Route::delete('ride/{ride}/destroy', [RideContoller::class, "destroy"])->name('ride.destroy');

    Route::resource('ride/{ride_id}/stop', StopController::class)->middleware('check.ride.owner');
    Route::resource('ride/{ride_id}/comment', CommentController::class);
    Route::resource('address', AddressController::class);
    // Route::resource('wallet', WalletController::class);
    Route::resource('subscription', SubscriptionController::class);
    Route::get('/how-to-topup', [WalletController::class,'howToToup'])->name('wallet.how.to.topup');
    Route::post('/interested/{ride}',[RideContoller::class,'interested'])->name('ride.interested');
    Route::post('/activate/{ride}',[RideContoller::class,'activate'])->name('ride.activate');
    

    Route::post('/store-device-token', [NotificationController::class, 'storeDeviceToken'])->name('notification.store.device');

    Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {
        Route::resource('ride', AdminRideController::class);
        Route::resource('user', AdminUserController::class);
        Route::resource('address', AdminAddressController::class);
        Route::resource('subscription', AdminSubscriptionController::class);
        Route::resource('mail-notification', AdminMailNotificationController::class);
        Route::resource('blog', AdminBlogController::class);
        Route::get('send-inspire-quote', [AdminMailNotificationController::class,'inspireQuote'])->name('send.inpsire.quote');
        Route::resource('setting', AdminSettingController::class);

        // Route::prefix('wallet')->as('wallet.')->group(function(){
        //     Route::get('/', [AdminWalletController::class, 'index'])->name('index');
        //     Route::get('topup', [AdminWalletController::class, 'topupForm'])->name('topup.form');
        //     Route::post('topup', [AdminWalletController::class, 'topupStore'])->name('topup.store');
        //     Route::get('withdraw', [AdminWalletController::class, 'withdrawForm'])->name('withdraw.form');
        //     Route::post('withdraw', [AdminWalletController::class, 'withdrawStore'])->name('withdraw.store');
        // });
        
    });
});
