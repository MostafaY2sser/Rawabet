<?php

use App\Http\Controllers\Provider\DashboardController;
use App\Http\Controllers\Provider\DiscountsController;
use App\Http\Controllers\Provider\Offer\OfferController;
use App\Http\Controllers\Provider\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Provider\Project\ProjectController;
use App\Http\Controllers\Provider\NotificationController;
use App\Http\Controllers\Provider\ProfileController;
use App\Http\Controllers\Provider\Project\ProjectImplementationController;
use App\Http\Controllers\Provider\RatingController;
use Illuminate\Http\Request;

Route::get('dashboard' , [DashboardController::class,'index'])->name('dashboard');
Route::get('/notifications/{id}/seen', [NotificationController::class, 'seen'])->name('notifications.seen');


Route::prefix('project')->as('project.')->group(function () {

    Route::get('/',  [ProjectController::class,'index'])->name('index');
    Route::get('/in-progress',  [ProjectController::class,'inProgressProjects'])->name('in.progress');

    Route::get('show/{id}' , [ProjectController::class , 'show'])->name('show');
    Route::get('download-file/{id}' , [ProjectController::class , 'downloadFile'])->name('download.file');


    Route::prefix('implementation')->as('implementation.')->group(function () {
        Route::get('/{id}' , [ProjectImplementationController::class , 'index'])->name('index');
        Route::get('update-progress/{id}' , [ProjectImplementationController::class , 'showUpdateProgressFrom'])->name('update.progress');
        Route::post('update-progress/{id}' , [ProjectImplementationController::class , 'updateProgress'])->name('update.progress.submit');

    });

});

Route::prefix('offers')->as('offers.')->group(function(){
    Route::get('create/{id}' , [OfferController::class , 'create'])->name('create');
    Route::post('store/{id}', [OfferController::class , 'store'])->name('store');
    Route::get('index' , [OfferController::class , 'index'])->name('index');
    Route::get('show/{id}', [OfferController::class ,'show'])->name('show');
});

Route::prefix('profile')->as('profile.')->group(function(){
Route::get("/" , [ProfileController::class , "index"])->name("index");
Route::post("add-file" , [ProfileController::class , "addFile"])->name('add.file');
Route::get("preview-file/{id}" , [ProfileController::class , "previewFile"])->name('preview.file');
Route::get("download-file/{id}" , [ProfileController::class , "downloadFile"])->name('download.file');
Route::post("update-profile" , [ProfileController::class , "updateProfile"])->name('update.profile');

});

Route::middleware(['auth:provider'])->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    // Route::get('/{id}', [NotificationController::class, 'show'])->name('show');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('markAllRead');
});

Route::prefix('payments')->as('payments.')->group(function(){
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::get('{id}/download', [PaymentController::class, 'download'])->name('download');
    Route::get('{id}', [PaymentController::class, 'show'])->name('show');
});


Route::prefix('discounts')->name('discounts.')->group(function () {
    Route::get('/' , [DiscountsController::class , 'index'])->name('index');
});

Route::prefix('rate')->name('rate.')->group(function () {
    Route::get('create/{id}', [RatingController::class, 'create'])->name('create');
    Route::post('store/{id}', [RatingController::class, 'store'])->name('store');
    // Route::get('/{id}', [NotificationController::class, 'show'])->name('show');
});




Route::post('save-fcm-token', function (Request $request) {
    $user = auth('provider')->user(); // Or however you're authenticating

    $request->validate([
        'token' => 'required|string',
    ]);

    $user->fcm_token = $request->token;
    $user->save();

    return response()->json(['status' => 'success']);
});

