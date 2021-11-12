<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TemporaryFileController;
use App\Http\Controllers\WebsiteController;
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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::get('user', function (Request $request) {
        return $request->user();
    });
});

Route::group(['middleware' => 'api'], function () {
    Route::post('register', [RegisterController::class, 'store']);
    Route::apiResource('websites', WebsiteController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('servers', ServerController::class);
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('invoices', InvoiceController::class);
    Route::apiResource('products', ProductController::class);
    Route::post('upload-temp-files', [TemporaryFileController::class, 'store']);
    Route::delete('upload-temp-files/{temporaryFile}', [TemporaryFileController::class, 'destroy']);
    Route::delete('upload-temp-files', [TemporaryFileController::class, 'destroyAll']);
});


