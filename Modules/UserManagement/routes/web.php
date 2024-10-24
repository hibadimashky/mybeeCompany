<?php

use App\Http\Middleware\AuthenticateJWT;
use App\Http\Middleware\LocalizationMiddleware;
use Illuminate\Support\Facades\Route;
use Modules\UserManagement\Http\Controllers\UserManagementController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


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

Route::middleware([
    'web',
    LocalizationMiddleware::class,
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,

])->group(function () {
    Route::middleware(AuthenticateJWT::class)->group(function () {
        Route::get('/', function () {
            return view('usermanagement::index');
        })->name('dashboard');
    });
    Route::get('/login', function () {
        return view('usermanagement::login');
    });

    Route::post('/postlogin', [UserManagementController::class, 'login'])->name('login.postLogin');


    Route::resource('usermanagement', UserManagementController::class)->names('usermanagement');
});