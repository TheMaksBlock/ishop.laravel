<?php

namespace App\Http\Controllers\admin;

use App\Events\UserLogined;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    public function __construct() {
    }

    public function index() {
        return view('admin.login.index');
    }

    public function login(Request $request) {
        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            event(new UserLogined());

            if ($user->role === 'admin') {
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
