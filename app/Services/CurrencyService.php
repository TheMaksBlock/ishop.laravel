<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Cache;

class CurrencyService {
    protected $tpl;
    protected $currencies;
    public $currency;

    public function __construct() {
        $this->tpl = 'templates.currency_tpl';
        $this->run();
    }

    protected function run() {
        $this->currencies = Cache::remember('Currencies', 60 * 24, function () {
            return $this->getCurrencies();
        });

        $this->currency = Cache::remember('Currency', 60 * 24, function () {
            return $this->getCurrency($this->currencies);
        });
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
        $key = Cache::get('Currency', null);

        if (!$key || !array_key_exists($key, $currencies)) {
            $key = key($currencies);
            Cache::put('Currency', $key, 60 * 24);
        }

        $currency = $currencies[$key];
        $currency['code'] = $key;
        return $currency;
    }

    public function getHtml() {
        return view($this->tpl, ['currency' => $this->currency, 'currencies' => $this->currencies])->render();
    }
}
