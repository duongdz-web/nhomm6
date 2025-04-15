<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\khachhang;
use Illuminate\Http\RedirectResponse;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */


    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'gioiTinh' => ['nullable'],
            'ngaySinh' => ['nullable', 'date'],
            'diaChi' => ['nullable', 'string', 'max:255'],
            'soDienThoai' => ['nullable', 'string', 'max:15'],
        ]);

        // Lưu vào bảng users
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Lưu vào bảng khachhang
        KhachHang::create([

            'tenKH' => $request->name,
            'email' => $request->email,
            'gioiTinh' => $request->gioiTinh ?? null,  // Nếu có thêm trong form
            'ngaySinh' => $request->ngaySinh ?? null,
            'diaChi' => $request->diaChi ?? null,
            'soDienThoai' => $request->soDienThoai ?? null,
        ]);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }


}

