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

                case 'admin-kader':
                    return redirect()->route('admin-kader.dashboard');
                    break;

                default:
                    return redirect()->route('login');
                    break;
            }
        }

        // If authentication fails, redirect back to the login page with an error message
        return redirect()->back()->withErrors(['username' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}