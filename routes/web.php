<?php

use App\Http\Middleware\authAdminMW;
use App\Http\Middleware\authMW;
use App\Http\Middleware\guestAdminMW;
use App\Http\Middleware\guestMW;
use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\MainController@index')->name('main.index');

Route::get('/currency/change/{code}', 'App\Http\Controllers\CurrencyController@change')->name('currency.change');

Route::get('/product/{product:alias}', 'App\Http\Controllers\ProductController@show')->name('product.show');

Route::get('/cart/add', 'App\Http\Controllers\CartController@add')->name('cart.add');
Route::get('/cart/clear', 'App\Http\Controllers\CartController@clear')->name('cart.clear');
Route::get('/cart/delete', 'App\Http\Controllers\CartController@delete')->name('cart.delete');
Route::get('/cart/show', 'App\Http\Controllers\CartController@show')->name('cart.show');
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index')->middleware(authMW::class);
Route::Post('/cart/checkout', 'App\Http\Controllers\CartController@checkout')->name('cart.checkout')->middleware(authMW::class);

Route::get('/catalog', 'App\Http\Controllers\CatalogController@show')->name('catalog.index');
Route::get('/catalog/typeahead', 'App\Http\Controllers\CatalogController@typeahead');
Route::get('/catalog/{category:alias}', 'App\Http\Controllers\CatalogController@show')->name('catalog.show');

Route::get('/register', 'App\Http\Controllers\RegisterController@index')->name('register.index')->middleware(guestMW::class);
Route::post('/register', 'App\Http\Controllers\RegisterController@create')->name('register.create')->middleware(guestMW::class);
Route::get('/login', 'App\Http\Controllers\LoginController@index')->name('login.index')->middleware(guestMW::class);
Route::post('/login', 'App\Http\Controllers\LoginController@login')->name('login.login')->middleware(guestMW::class);
Route::get('/login/logout', 'App\Http\Controllers\LoginController@logout')->name('login.logout')->middleware(authMW::class);

Route::get('/admin/login', 'App\Http\Controllers\admin\LoginController@index')->name('admin.login.index')->middleware(guestAdminMW::class);
Route::post('/admin/login', 'App\Http\Controllers\admin\LoginController@login')->name('admin.login.login')->middleware(guestAdminMW::class);

Route::get('/admin', 'App\Http\Controllers\admin\MainController@index')->name('admin.index')->middleware(authAdminMW::class);

Route::get('/admin/order', 'App\Http\Controllers\admin\OrderController@index')->name('admin.order.index')->middleware(authAdminMW::class);
Route::get('/admin/order/delete', 'App\Http\Controllers\admin\OrderController@delete')->name('admin.order.delete')->middleware(authAdminMW::class);
Route::get('/admin/order/change', 'App\Http\Controllers\admin\OrderController@change')->name('admin.order.change-status')->middleware(authAdminMW::class);
Route::get('/admin/order/{orderId}', 'App\Http\Controllers\admin\OrderController@show')->name('admin.order.show')->middleware(authAdminMW::class);
