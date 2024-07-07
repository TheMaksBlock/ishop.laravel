<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\CurrencyService;
use Illuminate\Support\Facades\Cache;


class CurrencyController extends Controller {
    private $currencyService;

    public function __construct(CurrencyService $currencyService) {
        $this->currencyService = $currencyService;
    }

    public function change($code) {
        if ($code) {
            $curr = $this->currencyService->getCurrencies();
            if (!empty($curr[$code])) {
                Cache::put('Currency', $curr[$code], 60 * 24);
                CartService::recalc();
            }
        }
        return back();
    }
}
