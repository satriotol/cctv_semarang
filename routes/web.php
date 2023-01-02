<?php

use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\CaptchaServiceController;
use App\Http\Controllers\CctvController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/reload-captcha', [CaptchaServiceController::class, 'reloadCaptcha']);
Route::get('login/google', function () {
    return Socialite::driver('google')->redirect();
})->name('login.google');
Route::post('/start-queue', function () {
    Artisan::call('queue:work');
})->name('work');
Route::post('/stop-queue', function() {
    Artisan::call('queue:stop');
})->name('stopQueue');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('callback.google');
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('permission', PermissionController::class);
    Route::resource('cctv', CctvController::class);
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    Route::resource('location', LocationController::class);
    Route::resource('accessToken', AccessTokenController::class);
    Route::get('user/resetPassword/{user}', [UserController::class, 'reset_password'])->name('user.resetPassword');

    Route::post('upload/image', [UploadController::class, 'storeImage'])->name('upload.storeImage');
    Route::post('upload/file', [UploadController::class, 'storeFile'])->name('upload.storeFile');
    Route::delete('revert/image', [UploadController::class, 'revert'])->name('upload.revert');
});
require __DIR__ . '/auth.php';
