<?php

use App\Http\Middleware\authAdminMW;
use App\Http\Middleware\authMW;
use App\Http\Middleware\guestAdminMW;
use App\Http\Middleware\guestMW;
use Illuminate\Support\Facades\Route;

// Главная страница и валюта
Route::get('/', 'App\Http\Controllers\MainController@index')->name('main.index');
Route::get('/currency/change/{code}', 'App\Http\Controllers\CurrencyController@change')->name('currency.change');

// Продукты
Route::get('/product/{product:alias}', 'App\Http\Controllers\ProductController@show')->name('product.show');

// Корзина
Route::prefix('cart')->group(function () {
    Route::get('/add', 'App\Http\Controllers\CartController@add')->name('cart.add');
    Route::get('/clear', 'App\Http\Controllers\CartController@clear')->name('cart.clear');
    Route::get('/delete', 'App\Http\Controllers\CartController@delete')->name('cart.delete');
    Route::get('/show', 'App\Http\Controllers\CartController@show')->name('cart.show');
    Route::get('/', 'App\Http\Controllers\CartController@index')->name('cart.index')->middleware(authMW::class);
    Route::post('/checkout', 'App\Http\Controllers\CartController@checkout')->name('cart.checkout')->middleware(authMW::class);
});

// Каталог
Route::prefix('catalog')->group(function () {
    Route::get('/', 'App\Http\Controllers\CatalogController@show')->name('catalog.index');
    Route::get('/typeahead', 'App\Http\Controllers\CatalogController@typeahead');
    Route::get('/{category:alias}', 'App\Http\Controllers\CatalogController@show')->name('catalog.show');
});

// Регистрация и авторизация пользователей
Route::middleware(guestMW::class)->group(function () {
    Route::get('/register', 'App\Http\Controllers\RegisterController@index')->name('register.index');
    Route::post('/register', 'App\Http\Controllers\RegisterController@create')->name('register.create');
    Route::get('/login', 'App\Http\Controllers\LoginController@index')->name('login.index');
    Route::post('/login', 'App\Http\Controllers\LoginController@login')->name('login.login');
});
Route::get('/login/logout', 'App\Http\Controllers\LoginController@logout')->name('login.logout')->middleware(authMW::class);

// Админка
Route::prefix('admin')->group(function () {
    Route::middleware(guestAdminMW::class)->group(function () {
        Route::get('/login', 'App\Http\Controllers\admin\LoginController@index')->name('admin.login.index');
        Route::post('/login', 'App\Http\Controllers\admin\LoginController@login')->name('admin.login.login');
    });

    Route::middleware(authAdminMW::class)->group(function () {
        Route::get('/', 'App\Http\Controllers\admin\MainController@index')->name('admin.index');

        // Заказы
        Route::prefix('order')->group(function () {
            Route::get('/', 'App\Http\Controllers\admin\OrderController@index')->name('admin.order.index');
            Route::get('/delete', 'App\Http\Controllers\admin\OrderController@delete')->name('admin.order.delete');
            Route::get('/change', 'App\Http\Controllers\admin\OrderController@change')->name('admin.order.change-status');
            Route::get('/{orderId}', 'App\Http\Controllers\admin\OrderController@show')->name('admin.order.show');
        });

        // Категории
        Route::prefix('category')->group(function () {
            Route::get('/', 'App\Http\Controllers\admin\CategoryController@index')->name('admin.category.index');
            Route::get('/delete', 'App\Http\Controllers\admin\CategoryController@delete')->name('admin.category.delete');
            Route::get('/{category:id}/edit', 'App\Http\Controllers\admin\CategoryController@edit')->name('admin.category.edit');
            Route::put('/{category:id}', 'App\Http\Controllers\admin\CategoryController@update')->name('admin.category.update');
            Route::get('/create', 'App\Http\Controllers\admin\CategoryController@create')->name('admin.category.create');
            Route::post('/', 'App\Http\Controllers\admin\CategoryController@store')->name('admin.category.store');
        });

        // Кэш
        Route::prefix('cache')->group(function () {
            Route::get('/', 'App\Http\Controllers\admin\CacheController@index')->name('admin.cache.index');
            Route::get('/forget', 'App\Http\Controllers\admin\CacheController@forget')->name('admin.cache.forget');
            Route::get('/forgetGroup', 'App\Http\Controllers\admin\CacheController@forgetGroup')->name('admin.cache.forgetGroup');
            Route::get('/forgetAll', 'App\Http\Controllers\admin\CacheController@forgetAll');
        });

        // Пользователи
        Route::prefix('user')->group(function () {
            Route::get('/', 'App\Http\Controllers\admin\UserController@index')->name('admin.user.index');
            Route::get('/{user:id}/edit', 'App\Http\Controllers\admin\UserController@edit')->name('admin.user.edit');
            Route::put('/{user:id}', 'App\Http\Controllers\admin\UserController@update')->name('admin.user.update');
        });

        // Продукты
        Route::prefix('product')->group(function () {
            Route::get('/', 'App\Http\Controllers\admin\ProductsController@index')->name('admin.products.index');
            Route::get('/create', 'App\Http\Controllers\admin\ProductsController@create')->name('admin.product.create');
            Route::post('/store', 'App\Http\Controllers\admin\ProductsController@store')->name('admin.product.store');
            Route::get('/{product}/edit', 'App\Http\Controllers\admin\ProductsController@edit')->name('admin.product.edit');
            Route::get('/{product}/delete', 'App\Http\Controllers\admin\ProductsController@delete')->name('admin.product.delete');
            Route::post('/addImage', 'App\Http\Controllers\admin\ProductsController@addImage')->name('admin.product.addImage');
            Route::get('/related-product', 'App\Http\Controllers\admin\ProductsController@relatedProduct')->name('admin.product.relatedProduct');
            Route::put('/{product}', 'App\Http\Controllers\admin\ProductsController@update')->name('admin.product.update');
        });

        // Валюта
        Route::prefix('currency')->group(function () {
            Route::get('/', 'App\Http\Controllers\admin\CurrencyController@index')->name('admin.currency.index');
            Route::get('/{currency}/edit', 'App\Http\Controllers\admin\CurrencyController@edit')->name('admin.currency.edit');
            Route::put('/{currency}', 'App\Http\Controllers\admin\CurrencyController@update')->name('admin.currency.update');
            Route::get('/create', 'App\Http\Controllers\admin\CurrencyController@create')->name('admin.currency.create');
            Route::post('/store', 'App\Http\Controllers\admin\CurrencyController@store')->name('admin.currency.store');
            Route::get('/{currency}/destroy', 'App\Http\Controllers\admin\CurrencyController@destroy')->name('admin.currency.destroy');
        });
    });
});
