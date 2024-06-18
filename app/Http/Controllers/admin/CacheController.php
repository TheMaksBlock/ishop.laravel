<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\admin\CacheService;
use Illuminate\Http\Request;


class CacheController extends Controller {

    public function __construct() {
    }

    public function index() {
        $cacheMenu = CacheService::getHtml();
        return view("admin.cache.index", compact('cacheMenu'));
    }

    public function forget(Request $request) {
        CacheService::forget($request->get("k"));
        return redirect()->route('admin.cache.index');
    }

    public function forgetGroup(Request $request) {
        CacheService::forgetGroup($request->get("k"));
        return redirect()->route('admin.cache.index');
    }

    public function forgetAll() {
        CacheService::forgetAll();
        return redirect()->route('admin.cache.index');
    }
}
