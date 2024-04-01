<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CmsPagesController;
use App\Http\Controllers\Api\CompanyPartsController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RequestPartsController;
use App\Http\Controllers\Api\SalesController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TruckPartsController;
use App\Http\Controllers\Api\UserDashBoardController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\PostAdsController;
use App\Http\Controllers\Api\AskQuestionController;
use App\Http\Controllers\Api\FavoritesController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\SalesParksController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\PromoCodeController;
use App\Http\Controllers\Api\SalesWarrantyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth.bearer')->group(function () {

    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('updatePass', [UserController::class, 'updatePass']);
    // CMS PAGES
    Route::get('cmsPages/{id}', [CmsPagesController::class, 'cmsPageDetails']);
    Route::get('homePages', [CmsPagesController::class, 'homePageDetails']);
    Route::get('homePagesPartTwo', [CmsPagesController::class, 'homePagePartTwo']);
    Route::get('countries', [LocationController::class, 'getCountries']);
    Route::get('get-cities/{Id}', [LocationController::class, 'getCities']);
    Route::post('brands-list', [BrandController::class, 'BrandsList']);
    Route::post('piese-auto', [SalesController::class, 'getSalesProducts']);
    Route::get('categories/{paginate?}', [CategoryController::class, 'getCategories']);
    Route::get('sales-details/{slug?}', [SalesController::class, 'getProductDetails']);
    Route::get('related-products/{id}', [SalesController::class, 'relatedProducts']);
    Route::post('request-parts', [RequestPartsController::class, 'index']);
    Route::get('request-parts/addQuestions', [RequestPartsController::class, 'addQuestions']);
    Route::post('request-parts/offerStore', [RequestPartsController::class, 'offerStore']);
    Route::get('request-parts/{slug}', [RequestPartsController::class, 'requestPartsDetails']);
    Route::get('get-sub-categories/{catId}', [SalesController::class, 'getSubCategories']);
    Route::get('get-models/{Id}', [SalesController::class, 'getModels']);
    Route::get('all-categories', [SalesController::class, 'getAllCategories']);
    Route::get('all-brands', [SalesController::class, 'getAllBrands']);
    Route::get('truck-parks', [TruckPartsController::class, 'index']);
    Route::get('truck-parks/{id}', [TruckPartsController::class, 'show']);
    Route::get('company-parts', [CompanyPartsController::class, 'index']);
    Route::get('company-parts/{id}', [CompanyPartsController::class, 'show']);
    Route::post('/ratings', [UserProfileController::class, 'index']);
    Route::get('get-sku', [SalesController::class, 'getSku']);
    Route::post('apply-promo-code', [PromoCodeController::class, 'apply']);

    // API's created by Santosh Kumar Sahoo
    Route::get('/user-list', [UserDashBoardController::class, 'userList'])->name('user.List');
    Route::get('recent-piese-auto', [SalesController::class, 'recentPieseAuto']);
    // API's created by Santosh Kumar Sahoo
    Route::get('/recent-company-spare-parts/{slug}', [RequestPartsController::class, 'recent_company_spare_parts']);
});





// CMS PAGES

// Protected Routes
Route::middleware('auth:api')->group(function () {
    Route::post('sales-ad/store', [SalesController::class, 'publishAdstore']);
    Route::get('/edit-ad/{id}', [SalesController::class, 'editAd']);
    Route::post('request-parts/store', [RequestPartsController::class, 'store']);
    Route::get('user-details/{id}', [UserController::class, 'userDetails']);
    Route::get('refresh', [UserController::class, 'refresh']);
    Route::post('updateProfile', [UserController::class, 'updateProfile']);
    Route::get('my-request-parts/{userid}', [UserController::class, 'myRequestParts']);
    Route::get('my-purchases/{userid}', [UserController::class, 'myPurchases']);
    Route::get('my-questions/{userid}', [UserController::class, 'myQuestions']);
    Route::post('piese-auto/{userid}', [SalesController::class, 'getSalesProducts']);
    Route::get('ask-questions/{userid}', [UserController::class, 'askQuestion']);
    Route::get('ask-questions-replies/{questionId}', [UserController::class, 'replies']);

    // API's created by Santosh Kumar Sahoo
    Route::get('/accounts-credits/{userid}', [UserDashBoardController::class, 'accountCredits'])->name('account.credits');
    Route::get('/accounts-history/{userid}', [UserDashBoardController::class, 'accountHistory'])->name('account.history');
    Route::get('/upgrade-member', [UserDashBoardController::class, 'upgradeMember'])->name('upgrade.member');
    Route::post('/membership-plan', [UserDashBoardController::class, 'membershipPlan'])->name('membership.plan');
    Route::post('/confirm-membership-plan', [UserDashBoardController::class, 'membershipConfirmPlan'])->name('membership.confirm.plan');
    Route::get('/rating-given-buyer/{userid}', [UserDashBoardController::class, 'ratingGivenBuyer'])->name('rating.given.buyer');
    Route::get('/rating-given-seller/{userid}', [UserDashBoardController::class, 'ratingGivenSeller'])->name('rating.given.seller');
    Route::get('/message-inbox/{userid}', [UserDashBoardController::class, 'messageInbox'])->name('message.inbox');
    Route::post('/reply-message', [UserDashBoardController::class, 'replyMessage'])->name('reply.message');
    Route::get('/sent-message/{userid}', [UserDashBoardController::class, 'sentMessage'])->name('sent.message');
    Route::get('/archive-message/{userid}', [UserDashBoardController::class, 'archiveMessage'])->name('archive.message');
    Route::get('/email-history/{userid}', [UserDashBoardController::class, 'emailHistory'])->name('email.history');
    Route::post('/compose-message', [UserDashBoardController::class, 'composeMessage'])->name('compose.message');
    Route::get('/my-rating/{userid}', [UserDashBoardController::class, 'myRating'])->name('my.rating');
    Route::get('/success-stories-list/{userid}', [UserDashBoardController::class, 'successStoriesList'])->name('success.stories.list');
    Route::post('/add-success-story', [UserDashBoardController::class, 'addSuccessStory'])->name('add.success.story');
    Route::get('/edit-success-story/{storyId}', [UserDashBoardController::class, 'editSuccessStory'])->name('edit.success.story');
    Route::post('/update-success-story', [UserDashBoardController::class, 'updateSuccessStory'])->name('update.success.story');
    // API's created by Santosh Kumar Sahoo


    Route::post('/orders', [OrderController::class, 'Order']);


    // Created by - Amlan Kumar Nayak (Music MG)
    // Date - 05-03-2024
    Route::post('/change-password', [UserController::class, 'changePassword']);
    Route::post('/change-email-address', [UserController::class, 'changeEmailAddress']);
    Route::post('/auto-parts-request', [UserController::class, 'auto_parts_request']);
    Route::get('/show-auto-parts-request/{userid}', [UserController::class, 'show_auto_parts_request']);


    // Route::get('index/{userid}', [SalesParksController::class, 'index']);

    Route::post('/out-of-stock', [OrderController::class, 'outOfStock']);
    Route::post('/delete-ad', [PostAdsController::class, 'deleteAd']);
    Route::post('/promoted-ad', [PostAdsController::class, 'promotedAd']);
    Route::post('/question-asked', [AskQuestionController::class, 'askQuestion']);

    Route::post('/sent-question/{id}', [AskQuestionController::class, 'sentQuestion']);
    Route::post('/view-ask-reply/{id}', [AskQuestionController::class, 'viewAskReply']);

    Route::post('/answer-the-question', [AskQuestionController::class, 'answerTheQuestion']);

    Route::post('/sale-details', [SalesController::class, 'saleDetails']);
    Route::post('/add-to-fav', [FavoritesController::class, 'index']);
    Route::post('/most-viewed', [FavoritesController::class, 'mostViewed']);
    Route::post('/favorites', [FavoritesController::class, 'favorites']);
    Route::post('/is-favorite', [FavoritesController::class, 'isFavorite']);
    Route::post('/favorites-ads', [FavoritesController::class, 'favoritesAds']);
    Route::post('/rate-product', [SalesController::class, 'rateProduct']);

    Route::get('/rating-receive-buyer/{id}', [RatingController::class, 'ratingReceiveBuyer']);

    Route::get('/question-rec/{userid}', [SalesParksController::class, 'questionRec']);
    Route::get('/sent-question/{userid}', [SalesParksController::class, 'sentQuestion']);

    Route::get('/offer-losing', [RequestPartsController::class, 'offerLosing']);
    Route::post('/active-sale', [SalesController::class, 'activate_sale']);

    //Api for SalesParks
    Route::get('truck-parks-list/{userid}', [SalesParksController::class, 'index']);
    Route::post('/delete-truck-parks', [SalesParksController::class, 'deleteTruckPark']);
    //Api for Companypieces
    Route::get('companypieces-list/{userid}', [SalesParksController::class, 'companyPiecesList']);
    Route::post('/delete-companypieces', [SalesParksController::class, 'deleteCompanyPieces']);

    //Carts
    Route::post('/add-to-cart', [CartController::class, 'store']);
    Route::post('/update-cart', [CartController::class, 'update']);
    Route::post('/carts', [CartController::class, 'lists']);
    Route::delete('/delete-cart/{id}', [CartController::class, 'destroy']);


    Route::get('/ask-seller/{userid}', [RequestPartsController::class, 'askSeller']);
    Route::get('/ask-seller-sent/{userid}', [RequestPartsController::class, 'askSellerSent']);

    Route::get('/my-question-reply/{question_id}', [RequestPartsController::class, 'myQuestionReply']);

    Route::post('/sales-warranty-store', [SalesWarrantyController::class, 'store']);

    Route::post('save-order', [OrderController::class, 'store']);
});
// Protected Routes End
