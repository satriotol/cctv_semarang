<?php

use App\Http\Controllers\Api\ApiCctvController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('getLocation', [ApiCctvController::class, 'getLocation']);
Route::get('getCctv', [ApiCctvController::class, 'getCctv']);
Route::get('batch', [ApiCctvController::class, 'batch']);
Route::get('getFirstBatch', [ApiCctvController::class, 'getFirstBatch'])->name('getFirstBatch');
Route::get('cctvStatus', [ApiCctvController::class, 'cctvStatus'])->name('cctvStatus');
Route::get('cctvStatus/{cctv}', [ApiCctvController::class, 'cctvStatusDetail'])->name('cctvStatusDetail');
Route::middleware('checkHeader')->group(function () {
});
