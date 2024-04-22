<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Cookie;

class CurrencyService {
    protected $tpl;
    protected $currencies;
    public $currency;

    public function __construct() {
        $this->tpl = 'templates.currency_tpl';
        $this->run();
    }

    protected function run() {
        $currencies = unserialize(Cookie::get('Currencies'));
        if(!$currencies){
            $this->currencies = $this->getCurrencies();
            Cookie::queue('Currencies', serialize($this->currencies), 60*24);
        }else{
            $this->currencies = unserialize(Cookie::get('Currencies'));
        }

        $currency = unserialize(Cookie::get('Currency'));

        if(!$currency){
            $this->currency = $this->getCurrency($this->currencies);
            Cookie::queue('Currency', serialize($this->currencies), 60*24);
        }else{
            $this->currency = unserialize(Cookie::get('Currency'));
        }
    }

    public function getCurrencies() {

        return Currency::all()->sortByDesc("base")->mapWithKeys(function ($category) {
            return [$category['code'] => [
                'code' => $category['code'],
                'value' => $category['value'],
                'id' => $category['id'],
                'title' => $category['title'],
                'symbol_left' => $category['symbol_left'],
                'symbol_right' => $category['symbol_right'],
                'base' => $category['base']
            ]];
        })->toArray();
    }

    public function getCurrency($currencies) {
        if (Cookie::has('currency') && array_key_exists(unserialize(Cookie::get('currency')), $currencies)) {
            $key = unserialize(Cookie::get('currency'));
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
