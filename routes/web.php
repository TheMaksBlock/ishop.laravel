<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\MainController@index')->name('main.index');
Route::get('/currency/change/{code}', 'App\Http\Controllers\CurrencyController@change')->name('currency.change');
Route::get('/product/{product:alias}', 'App\Http\Controllers\ProductController@show')->name('product.show');
Route::get('/cart/add', 'App\Http\Controllers\CartController@add')->name('cart.add');
Route::get('/category/{alias}', 'App\Http\Controllers\CartController@add')->name('category');
