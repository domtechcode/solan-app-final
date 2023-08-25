<?php

namespace App\Http\Controllers\Auth\LoginContr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
	public function showLoginForm()
    {
        $data['title'] = "Login";

        // Attempt to log the user in
        if (Auth::check()) {
            // Determine the user's role and redirect to the appropriate dashboard
            $user = Auth::user();
            // dd($user->role);
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
                    break;

                case 'Purchase':
                    return redirect()->route('purchase.dashboard');
                    break;

                case 'Admin':
                    return redirect()->route('admin.dashboard');
                    break;

                default:
                    return redirect()->route('login');
                    break;
            }
        }

        return view('login', $data);
    }
    
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            // Determine the user's role and redirect to the appropriate dashboard
            $user = Auth::user();
            // dd($user->role);
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
                    break;

                case 'Purchase':
                    return redirect()->route('purchase.dashboard');
                    break;

                case 'Admin':
                    return redirect()->route('admin.dashboard');
                    break;

                default:
                    return redirect()->route('login');
                    break;
            }
        }

        // If authentication fails, redirect back to the login page with an error message
        session()->flash('error', 'Username/Password Salah.');

        return redirect()->back()->withErrors(['username' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}