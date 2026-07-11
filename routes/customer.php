<?php

use App\Http\Controllers\Customer\Auth\RegisterController;
use App\Http\Controllers\Customer\Offer\ContractController;
use App\Http\Controllers\Customer\Offer\OfferController;
use App\Http\Controllers\Customer\Project\ProjectController;
use App\Http\Controllers\Customer\Project\ProjectImplementationController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\DiscountsController;
use App\Http\Controllers\Customer\InspectionController;
use App\Http\Controllers\Customer\NotificationController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/notifications/{id}/seen', [NotificationController::class, 'seen'])->name('notifications.seen');


Route::prefix('project')->as('project.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('create', [ProjectController::class, 'showCreateForm'])->name('create');

    Route::post('create', [ProjectController::class, 'createStepOne']);

    Route::post('update-project-attachment', [ProjectController::class, 'createOrUpdateAttchment'])->name('update.attachment');
    Route::delete('attachment/{id}', [ProjectController::class, 'deleteAttachment'])->name('delete.attachment');

    Route::get('show/{id}', action: [ProjectController::class, 'show'])->name('show');
    Route::get('show-compeleted/{id}', action: [ProjectController::class, 'showCompeleted'])->name('show.compeleted');


    Route::get('edit-project/{id}/{step}', [ProjectController::class, 'viewStep'])->name('edit');
    Route::put('update-project/{id}/{step}', [ProjectController::class, 'updateStep'])->name('update');
    Route::post('update-project-attachment', [ProjectController::class, 'createOrUpdateAttchment'])->name('update.attachment');

    Route::prefix('implementation')->as('implementation.')->group(function () {
        Route::get('/{id}', [ProjectImplementationController::class, 'index'])->name('index');
        Route::get('request-change/{id}', [ProjectImplementationController::class, 'showRequestChangeForm'])->name('request.change');

        Route::post('request-inspection/{id}', [InspectionController::class, 'createStageInspection'])->name('request.inspection');
        Route::get('/accept-payment/{id}/{itemId}', [ProjectImplementationController::class , 'acceptStagePayment'])->name('accept.payment');
    });

    Route::get('download-file/{id}' , [ProjectController::class , 'downloadFile'])->name('downlaod.file');
});

Route::prefix('offers')->as('offer.')->group(function () {
    Route::get('/{id}', [OfferController::class, 'index'])->name('index');
});


Route::prefix('payments')->as('payments.')->group(function(){
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::get('{id}/download', [PaymentController::class, 'download'])->name('download');
    Route::get('{id}', [PaymentController::class, 'show'])->name('show');
});

Route::prefix('inspection')->as('inspection.')->group(function () {
    // Route::get('report/{id}' , [InspectionController::class , 'report'])->name('report');
    Route::put('unpdate/{id}', [InspectionController::class, 'update'])->name('update');
    Route::get('show/{id}', [InspectionController::class, 'show'])->name('show');
});

Route::prefix('contract')->as('contract.')->group(function () {
    Route::match(['get', 'post'], 'sign/{id}', [ContractController::class, 'sign'])->name('sign');
    Route::post('verify-mobile', [ContractController::class, 'verifyMobile'])->name('verify.mobile');
    Route::post('sign', [ContractController::class, 'compeleteSign'])->name('compelete.sign');
});

Route::prefix('payment')->as('payment.')->group(function () {
    Route::post('deposite-payment', [PaymentController::class, 'depositePayment'])->name('deposite.payment');
});
Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    // Route::get('/{id}', [NotificationController::class, 'show'])->name('show');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('markAllRead');
});

Route::prefix('rate')->name('rate.')->group(function () {
    Route::get('create/{id}', [RatingController::class, 'create'])->name('create');
    Route::post('store/{id}', [RatingController::class, 'store'])->name('store');
    // Route::get('/{id}', [NotificationController::class, 'show'])->name('show');
});

Route::prefix('discounts')->name('discounts.')->group(function () {
    Route::get('/' , [DiscountsController::class , 'index'])->name('index');
});


Route::prefix('profile')->as('profile.')->group(function(){
Route::get("/" , [ProfileController::class , "index"])->name("index");
Route::post("update-profile" , [ProfileController::class , "updateProfile"])->name('update.profile');

});

Route::post('save-fcm-token', function (Request $request) {
    $user = auth('customer')->user(); // Or however you're authenticating

    $request->validate([
        'token' => 'required|string',
    ]);

    $user->fcm_token = $request->token;
    $user->save();

    return response()->json(['status' => 'success']);
});



