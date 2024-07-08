<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller {
    private $currencyService;

    public function __construct(CurrencyService $currencyService) {
        $this->currencyService = $currencyService;
    }

    public function index() {
        $currencies = $this->currencyService->getCurrencies();
        return view('admin.currency.index', compact('currencies'));
    }

    public function edit(Currency $currency) {
        return view('admin.currency.edit', compact('currency'));
    }

    public function update(Currency $currency, Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'value' => 'required|numeric',
            'symbol_left' => 'nullable|string|max:10',
            'symbol_right' => 'nullable|string|max:10',
            'base' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $currency->title = $request->input('title');
        $currency->code = $request->input('code');
        $currency->value = $request->input('value');
        $currency->symbol_left = $request->input('symbol_left');
        $currency->symbol_right = $request->input('symbol_right');
        $currency->base = (int)$request->boolean('base');

        if ($currency->save()) {
            return redirect()->route("admin.currency.index")->with("success", "Валюта обновлена");
        }

        return redirect()->back()->withErrors("Ошибка при изменении")->withInput();
    }

    public function create() {
        return view('admin.currency.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'value' => 'required|numeric',
            'symbol_left' => 'nullable|string|max:10',
            'symbol_right' => 'nullable|string|max:10',
            'base' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $currency = new Currency();

        $currency->title = $request->input('title');
        $currency->code = $request->input('code');
        $currency->value = $request->input('value');
        $currency->symbol_left = $request->input('symbol_left');
        $currency->symbol_right = $request->input('symbol_right');
        $currency->base = $request->boolean('base') ? '1' : '0';

        if ($currency->save()) {
            return redirect()->route("admin.currency.index")->with("success", "Валюта создана");
        }

        return redirect()->back()->withErrors("Ошибка при создании")->withInput();
    }

    public function destroy(Currency $currency) {
        if($currency->delete()){
            return redirect()->route("admin.currency.index")->with("success", "Валюта удалена");
        }
        return redirect()->back()->withErrors("Ошибка при удалении")->withInput();
    }
}
