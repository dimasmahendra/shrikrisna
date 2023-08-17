<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/homepage', [App\Http\Controllers\Api\HomepageController::class, 'index'])->name('api.homepage');

Route::get('/setting', [App\Http\Controllers\Api\HomepageController::class, 'setting'])->name('api.setting');

Route::get('/about', [App\Http\Controllers\Api\HomepageController::class, 'about'])->name('api.about');

Route::get('/banner', [App\Http\Controllers\Api\HomepageController::class, 'banner'])->name('api.banner');

Route::post('/visitor/store', [App\Http\Controllers\Api\HomepageController::class, 'visitor'])->name('api.visitor');

Route::get('/portfolio/category', [App\Http\Controllers\Api\HomepageController::class, 'projectCategory'])->name('api.portfolio.category');
Route::get('/portfolio/layout', [App\Http\Controllers\Api\HomepageController::class, 'portfolioLayout'])->name('api.portfolio.layout');
Route::get('/portfolio/{slug}', [App\Http\Controllers\Api\HomepageController::class, 'portfolioDetail'])->name('api.portfolio.detail');
Route::post('/portfolio', [App\Http\Controllers\Api\HomepageController::class, 'portfolio'])->name('api.portfolio');

Route::post('/news', [App\Http\Controllers\Api\HomepageController::class, 'article'])->name('api.article');
Route::get('/news/layout', [App\Http\Controllers\Api\HomepageController::class, 'articleLayout'])->name('api.article.layout');
Route::get('/news/category', [App\Http\Controllers\Api\HomepageController::class, 'articleCategory'])->name('api.article.category');
Route::get('/news/{slug}', [App\Http\Controllers\Api\HomepageController::class, 'articleDetail'])->name('api.article.detail');

Route::post('/contact/store', [App\Http\Controllers\Api\HomepageController::class, 'contact'])->name('api.contact');
Route::get('/contact/layout', [App\Http\Controllers\Api\HomepageController::class, 'contactLayout'])->name('api.contact.layout');

Route::post('/faq/search', [App\Http\Controllers\Api\HomepageController::class, 'faqSearch'])->name('api.faq.search');
Route::get('/faq/layout', [App\Http\Controllers\Api\HomepageController::class, 'faqLayout'])->name('api.faq.layout');
Route::get('/faq/category', [App\Http\Controllers\Api\HomepageController::class, 'faqCategory'])->name('api.faq.category');
Route::get('/faq/{id}', [App\Http\Controllers\Api\HomepageController::class, 'faq'])->name('api.faq');
Route::get('/faqs', [App\Http\Controllers\Api\HomepageController::class, 'faqs'])->name('api.faqs');

Route::get('/product/layout', [App\Http\Controllers\Api\HomepageController::class, 'productLayout'])->name('api.product.layout');
Route::get('/product/category', [App\Http\Controllers\Api\HomepageController::class, 'productCategory'])->name('api.product.category');
Route::get('/product/variant', [App\Http\Controllers\Api\HomepageController::class, 'productVariant'])->name('api.product.variant');
Route::get('/product/{slug}', [App\Http\Controllers\Api\HomepageController::class, 'productDetail'])->name('api.product.detail');
Route::post('/product', [App\Http\Controllers\Api\HomepageController::class, 'product'])->name('api.product');