<?php

use App\Http\Controllers\Admin\Auth\LoginController as AdminAuthLoginController;
use App\Http\Controllers\Customer\Auth\LoginController;
use App\Http\Controllers\Customer\Auth\RegisterController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Provider\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Provider\Auth\RegisterController as AuthRegisterController;
use App\Http\Controllers\Provider\ProfileController as ProviderProfileController;
use App\Http\Controllers\Site\ContactUsController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ProjectsController;
use App\Http\Controllers\Site\ProvidersController;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "web" middleware group. Make something great!
 * |
 */

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact.us');
Route::post('/contact-us', [ContactUsController::class, 'store'])->name('contact.us.store');

Route::prefix('projects')->as('projects.')->group(function () {
    Route::get('/', [ProjectsController::class, 'list'])->name('list');
    Route::get('/{id}', [ProjectsController::class, 'show'])->name('show');
});
Route::prefix('providers')->as('providers.')->group(function () {
    Route::get('/', [ProvidersController::class, 'list'])->name('list');
    Route::get('/{provider}', [ProvidersController::class, 'show'])->name('show');
});

Route::prefix('customer')->group(function () {
    Route::prefix('register')->middleware(['guest:customer'])->group(function () {
        Route::get('/', [RegisterController::class, 'stepOne'])->name('customer.register');

        Route::get('step-two/{id}', [RegisterController::class, 'stepTwo'])->name('customer.register.stepTwo');

        Route::get('step-three/{id}', [RegisterController::class, 'stepThree'])->name('customer.register.stepThree');

        Route::post('step-one', [RegisterController::class, 'registerStepOne'])->name('customer.register.stepOne');

        Route::get('step-two-post/{id}', [RegisterController::class, 'registerStepTwo'])->name('customer.register.stepTwo.post');

        Route::post('step-three-post/{id}', [RegisterController::class, 'registerStepThree'])->name('customer.register.stepThree.post');
    });
    Route::get('login', [LoginController::class, 'login'])->name('customer.login');
    Route::post('login', [LoginController::class, 'loginPost'])->name('customer.login.post');
    Route::get('forgot-password', [LoginController::class, 'forgotPassword'])->name('customer.password.forgot');
    Route::post('forgot-password/send-code', [LoginController::class, 'sendResetCode'])->name('customer.password.send.code');
    Route::get('forgot-password/verify', [LoginController::class, 'showVerifyCodeForm'])->name('customer.password.verify.form');
    Route::post('forgot-password/verify', [LoginController::class, 'verifyResetCode'])->name('customer.password.verify');
    Route::post('forgot-password/resend', [LoginController::class, 'resendResetCode'])->name('customer.password.resend');
    Route::get('forgot-password/reset', [LoginController::class, 'showResetPasswordForm'])->name('customer.password.reset.form');
    Route::post('forgot-password/reset', [LoginController::class, 'resetPassword'])->name('customer.password.reset');
    Route::get('logout', [LoginController::class, 'logout'])->name('customer.logout');
});

Route::prefix('provider')->as('provider.')->middleware(['guest:provider'])->group(function () {
    Route::prefix('register')->group(function () {
        Route::get('/', [AuthRegisterController::class, 'stepOne'])->name('register');

        Route::get('step-two/{id}', [AuthRegisterController::class, 'stepTwo'])->name('register.stepTwo');

        Route::get('step-three/{id}', [AuthRegisterController::class, 'stepThree'])->name('register.stepThree');

        Route::post('step-one', [AuthRegisterController::class, 'registerStepOne'])->name('register.stepOne');

        Route::post('step-two-post/{id}', [AuthRegisterController::class, 'registerStepTwo'])->name('register.stepTwo.post');

        Route::post('step-three-post/{id}', [AuthRegisterController::class, 'registerStepThree'])->name('register.stepThree.post');
    });
    Route::get('login', [AuthLoginController::class, 'login'])->name('login');
    Route::post('login', [AuthLoginController::class, 'loginPost'])->name('login.post');
    Route::get('forgot-password', [AuthLoginController::class, 'forgotPassword'])->name('password.forgot');
    Route::post('forgot-password/send-code', [AuthLoginController::class, 'sendResetCode'])->name('password.send.code');
    Route::get('forgot-password/verify', [AuthLoginController::class, 'showVerifyCodeForm'])->name('password.verify.form');
    Route::post('forgot-password/verify', [AuthLoginController::class, 'verifyResetCode'])->name('password.verify');
    Route::post('forgot-password/resend', [AuthLoginController::class, 'resendResetCode'])->name('password.resend');
    Route::get('forgot-password/reset', [AuthLoginController::class, 'showResetPasswordForm'])->name('password.reset.form');
    Route::post('forgot-password/reset', [AuthLoginController::class, 'resetPassword'])->name('password.reset');
});
Route::get('/provider/logout', [AuthLoginController::class, 'logout'])->name('provider.logout');

Route::prefix('admin')->as('admin.')->middleware(['guest:admin'])->group(function () {
    Route::get('login', [AdminAuthLoginController::class, 'login'])->name('login');
    Route::post('login', [AdminAuthLoginController::class, 'loginPost'])->name('login.post');
    
});

Route::prefix('admin')->as('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('2fa', [AdminAuthLoginController::class, 'showTwoFactorForm'])->name('2fa.form');
    Route::post('2fa', [AdminAuthLoginController::class, 'verifyTwoFactor'])->name('2fa.verify');
    Route::post('2fa/resend', [AdminAuthLoginController::class, 'resendTwoFactor'])->name('2fa.resend');
    Route::get('logout', [AdminAuthLoginController::class, 'logout'])->name('logout');
});

Route::prefix('customer')->middleware(['auth:customer'])->as('customer.')->group(function () {
    Route::get('compelete-account', [ProfileController::class, 'compeleteAccount'])->name('compelete.account');
    Route::post('compelete-account/{id}', [ProfileController::class, 'compeleteAccountPost'])->name('compelete.account.post');
});
Route::prefix('provider')->middleware(['auth:provider'])->as('provider.')->group(function () {
    Route::get('compelete-account', [ProviderProfileController::class, 'compeleteAccount'])->name('compelete.account');
    Route::post('compelete-account/{id}', [ProviderProfileController::class, 'compeleteAccountPost'])->name('compelete.account.post');
    Route::post('delete-file', [ProviderProfileController::class, 'deleteFile'])->name('profile.delete.file');
    Route::get('logout', [AuthLoginController::class, 'logout'])->name('logout');
});





