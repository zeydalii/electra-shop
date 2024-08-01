<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminRegisterController extends Controller
{
    public function index() 
    {
        return view('admin.pages.register');
    }

    public function store(Request $request)
    {
        // dd($request);
        // try {
            $validatedData = $request->validate([
                'email' => 'required|email:dns|unique:users',
                'nama_lengkap' => 'required|min:3|max:255',
                'password' => 'required|min:3|max:255',
            ]);
    
            $validatedData['password'] = Hash::make($validatedData['password']);
    
            $user = new User();
            $user->email = $validatedData['email'];
            $user->nama_lengkap = $validatedData['nama_lengkap'];
            $user->password = $validatedData['password'];
    
            $user->save();
    
            return redirect('/admin/register')->with('registerSuccess', 'Data admin berhasil dibuat!');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     dd($e->getMessage());
        //     return redirect()->back();
        // }
    }
}