<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\WebAppController;
use App\Http\Controllers\Api\DomainController;
use App\Http\Controllers\Api\DatabaseController;
use App\Http\Controllers\Api\SshAccessController;
use App\Http\Controllers\Api\FtpAccountController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\EmailAccountController;
use App\Http\Controllers\Api\DomainWebAppsController;
use App\Http\Controllers\Api\WebAppFtpAccountsController;
use App\Http\Controllers\Api\WebAppSshAccessesController;
use App\Http\Controllers\Api\WebAppEmailAccountsController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('web-apps', WebAppController::class);

        // WebApp Ftp Accounts
        Route::get('/web-apps/{webApp}/ftp-accounts', [
            WebAppFtpAccountsController::class,
            'index',
        ])->name('web-apps.ftp-accounts.index');
        Route::post('/web-apps/{webApp}/ftp-accounts', [
            WebAppFtpAccountsController::class,
            'store',
        ])->name('web-apps.ftp-accounts.store');

        // WebApp Ssh Accesses
        Route::get('/web-apps/{webApp}/ssh-accesses', [
            WebAppSshAccessesController::class,
            'index',
        ])->name('web-apps.ssh-accesses.index');
        Route::post('/web-apps/{webApp}/ssh-accesses', [
            WebAppSshAccessesController::class,
            'store',
        ])->name('web-apps.ssh-accesses.store');

        // WebApp Email Accounts
        Route::get('/web-apps/{webApp}/email-accounts', [
            WebAppEmailAccountsController::class,
            'index',
        ])->name('web-apps.email-accounts.index');
        Route::post('/web-apps/{webApp}/email-accounts', [
            WebAppEmailAccountsController::class,
            'store',
        ])->name('web-apps.email-accounts.store');

        Route::apiResource('domains', DomainController::class);

        // Domain Web Apps
        Route::get('/domains/{domain}/web-apps', [
            DomainWebAppsController::class,
            'index',
        ])->name('domains.web-apps.index');
        Route::post('/domains/{domain}/web-apps', [
            DomainWebAppsController::class,
            'store',
        ])->name('domains.web-apps.store');

        Route::apiResource('databases', DatabaseController::class);

        Route::apiResource('email-accounts', EmailAccountController::class);

        Route::apiResource('ftp-accounts', FtpAccountController::class);

        Route::apiResource('ssh-accesses', SshAccessController::class);

        Route::apiResource('users', UserController::class);
    });
