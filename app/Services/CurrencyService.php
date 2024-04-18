<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CurrencyService {
    protected $tpl;
    protected $currencies;
    protected $currency;

    public function __construct() {
        $this->tpl = 'templates.currency_tpl';
        $this->run();
    }

    protected function run() {
        $currencies = session("Currencies");
        if(!$currencies){
            $this->currencies = $this->getCurrencies();
            session(["Currencies" =>$this->currencies]);
        }else{
            $this->currencies = session("Currencies");
        }

        $currency = session("Currency");

        if(!$currency){
            $this->currency = $this->getCurrency($this->currencies);
            session(["Currency" => $this->currency]);
        }else{
            $this->currency = session("Currency");
        }
    }

    public function getCurrencies() {

        return Currency::all()->sortByDesc("base")->mapWithKeys(function ($category) {
            return [$category['code'] => [
                'code' => $category['code'],
                'id' => $category['id'],
                'title' => $category['title'],
                'symbol_left' => $category['symbol_left'],
                'symbol_right' => $category['symbol_right'],
                'base' => $category['base']
            ]];
        })->toArray();
    }

    public function getCurrency($currencies) {
        if (Cookie::has('currency') && array_key_exists(Cookie::get('currency'), $currencies)) {
            $key = Cookie::get('currency');
        } else {
            $key = key($currencies);
        }

        $currency = $currencies[$key];
        $currency['code'] = $key;
        return $currency;
    }

    public function getHtml() {
        return view($this->tpl, ['currency' => $this->currency, 'currencies' => $this->currencies])->render();
    }
}
