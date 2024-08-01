<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = User::query();

        $pagination = 10;

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('nama_lengkap', 'LIKE', '%' . $search . '%');
            });
        }

        $admins = $query->paginate($pagination);

        return view('admin.pages.admins', compact('admins', 'search'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    public function store(Request $request)
    {
        // dd($request);
        // try {
            $validatedData = $request->validate([
                'email' => 'required|email:dns|unique:users',
                'nama_lengkap' => 'required|max:255',
                'password' => 'required|min:3|max:255',
            ]);
    
            $validatedData['password'] = Hash::make($validatedData['password']);
    
            $user = new User();
            $user->email = $validatedData['email'];
            $user->nama_lengkap = $validatedData['nama_lengkap'];
            $user->password = $validatedData['password'];
    
            $user->save();
    
            return redirect('/admin/admins')->with('storeSuccess', 'Data admin berhasil dibuat!');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     dd($e->getMessage());
        //     return redirect()->back();
        // }
        
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        // try {
            $user = User::findOrFail($id);

            $rules = [
                'nama_lengkap' => 'required|max:255',
            ];

            if ($request->email != $user->email) {
                $rules['email'] = 'required|email:dns|unique:users';
            }

            if (!empty($request->password)) {
                $rules['password'] = 'required|min:3|max:255';
            }

            $validatedData = $request->validate($rules);

            $user->nama_lengkap = $validatedData['nama_lengkap'];

            $user->email = $validatedData['email'] ?? $user->email;
            if (!empty($request->password)) {
                $user->password = Hash::make($validatedData['password']);
            }
    
            $user->save();
    
            return redirect('/admin/admins')->with('updateSuccess', 'Data admin berhasil diperbarui!');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     dd($e->getMessage());
        //     return redirect()->back();
        // }
        
    }

    public function destroy($id)
    {
        // dd($id);
        // try {
            $user = User::findOrFail($id);

            $user->delete();
    
            return redirect('/admin/admins')->with('deleteSuccess', 'Data admin berhasil dihapus!');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     dd($e->getMessage());
        //     return redirect()->back();
        // }
        
    }
}