<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function __construct(){
    }

    public function index(){
        return view('admin.login.index');
    }

    public function login(Request $request) {
        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if($user->role === 'admin') {
                return redirect()->route('admin.index');
            }
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('main.index');
    }
}
