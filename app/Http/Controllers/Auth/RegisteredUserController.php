<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Discount;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\khachhang;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gioiTinh' => ['nullable'],
            'ngaySinh' => ['nullable', 'date'],
            'diaChi' => ['nullable', 'string', 'max:255'],
            'soDienThoai' => ['nullable', 'string', 'max:15'],
        ]);

        DB::transaction(function () use ($request) {
            // Tạo user mới
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Lưu vào bảng khachhang
            KhachHang::create([
                'maKH' => $user->id,
                'tenKH' => $request->name,
                'email' => $request->email,
                'gioiTinh' => $request->gioiTinh ?? null,
                'ngaySinh' => $request->ngaySinh ?? null,
                'diaChi' => $request->diaChi ?? null,
                'soDienThoai' => $request->soDienThoai ?? null,
            ]);

            // Gán mã giảm giá cho khách hàng mới
            $discountIds = Discount::pluck('idMaGG')->toArray();

            $data = [];
            foreach ($discountIds as $idMaGG) {
                $data[] = [
                    'idMaGG' => $idMaGG,
                    'maKH' => $user->id,
                ];
            }

            DB::table('discounts_kh')->insert($data);

            event(new Registered($user));
            Auth::login($user);
        });

        return redirect(RouteServiceProvider::HOME);
    }
}
