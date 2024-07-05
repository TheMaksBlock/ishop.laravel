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

Route::get('/admin/category', 'App\Http\Controllers\admin\CategoryController@index')->name('admin.category.index')->middleware(authAdminMW::class);
Route::get('/admin/category/delete', 'App\Http\Controllers\admin\CategoryController@delete')->name('admin.category.delete')->middleware(authAdminMW::class);
Route::get('/admin/category/{category:id}/edit', 'App\Http\Controllers\admin\CategoryController@edit')->name('admin.category.edit')->middleware(authAdminMW::class);
Route::put('/admin/category/{category:id}', 'App\Http\Controllers\admin\CategoryController@update')->name('admin.category.update')->middleware(authAdminMW::class);
Route::get('/admin/category/create', 'App\Http\Controllers\admin\CategoryController@create')->name('admin.category.create')->middleware(authAdminMW::class);
Route::post('/admin/category', 'App\Http\Controllers\admin\CategoryController@store')->name('admin.category.store')->middleware(authAdminMW::class);

Route::get('/admin/cache', 'App\Http\Controllers\admin\CacheController@index')->name('admin.cache.index')->middleware(authAdminMW::class);
Route::get('/admin/cache/forget', 'App\Http\Controllers\admin\CacheController@forget')->name('admin.cache.forget')->middleware(authAdminMW::class);
Route::get('/admin/cache/forgetGroup', 'App\Http\Controllers\admin\CacheController@forgetGroup')->name('admin.cache.forgetGroup')->middleware(authAdminMW::class);
Route::get('/admin/cache/forgetAll', 'App\Http\Controllers\admin\CacheController@forgetAll')->name('admin.cache.forgetAll');

Route::get('/admin/user', 'App\Http\Controllers\admin\UserController@index')->name('admin.user.index')->middleware(authAdminMW::class);
Route::get('/admin/user/{user:id}/edit', 'App\Http\Controllers\admin\UserController@edit')->name('admin.user.edit')->middleware(authAdminMW::class);
Route::put('/admin/user/{user:id}', 'App\Http\Controllers\admin\UserController@update')->name('admin.user.update')->middleware(authAdminMW::class);

Route::get('/admin/product', 'App\Http\Controllers\admin\ProductsController@index')->name('admin.products.index')->middleware(authAdminMW::class);
Route::get('/admin/product/create', 'App\Http\Controllers\admin\ProductsController@create')->name('admin.product.create')->middleware(authAdminMW::class);
Route::post('/admin/product/store', 'App\Http\Controllers\admin\ProductsController@store')->name('admin.product.store')->middleware(authAdminMW::class);
Route::get('/admin/product/{product}/edit', 'App\Http\Controllers\admin\ProductsController@edit')->name('admin.product.edit')->middleware(authAdminMW::class);
Route::get('/admin/product/{product}/delete', 'App\Http\Controllers\admin\ProductsController@delete')->name('admin.product.delete')->middleware(authAdminMW::class);
Route::post('/admin/product/addImage', 'App\Http\Controllers\admin\ProductsController@addImage')->name('admin.product.addImage')->middleware(authAdminMW::class);
Route::get('/admin/product/related-product', 'App\Http\Controllers\admin\ProductsController@relatedProduct')->name('admin.product.relatedProduct')->middleware(authAdminMW::class);
Route::put('/admin/product/{product}', 'App\Http\Controllers\admin\ProductsController@update')->name('admin.product.update')->middleware(authAdminMW::class);



