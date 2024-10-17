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
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BidOfferController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\ParkQuestionController;
use App\Http\Controllers\PartsOrderController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\ComposeEmailController;
use App\Http\Controllers\SentMailController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\FeaturedSectionController;
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
        Route::resource('cms-pages', CMSPagesController::class);
        Route::resource('feature-section', FeaturedSectionController::class);
        Route::resource('sales', SalesController::class);
        Route::get('get-sub-categories/{catId}', [SalesController::class, 'getSubCategories'])->name('getSubCategories');
        Route::get('get-models/{Id}', [SalesController::class, 'getModels'])->name('getModels');
        Route::resource('banners', BannerController::class);
        Route::resource('promo-codes', PromoCodeController::class);
        Route::resource('admin-langs', AdminLangsController::class);
        Route::get('admin-langs/convert', [AdminLangsController::class, 'convert']);
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


        Route::get('expirepromote', [SalesController::class, 'expirePromote'])->name('expirepromote');
        Route::post('delete-expirepromote', [SalesController::class, 'deleteExpirepromote'])->name('delete-expirepromote');
        Route::get('usercredits', [SalesController::class, 'userCredits'])->name('usercredits');
        Route::post('autocomplete', [SalesController::class, 'autoComplete'])->name('autocomplete');
        Route::get('add-credit', [SalesController::class, 'addCredit'])->name('add-credit');
        Route::post('save-credit', [SalesController::class, 'saveCredit'])->name('save-credit');
        //Edit Profile
        Route::get('edit-profile/{id}', [AdminController::class, 'editProfile'])->name('edit-profile');
        Route::post('profile-update/{id}', [AdminController::class, 'updateprofile'])->name('profile-update');

        //Change Password
        Route::get('change-password/{id}', [AdminController::class, 'passwordEdit'])->name('change-password');
        Route::post('password-update/{id}', [AdminController::class, 'passwordUpdate'])->name('password-update');
        Route::post('admin-password-update', [PasswordController::class, 'Update'])->name('admin-password-update');

        Route::post('/notice/status', [AdminController::class, 'noticeStatus'])->name('notice.status');
        Route::post('/notice/status/all', [AdminController::class, 'noticeStatusAll'])->name('notice.status.all');
        Route::get('/export-users', [MasterUserController::class, 'exportUsersToCsv'])->name('export.users');
        Route::post('users/{userId}/update-status', [MasterUserController::class, 'updateStatus'])->name('users.update-status');
        Route::post('users/{userId}/update-password', [MasterUserController::class, 'updatePassword'])->name('users.update-password');
        Route::post('users/upgrademember/{uid}', [MasterUserController::class, 'upgrademember'])->name('users.upgrademember');
        Route::get('users/rating/{id}', [MasterUserController::class, 'showRatings'])->name('users.rating');
        Route::post('newsletters/resend/{id}', [NewsLetterController::class, 'newsletterResend'])->name('newsletters.resend');
        Route::get('/confirm_email/{id}', [NewsLetterController::class, 'confirmEmail'])->name('confirm_email');
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
        Route::get('/delete-all-slug', [CategoriesController::class, 'deleteAllSlugs'])->name('categories.delete-all-slug');
        Route::get('/generate-all-slug', [CategoriesController::class, 'generateSlugsForAll'])->name('categories.generate-all-slug');
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
        // Route::get('/deleteDuplicateEntries', [RequestPartsController::class, 'deleteDuplicateEntries']);
        Route::get('/get-subbrand', [SalesController::class, 'getSubbrand'])->name('subbrand');
        Route::get('/get-subcat', [SalesController::class, 'getSubcat'])->name('subcat');
        Route::get('/export-sales', [SalesController::class, 'exportSalesToCsv'])->name('export.sales');


        Route::get('/backups', [BackupController::class, 'index'])->name('backup.index');
        Route::post('/backups/create', [BackupController::class, 'createBackup'])->name('backup.create');
        Route::post('/backups/restore', [BackupController::class, 'restoreBackup'])->name('backup.restore');
        Route::post('/backups/delete', [BackupController::class, 'deleteBackup'])->name('backup.delete');
        Route::get('/backups/download/{filename}', [BackupController::class, 'downloadBackup'])->name('backup.download');


        Route::get('get-locations', [MasterLocationController::class, 'getLocations'])->name('getLocations');


        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::patch('/profile-image', [ProfileController::class, 'profileImageUpdate'])->name('profile-image.update');
        });
    });
});
require __DIR__ . '/auth.php';
