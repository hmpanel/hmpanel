<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\WebAppController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\SshAccessController;
use App\Http\Controllers\FtpAccountController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EmailAccountController;

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


Route::redirect('/', 'dashboard');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::view('/dashboard','dashboard')->name('dashboard');
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('web-apps', WebAppController::class);
        Route::resource('domains', DomainController::class);
        Route::resource('databases', DatabaseController::class);
        Route::resource('email-accounts', EmailAccountController::class);
        Route::resource('ftp-accounts', FtpAccountController::class);
        Route::resource('ssh-accesses', SshAccessController::class);
        Route::resource('users', UserController::class);
    });
