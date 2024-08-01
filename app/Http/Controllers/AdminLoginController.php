<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index() 
    {
        return view('admin.pages.login');
    }

    public function authenticate(Request $request) 
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required|min:3|max:255'
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/admin');
        }

        return back()->with('loginError', "Email atau password salah!");
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}