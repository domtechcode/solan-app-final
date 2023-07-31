<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                switch ($user->role) {
                    case 'Follow Up':
                        return redirect()->route('followUp.dashboard');
                        break;
                    case 'Stock':
                        return redirect()->route('stock.dashboard');
                        break;
                    case 'Hitung Bahan':
                        return redirect()->route('hitungBahan.dashboard');
                        break;
                    case 'RAB':
                        return redirect()->route('rab.dashboard');
                        break;
                    case 'Penjadwalan':
                        return redirect()->route('jadwal.dashboard');
                        break;
                    case 'Operator':
                        return redirect()->route('operator.dashboard');
                        break;
                    case 'Accounting':
                        return redirect()->route('accounting.dashboard');
                        break;
                    // Tambahkan case untuk peran (role) lain jika diperlukan
                    default:
                        return redirect('/'); // Pengalihan default jika peran tidak cocok dengan yang diberikan dalam switch case
                }
            }
        }

        return $next($request);
    }
}
