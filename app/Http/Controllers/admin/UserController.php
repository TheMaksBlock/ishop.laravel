<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\admin\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller {
    private $orderService;
    private $perpage = 10;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function index() {
        $users = User::paginate($this->perpage);
        return view('admin.user.index', compact('users'));
    }

    public function edit(User $user) {
        $orders = $this->orderService->getUserOrders($user);
        return view('admin.user.edit', compact('user', 'orders'));
    }

    public function update(Request $request, User $user) {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255|unique:users,login,' . $user->id,
            'password' => 'nullable|string|min:6',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->login = $request->input('login');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->role = $request->input('role', $user->role);
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Пользователь успешно обновлен.');
    }
}
