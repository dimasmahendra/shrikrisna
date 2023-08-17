<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

URL::forceRootUrl(env('APP_URL'));

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('front.home');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware(["auth:web"])->group(function () {
    Route::prefix("admin")->group(function () {

        Route::post('/upload-image', [App\Http\Controllers\InternalController::class, 'uploadImage'])->name('uploadImage');
        Route::get('/delete-image/{id}', [App\Http\Controllers\InternalController::class, 'deleteImage'])->name('deleteImage');
        Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('admin.change-password');

        // Customer
        Route::prefix("customer")->group(function () {
            Route::get('', [App\Http\Controllers\Cms\CustomerController::class, 'index'])->name('customer.index');
            Route::get('/create', [App\Http\Controllers\Cms\CustomerController::class, 'create'])->name('customer.create');
            Route::post('/store', [App\Http\Controllers\Cms\CustomerController::class, 'store'])->name('customer.store');
            Route::get('/edit/{id}', [App\Http\Controllers\Cms\CustomerController::class, 'edit'])->name('customer.edit');
            Route::post('/update/{id}', [App\Http\Controllers\Cms\CustomerController::class, 'update'])->name('customer.update');
            Route::get('/destroy/{id}', [App\Http\Controllers\Cms\CustomerController::class, 'destroy'])->name('customer.destroy');
        });

        Route::prefix("rbac")->group(function () {
            // User Management
            Route::get('/users', [App\Http\Controllers\Rbac\UserManagementController::class, 'index'])->name('rbac.users.index');
            Route::post('/users/store', [App\Http\Controllers\Rbac\UserManagementController::class, 'store'])->name('rbac.users.store');
            Route::post('/users/edit', [App\Http\Controllers\Rbac\UserManagementController::class, 'edit'])->name('rbac.users.edit');
            Route::post('/users/update/{id}', [App\Http\Controllers\Rbac\UserManagementController::class, 'update'])->name('rbac.users.update');
            Route::get('/users/destroy/{id}', [App\Http\Controllers\Rbac\UserManagementController::class, 'destroy'])->name('rbac.users.destroy');

            // Role
            Route::get('/role', [App\Http\Controllers\Rbac\RoleManagementController::class, 'index'])->name('rbac.role.index');
            Route::get('/role/create', [App\Http\Controllers\Rbac\RoleManagementController::class, 'create'])->name('rbac.role.create');
            Route::post('/role/store', [App\Http\Controllers\Rbac\RoleManagementController::class, 'store'])->name('rbac.role.store');
            Route::get('/role/edit/{id}', [App\Http\Controllers\Rbac\RoleManagementController::class, 'edit'])->name('rbac.role.edit');
            Route::post('/role/update/{id}', [App\Http\Controllers\Rbac\RoleManagementController::class, 'update'])->name('rbac.role.update');
            Route::get('/role/destroy/{id}', [App\Http\Controllers\Rbac\RoleManagementController::class, 'destroy'])->name('rbac.role.destroy');
        });
    });
});