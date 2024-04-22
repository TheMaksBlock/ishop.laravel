<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use Illuminate\Support\Facades\Cookie;


class CurrencyController extends Controller
{
    private $currencyService;

    public function __construct(CurrencyService $currencyService){
        $this->currencyService = $currencyService;
    }

    public function change($code){
        if($code){
            $curr = $this->currencyService->getCurrencies();
            if(!empty($curr[$code])){
                Cookie::queue('Currency', serialize($curr[$code]), 60*24,'/');
                /*Cart::recalc($curr[$currency]);*/
            }
        }
        return back();
    }
}
