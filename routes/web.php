<?php

use App\Http\Controllers\AdminLangsController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CMSPagesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OptimizeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SuccessController;
//use App\Models\MasterUser;
use App\Http\Controllers\MasterUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\ManageSocialController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\MasterMessageController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\MasterLocationController;
use App\Http\Controllers\UpgradeMembershipController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\RequestPartsController;
use App\Http\Controllers\AuditLoginController;
use App\Http\Controllers\BidOfferController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\ParkQuestionController;
use App\Http\Controllers\PartsOrderController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\ComposeEmailController;
use App\Http\Controllers\SentMailController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ManageLogoController;
use App\Http\Controllers\PromoCodeController;

//use Illuminate\Support\Facades\Route;

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

Route::get('/admin/optimize', [OptimizeController::class, 'optimize']);
Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AuthenticatedSessionController::class, 'create']);
        Route::prefix('dashboard')->group(function () {
            Route::resource('cms-pages', CMSPagesController::class);
        });
        Route::resource('sales', SalesController::class);
        Route::get('get-sub-categories/{catId}', [SalesController::class, 'getSubCategories'])->name('getSubCategories');
        Route::get('get-models/{Id}', [SalesController::class, 'getModels'])->name('getModels');
        Route::resource('banners', BannerController::class);
        Route::resource('promo-codes', PromoCodeController::class);
        Route::resource('admin-langs', AdminLangsController::class);
        Route::resource('admin-users', AdminController::class);
        Route::resource('categories', CategoriesController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('success-stories', SuccessController::class);
        Route::resource('news', NewsController::class);
        Route::resource('users', MasterUserController::class);
        Route::resource('pages', PagesController::class);
        Route::resource('memberships', MembershipController::class);
        Route::resource('advertises', AdvertisementController::class);
        Route::resource('socialicons', ManageSocialController::class);
        Route::resource('seofields', SeoController::class);
        Route::resource('messages', MasterMessageController::class);
        Route::resource('templates', EmailTemplateController::class);
        Route::resource('themes', ThemeController::class);
        Route::resource('locations', MasterLocationController::class);
        Route::resource('upgrade-memberships', UpgradeMembershipController::class);
        Route::resource('credits', CreditController::class);
        Route::resource('reports', ReportsController::class);
        Route::resource('sellers', SellerController::class);
        Route::resource('request-parts', RequestPartsController::class);
        Route::resource('audit-login', AuditLoginController::class);
        Route::resource('bidoffer', BidOfferController::class);
        Route::resource('saleorder', SalesOrderController::class);
        Route::resource('parkquestion', ParkQuestionController::class);
        Route::resource('requestparts', PartsOrderController::class);
        Route::resource('newsletters', NewsLetterController::class);
        Route::resource('compose-mail', ComposeEmailController::class);
        Route::resource('sent-mail', SentMailController::class);
        Route::resource('logo', ManageLogoController::class);
        Route::post('newsletters/{newsId}/update-status', [NewsLetterController::class, 'updateStatus'])->name('newsletters.update-status');
        Route::get('get-orders/{Id}', [SalesOrderController::class, 'getAllOrders'])->name('getOrders');
        Route::post('bidoffer/{bidId}/update-status', [BidOfferController::class, 'updateStatus'])->name('bidoffer.update-status');
        Route::post('saleorder/{Id}/update-deliverystatus', [SalesOrderController::class, 'updateDeliveryStatus'])->name('saleorder.update-deliverystatus');
        Route::post('saleorder/{Id}/update-status', [SalesOrderController::class, 'updateStatus'])->name('saleorder.update-status');
        Route::post('send-email', [SentMailController::class, 'sendEmail'])->name('admin.send-email');

        Route::get('get-parts/{Id}', [BidOfferController::class, 'showParts'])->name('getParts');
        Route::get('delete-image/{imageId}', [SalesController::class, 'deleteImage'])->name('deleteImage');

        Route::post('sales/{Id}/update-status', [SalesController::class, 'updateStatus'])->name('sales.update-status');
        Route::post('memberships/{memId}/update-status', [MembershipController::class, 'updateStatus'])->name('memberships.update-status');
        Route::post('advertises/{advId}/update-status', [AdvertisementController::class, 'updateStatus'])->name('advertises.update-status');
        Route::post('reports/{qusId}/update-status', [ReportsController::class, 'updateStatus'])->name('reports.update-status');
        Route::post('sellers/{sellId}/update-status', [SellerController::class, 'updateStatus'])->name('sellers.update-status');

        Route::post('request-parts/{partId}/update-status', [RequestPartsController::class, 'updateStatus'])->name('request-parts.update-status');

        Route::post('categories/{catId}/update-status', [CategoriesController::class, 'updateStatus'])->name('categories.update-status');

        Route::post('brands/{catId}/update-status', [BrandController::class, 'updateStatus'])->name('brands.update-status');
        Route::post('brands/update-ordering', [BrandController::class, 'updateOrdering'])->name('brands.update-ordering');

        Route::get('get-cities/{Id}', [LocationController::class, 'getCities'])->name('getCities');

        // Route::get('/dashboard', function () {
        //     return view('dashboard');
        // })->middleware(['auth', 'verified'])->name('dashboard');

        Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');

        Route::get('/latest-members', [DashBoardController::class, 'latestMembers'])->name('dashboard.latest-members');

        Route::get('/latest-orders', [DashBoardController::class, 'latestOrders'])->name('dashboard.latest-orders');

        Route::get('/latest-part-orders', [DashBoardController::class, 'latestPartOrders'])->name('dashboard.latest-part-orders');

        Route::get('get-brands', [BrandController::class, 'getBrands'])->name('getBrands');
        Route::get('get-sales', [SalesController::class, 'getSales'])->name('getSales');

        Route::post('/rotate-image', [SalesController::class, 'rotateImage'])->name('rotate-image');




        // Route::middleware('auth')->group(function () {
        //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        // });
    });
});
require __DIR__ . '/auth.php';
