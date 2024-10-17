<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CmsPagesController;
use App\Http\Controllers\Api\CompanyPartsController;
use App\Http\Controllers\Api\IpcartController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\NoticeController;
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
use App\Http\Controllers\Api\ForgotPwController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\PromoCodeController;
use App\Http\Controllers\Api\SalesWarrantyController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\NewsLetterController;
use App\Http\Controllers\Api\AdminLangController;
use App\Http\Controllers\Api\FeaturedSectionController;
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
    Route::get('get-featured-content', [FeaturedSectionController::class, 'getFeaturedContent']);

    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('updatePass', [UserController::class, 'updatePass']);
    Route::post('forgot-password-api', [ForgotPwController::class, 'forgotPasswordSendMail']);
    Route::post('reset-password', [ForgotPwController::class, 'resetPassword']);
    // CMS PAGES
    Route::get('cmsPages/{id}', [CmsPagesController::class, 'cmsPageDetails']);
    Route::get('homePages', [CmsPagesController::class, 'homePageDetails']);
    Route::get('homePagesPartTwo', [CmsPagesController::class, 'homePagePartTwo']);
    Route::get('footer-categories', [CmsPagesController::class, 'footerCategories']);
    Route::get('footer-brands', [CmsPagesController::class, 'footerBrands']);
    Route::get('countries', [LocationController::class, 'getCountries']);
    Route::get('get-cities/{Id}', [LocationController::class, 'getCities']);
    Route::post('brands-list', [BrandController::class, 'BrandsList']);
    Route::post('piese-auto', [SalesController::class, 'getSalesProducts']);
    Route::post('/autocomplete', [SalesController::class, 'autoComplete']);
    Route::get('categories/{paginate?}', [CategoryController::class, 'getCategories']);
    Route::get('sales-details/{slug?}', [SalesController::class, 'getProductDetails']);
    Route::get('related-products/{id}', [SalesController::class, 'relatedProducts']);
    Route::post('request-parts', [RequestPartsController::class, 'index']);
    Route::post('request-parts/addQuestions', [RequestPartsController::class, 'addQuestions']);
    Route::get('request-questions-list/{request_id}', [RequestPartsController::class, 'questionsList']);
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

    Route::get('/pages/{pageId}', [PagesController::class, 'Pages']);
    Route::post('/carts', [CartController::class, 'lists']);
    Route::get('/sales-questions-list/{adv_id}', [AskQuestionController::class, 'index']);
    Route::get('/park-questions-list/{adv_id}', [TruckPartsController::class, 'questionsList']);
    Route::get('/user-notices/{user_id}', [NoticeController::class, 'getUserNoticeData'])->name('user-notices');
    Route::get('/clear-notifications/{user_id}', [NoticeController::class, 'clearNotication']);
    Route::get('/read-notification/{notice_id}', [NoticeController::class, 'readNotification']);


    Route::post('get-relatedProduct/', [SalesController::class, 'getRelatedProduct']);
    Route::post('store-recent-view/', [SalesController::class, 'storeRecentView']);

    Route::post('/cart-sync', [CartController::class, 'cartSync']);
    Route::get('cms-pages/{id}', [CmsPagesController::class, 'getData'])->name('cms-pages.getData');
    Route::get('/trade-statistics', [CmsPagesController::class, 'getCounts']);

    Route::post('/newsletter', [NewsLetterController::class, 'store']);
    Route::get('/newsletter/confirm/{id}', [NewsLetterController::class, 'confirm'])->name('newsletter.confirm');

    Route::get('/lang/{language}', [AdminLangController::class, 'getLanguageLabels']);


    // offlineCart
    Route::post('/ip-carts', [IpcartController::class, 'lists']);
    Route::post('/add-to-cart-ip', [IpcartController::class, 'store']);
    Route::post('/update-cart-ip', [IpcartController::class, 'update']);
    Route::post('/empty-cart-ip', [IpcartController::class, 'emptyCart']);
    Route::post('/delete-cart-ip/{id}', [IpcartController::class, 'destroy']);
    // offlineCart


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
    Route::post('/change-password-confirm', [UserController::class, 'confirmPwChange']);
    Route::post('/change-password', [UserController::class, 'changePassword']);
    Route::post('/change-email-address', [UserController::class, 'changeEmailAddress']);
    Route::post('/auto-parts-request', [UserController::class, 'auto_parts_request']);
    Route::get('/show-auto-parts-request/{userid}', [UserController::class, 'show_auto_parts_request']);


    // Route::get('index/{userid}', [SalesParksController::class, 'index']);

    Route::get('/out-of-stock/{userid}', [OrderController::class, 'outOfStock']);
    Route::get('/delete-ad/{userid}', [PostAdsController::class, 'deleteAd']);
    Route::get('/promoted-ad/{userid}', [PostAdsController::class, 'promotedAd']);
    Route::post('/question-asked', [AskQuestionController::class, 'askQuestion']);

    Route::get('/sent-questions/{id}', [AskQuestionController::class, 'sentQuestions']);
    Route::get('/view-ask-reply/{id}', [AskQuestionController::class, 'viewAskReply']);

    Route::post('/answer-the-question', [AskQuestionController::class, 'answerTheQuestion']);

    Route::post('/sale-details', [SalesController::class, 'saleDetails']);
    Route::post('/add-to-fav', [FavoritesController::class, 'store']);
    Route::get('/most-viewed/{id}', [FavoritesController::class, 'mostViewed']);
    Route::get('/favorites/{id}', [FavoritesController::class, 'favorites']);
    Route::post('/is-favorite', [FavoritesController::class, 'isFavorite']);
    Route::get('/favorites-ads/{id}', [FavoritesController::class, 'favoritesAds']);
    Route::post('/rate-product', [SalesController::class, 'rateProduct']);

    Route::get('/rating-receive-buyer/{id}', [RatingController::class, 'ratingReceiveBuyer']);
    Route::get('/rating-receive-seller/{id}', [RatingController::class, 'ratingReceiveSeller']);

    Route::get('/question-rec/{userid}', [SalesParksController::class, 'questionRec']);
    Route::get('/sent-question/{userid}', [SalesParksController::class, 'sentQuestion']);

    Route::get('/offer-losing/{userid}', [RequestPartsController::class, 'offerLosing']);
    Route::get('/offer-active/{userid}', [RequestPartsController::class, 'offerActive']);
    Route::get('/offer-inactive/{userid}', [RequestPartsController::class, 'offerInActive']);
    Route::post('/active-sale', [SalesController::class, 'activate_sale']);

    //Api for SalesParks
    Route::get('truck-parks-list/{userid}', [SalesParksController::class, 'index']);
    Route::post('/delete-truck-parks', [SalesParksController::class, 'deleteTruckPark']);
    Route::post('/add-truckpart', [SalesParksController::class, 'store']);
    Route::get('/edit-truckpart/{id}', [SalesParksController::class, 'edit']);
    Route::post('/update-truckpart', [SalesParksController::class, 'update']);
    //Api for Companypieces
    Route::get('companypieces-list/{userid}', [SalesParksController::class, 'companyPiecesList']);
    Route::post('/delete-companypieces', [SalesParksController::class, 'deleteCompanyPieces']);

    //Carts
    Route::post('/add-to-cart', [CartController::class, 'store']);
    Route::post('/update-cart', [CartController::class, 'update']);
    Route::post('/empty-cart', [CartController::class, 'emptyCart']);
    Route::post('/delete-cart/{id}', [CartController::class, 'destroy']);




    Route::get('/ask-seller/{userid}', [RequestPartsController::class, 'askSeller']);
    Route::get('/ask-seller-sent/{userid}', [RequestPartsController::class, 'askSellerSent']);

    Route::get('/request-question/{userid}', [RequestPartsController::class, 'requestQuestion']);
    Route::post('/delete-request-question', [RequestPartsController::class, 'deleteRequestQuestion']);

    Route::get('/offer-my-request/{userid}', [RequestPartsController::class, 'offerMyRequest']);

    Route::get('/parts-order/{userid}', [RequestPartsController::class, 'partsOrder']);

    Route::post('/sales-warranty-store', [SalesWarrantyController::class, 'store']);

    Route::post('save-order', [OrderController::class, 'store']);
    Route::get('/dlt-inbox-msg/{msgId}', [UserDashBoardController::class, 'deleteInboxMsg']);
    Route::post('/add_reply', [RequestPartsController::class, 'add_reply']);
    Route::get('/view_reply/{qid}', [RequestPartsController::class, 'view_reply']);

    Route::get('/fetch-buyer-rating/{orderId}', [UserDashBoardController::class, 'fetchBuyerRating'])->name('fetchBuyerRating');

    Route::post('/save-buyer-rating', [UserDashBoardController::class, 'saveBuyerRating'])->name('saveBuyerRating');

    Route::get('/fetch-seller-rating/{orderId}', [UserDashBoardController::class, 'fetchSellerRating'])->name('fetchSellerRating');

    Route::post('/save-seller-rating', [UserDashBoardController::class, 'saveSellerRating'])->name('saveSellerRating');
    Route::post('/delete-advertisement', [SalesController::class, 'deleteAdvertisement']);

    Route::post('/supply-demand', [RequestPartsController::class, 'supplyDemand']);
    Route::post('/delete-request-part', [RequestPartsController::class, 'deleteRequestPart']);
    Route::post('/request-parts-update/{id}', [RequestPartsController::class, 'update']);


    Route::post('/add-sales-questions', [AskQuestionController::class, 'addSalesQuestion']);

    Route::post('/savewishlist', [WishlistController::class, 'store']);
    // Route::post('/empty-wishlist', [WishlistController::class, 'emptyWishlist']);
    Route::post('/delete-wishlist', [WishlistController::class, 'destroy']);
    Route::post('/wishlist', [WishlistController::class, 'lists']);
    Route::post('/add-truck-ques', [TruckPartsController::class, 'addParkQuestion']);
});
// Protected Routes End
