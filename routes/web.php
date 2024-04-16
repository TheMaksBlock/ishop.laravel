<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\MainController@index')->name('main.index');
Route::get('/product/{product:alias}', 'App\Http\Controllers\ProductController@show')->name('product.show');
