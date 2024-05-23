<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\MainController@index')->name('main.index');

Route::get('/currency/change/{code}', 'App\Http\Controllers\CurrencyController@change')->name('currency.change');

Route::get('/product/{product:alias}', 'App\Http\Controllers\ProductController@show')->name('product.show');

Route::get('/cart/add', 'App\Http\Controllers\CartController@add')->name('cart.add');
Route::get('/cart/clear', 'App\Http\Controllers\CartController@clear')->name('cart.clear');
Route::get('/cart/delete', 'App\Http\Controllers\CartController@delete')->name('cart.delete');
Route::get('/cart/show', 'App\Http\Controllers\CartController@show')->name('cart.show');
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');

Route::get('/catalog', 'App\Http\Controllers\CatalogController@show')->name('catalog.index');
Route::get('/catalog/typeahead', 'App\Http\Controllers\CatalogController@typeahead');
Route::get('/catalog/{category:alias}', 'App\Http\Controllers\CatalogController@show')->name('catalog.show');

Route::get('/register', 'App\Http\Controllers\RegisterController@index')->name('register.index')->middleware("guest");
Route::post('/register', 'App\Http\Controllers\RegisterController@create')->name('register.create')->middleware("guest");

Route::get('/login', 'App\Http\Controllers\LoginController@index')->name('login.index')->middleware("guest");
Route::post('/login', 'App\Http\Controllers\LoginController@login')->name('login.login')->middleware("guest");
Route::get('/login/logout', 'App\Http\Controllers\LoginController@logout')->name('login.logout')->middleware('auth');

