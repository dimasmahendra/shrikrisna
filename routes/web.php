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
            Route::get('/details/{id}', [App\Http\Controllers\Cms\CustomerController::class, 'details'])->name('customer.details');
            Route::post('/update/{id}', [App\Http\Controllers\Cms\CustomerController::class, 'update'])->name('customer.update');
            Route::get('/destroy/{id}', [App\Http\Controllers\Cms\CustomerController::class, 'destroy'])->name('customer.destroy');

            Route::prefix("measurement")->group(function () {
                Route::get('/category/{id}', [App\Http\Controllers\Cms\MeasurementController::class, 'category'])->name('category.measurement.category');
                Route::get('/create/{id}', [App\Http\Controllers\Cms\MeasurementController::class, 'create'])->name('category.measurement.create');
            });
        });

        // Category
        Route::prefix("category")->group(function () {
            Route::get('', [App\Http\Controllers\Cms\CategoryController::class, 'index'])->name('category.index');
            Route::post('/store', [App\Http\Controllers\Cms\CategoryController::class, 'store'])->name('category.store');
            Route::post('/edit', [App\Http\Controllers\Cms\CategoryController::class, 'edit'])->name('category.edit');
            Route::post('/update/{id}', [App\Http\Controllers\Cms\CategoryController::class, 'update'])->name('category.update');
            Route::get('/destroy/{id}', [App\Http\Controllers\Cms\CategoryController::class, 'destroy'])->name('category.destroy');

            Route::get('/details/{id}', [App\Http\Controllers\Cms\CategoryController::class, 'details'])->name('category.details');
            Route::get('/view/{id}', [App\Http\Controllers\Cms\CategoryController::class, 'view'])->name('category.view');
            Route::post('/details/store/{id}', [App\Http\Controllers\Cms\CategoryController::class, 'detailsStore'])->name('category.details.store');
            Route::post('/details/edit', [App\Http\Controllers\Cms\CategoryController::class, 'detailsEdit'])->name('category.details.edit');
            Route::post('/details/update/{id}', [App\Http\Controllers\Cms\CategoryController::class, 'detailsUpdate'])->name('category.details.update');
            Route::get('/details/destroy/{id}', [App\Http\Controllers\Cms\CategoryController::class, 'detailsDestroy'])->name('category.details.destroy');

            Route::get('/details/cancel/{id}', [App\Http\Controllers\Cms\CategoryController::class, 'detailsCancel'])->name('category.details.cancel');
            Route::get('/details/submit/{id}', [App\Http\Controllers\Cms\CategoryController::class, 'detailsSubmit'])->name('category.details.submit');
        });

        Route::prefix("rbac")->group(function () {
            // User Management
            Route::get('/users', [App\Http\Controllers\Rbac\UserManagementController::class, 'index'])->name('rbac.users.index');
            Route::post('/users/store', [App\Http\Controllers\Rbac\UserManagementController::class, 'store'])->name('rbac.users.store');
            Route::post('/users/edit', [App\Http\Controllers\Rbac\UserManagementController::class, 'edit'])->name('rbac.users.edit');
            Route::post('/users/update/{id}', [App\Http\Controllers\Rbac\UserManagementController::class, 'update'])->name('rbac.users.update');
            Route::post('/users/edit/reset-password', [App\Http\Controllers\Rbac\UserManagementController::class, 'resetPasswordedit'])->name('rbac.users.reset-password');
            Route::post('/users/edit/reset-password/{id}', [App\Http\Controllers\Rbac\UserManagementController::class, 'resetPassword'])->name('rbac.users.edit.reset-password');
            Route::get('/users/destroy/{id}', [App\Http\Controllers\Rbac\UserManagementController::class, 'destroy'])->name('rbac.users.destroy');
        });
    });
});