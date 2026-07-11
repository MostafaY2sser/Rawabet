<?php

use App\Http\Controllers\Admin\Customers\CustomerController;
use App\Http\Controllers\Admin\Inspections\InspectionController;
use App\Http\Controllers\Admin\Inspections\StageInspectionController;
use App\Http\Controllers\Admin\Offer\OfferController;
use App\Http\Controllers\Admin\Project\ProjectController;
use App\Http\Controllers\Admin\Providers\ProvidersController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\Project\ReportController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\Reference\CategoriesController;
use App\Http\Controllers\Admin\Reference\CityController;
use App\Http\Controllers\Admin\Reference\ProjectTypesController;
use App\Http\Controllers\Admin\Reference\RegionController;
use App\Http\Controllers\Admin\Reference\SpecialtyController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\Partners\PartnersController;
use App\Http\Controllers\Admin\Partners\PartnersDiscountsController;
use App\Http\Controllers\Admin\Partners\PartnersSectionsController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('customers')->as('customers.')->group(function () {
    Route::prefix('requests')->as('requests.')->group(function () {
        Route::get('/', [CustomerController::class, 'requests'])->name('index');
        Route::get('edit/{id}', [CustomerController::class, 'edit'])->name('edit');

        Route::post('update-status/{id}', [CustomerController::class, 'updateStatus'])->name('update.status');
    });
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('show');
});

Route::prefix('providers')->as('providers.')->group(function () {
    Route::prefix('requests')->as('requests.')->group(function () {
        Route::get('/', [ProvidersController::class, 'requests'])->name('index');
        Route::get('edit/{id}', [ProvidersController::class, 'edit'])->name('edit');

        Route::post('update-status/{id}', [ProvidersController::class, 'updateStatus'])->name('update.status');
    });
    Route::get('/', [ProvidersController::class, 'index'])->name('index');
    Route::get('/{id}', [ProvidersController::class, 'show'])->name('show');
});

Route::prefix('projects')->as('projects.')->group(function () {
    Route::prefix('pending')->as('pending.')->group(function () {
        Route::get('/', [ProjectController::class, 'pendingProjects'])->name('index');
        Route::get('edit/{id}', [ProjectController::class, 'editPendingProject'])->name('edit');

        Route::post('update-status/{id}', [ProjectController::class, 'updateStatus'])->name('update.status');
        Route::post('update-consultant/{id}', [ProjectController::class, 'updateConsultant'])->name('update.consultant');
    });
    Route::prefix('active')->as('active.')->group(function () {
        Route::get('/', [ProjectController::class, 'activeProjects'])->name('index');
        Route::get('edit/{id}', [ProjectController::class, 'editActiveProject'])->name('edit');
        Route::get('work-stages/{id}', [ProjectController::class, 'showWorkStages'])->name('workstages');
    });
    Route::prefix('completed')->as('completed.')->group(function () {
        Route::get('/', [ProjectController::class, 'completedProjects'])->name('index');
        Route::get('show/{id}', [ProjectController::class, 'showCompletedProject'])->name('show');
    });
   

     Route::prefix('reports')->as('reports.')->group(function(){
        Route::get('create-report/{id}', [ReportController::class , 'create'])->name('create');
        Route::post('store-report/{id}', [ReportController::class , 'store'])->name('store');
    });
        Route::get('preview-file/{id}', [ProjectController::class, 'previewFile'])->name('preview.file');
        Route::get('download-file/{id}' , [ProjectController::class , 'downloadFile'])->name('downlaod.file');
        Route::post('provider-scope/{id}', [ProjectController::class, 'updateProviderScope'])->name('provider.scope.update');


 
});

Route::prefix('inspection')->as('inspection.')->group(function () {
    Route::get('/', [InspectionController::class, 'index'])->name('index');
    Route::post('schedule/{id}', [InspectionController::class, 'assignInspector'])->name('schedule');
    Route::get('edit/{id}', [InspectionController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [InspectionController::class, 'update'])->name('update');
    Route::get('create-report/{id}', [InspectionController::class, 'createReport'])->name('create.report');
    Route::post('store-report/{id}', [InspectionController::class, 'storeReport'])->name('store.report');
    Route::get('show-report/{id}', [InspectionController::class, 'showReport'])->name('show.report');

    Route::get('create-stage-inspection/{id}', [StageInspectionController::class, 'create'])->name('create.stage.inspection');
    Route::post('store-stage-report/{id}', [StageInspectionController::class, 'storeReport'])->name('store.stage.report');
    Route::get('show-stage-report/{id}', [StageInspectionController::class, 'showReport'])->name('show.stage.report');
});

Route::prefix('offers')->as('offers.')->group(function () {

    Route::prefix('pending')->as('pending.')->group(function () {
        Route::get('/', [OfferController::class, 'pendingOffers'])->name('index');
        Route::get('edit/{id}', [OfferController::class, 'edit'])->name('edit');
        Route::post('approve/{id}', [OfferController::class, 'approve'])->name('approve');
        Route::post('draft/{id}', [OfferController::class, 'draftPending'])->name('draft');
        // Route::post('update-status/{id}', [OfferController::class, 'updateStatus'])->name('update.status');
        Route::prefix('{offer}')->group(function () {
            Route::put('payment-schedules', [OfferController::class, 'updatePaymentSchedules'])
                ->name('paymentSchedules.update');
            Route::get('additional-services', [OfferController::class, 'showAdditionalServices'])
                ->name('additionalServices.index');
            Route::post('additional-services', [OfferController::class, 'storeAdditionalServices'])
                ->name('additionalServices.store');
        });
    });



    Route::prefix('active')->as('active.')->group(function () {
        Route::get('/' , [OfferController::class , 'activeOffers'])->name('index');
        Route::get('/show/{id}' , [OfferController::class , 'showActiveOffer'])->name('show');
        Route::get('update-progress/{id}', [Offercontroller::class, 'showUpdateProgressFrom'])->name('update.progress');
        Route::post('update-progress/{id}', [Offercontroller::class, 'updateProgress'])->name('update.progress.submit');
    });
    Route::prefix('compeleted')->as('compeleted.')->group(function () {
        Route::get('/' , [OfferController::class , 'compeletedOffers'])->name('index');
        Route::get('/show/{id}' , [OfferController::class , 'showcompeletedOffer'])->name('show');
        
    });
    Route::prefix('drafted')->as('drafted.')->group(function () {
        Route::get('/', [OfferController::class, 'draftedOffers'])->name('index');
        Route::post('restore/{id}', [OfferController::class, 'restoreDraft'])->name('restore');
        Route::post('delete/{id}', [OfferController::class, 'deleteDraft'])->name('delete');
    });


    
   
    

});

Route::prefix('ratings')->as('ratings.')->group(function(){
        Route::prefix('providers')->as('providers.')->group(function(){
            Route::get('/' , [RatingController::class , 'providersRatings'])->name('index');
            Route::get('show/{id}' , [RatingController::class , 'showProvidersRatings'])->name('show');
        });
        Route::prefix('customers')->as('customers.')->group(function(){
            Route::get('/' , [RatingController::class , 'customersRatings'])->name('index');
            Route::get('show/{id}' , [RatingController::class , 'showCustomersRatings'])->name('show');
        });
    });

    Route::prefix('users')->as('users.')->group(function(){
        Route::get('/' , [UsersController::class , 'index'])->name('index');
        Route::get('/create', [UsersController::class , 'create'])->name('create');
        Route::get('/edit/{id}', [UsersController::class , 'edit'])->name('edit');
        Route::post('/store', [UsersController::class , 'store'])->name('store');
        Route::put('/update/{id}', [UsersController::class , 'update'])->name('update');
    });
    Route::prefix('roles')->as('roles.')->group(function(){
        Route::get('/' , [RolesController::class , 'index'])->name('index');
        Route::get('/edit/{id}' , [RolesController::class , 'edit'])->name('edit');
        Route::put('/update/{id}' , [RolesController::class , 'update'])->name('update');
    });


    Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationsController::class, 'index'])->name('index');
    // Route::get('/{id}', [NotificationController::class, 'show'])->name('show');
    Route::post('/mark-all-read', [NotificationsController::class, 'markAllRead'])->name('markAllRead');
    Route::get('/{id}/seen', [NotificationsController::class, 'seen'])->name('seen');

});

Route::prefix('reference')->as('reference.')->group(function () {
    Route::resource('cities', CityController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('regions', RegionController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('specialties', SpecialtyController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('categories', CategoriesController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('project-types', ProjectTypesController::class)->only(['index', 'store', 'update', 'destroy']);
});

Route::prefix('partners')->as('partners.')->group(function(){
    Route::resource('partners' , PartnersController::class);
    Route::resource('sections' , PartnersSectionsController::class);
    Route::resource('discounts' , PartnersDiscountsController::class);
});

Route::prefix('settings')->as('settings.')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->middleware('can:view settings')->name('index');
    Route::post('/update', [SettingsController::class, 'update'])->middleware('can:edit settings')->name('update');
    Route::post('/test-email', [SettingsController::class, 'sendTestEmail'])->middleware('can:edit settings')->name('test.email');
});



Route::post('save-fcm-token', function (Request $request) {
    $user = auth('admin')->user(); // Or however you're authenticating

    $request->validate([
        'token' => 'required|string',
    ]);

    $user->fcm_token = $request->token;
    $user->save();

    return response()->json(['status' => 'success']);
});

