<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InitializeCartSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !session()->has('cart')) {
            $giohang = DB::table('giohang')
                ->where('maKH', Auth::id())
                ->get();

            $cartSession = [];
            foreach ($giohang as $item) {
                $cartSession[$item->maSP] = ['checked' => 0];
            }
            \Log::info('Cart sau khi đăng nhập:', $cartSession); // log ra file laravel.log

            session(['cart' => $cartSession]);
        }
        return $next($request);
    }
}
