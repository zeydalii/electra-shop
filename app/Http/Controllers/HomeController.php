<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TempCalculate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Product::where('active', 1);

        $pagination = 4;

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('merk', 'LIKE', '%' . $search . '%');
            });
        }

        $products = $query->paginate($pagination);
        $title = 'Home Page';

        return view('home', compact('products', 'search', 'title'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    public function store(Request $request)
    {
        // dd($request);
        try{
            $validatedData = $request->validate([
                'session_id' => 'required',
                'item_id' => 'required',
                'jumlah' => 'required|integer|min:1',
                'harga' => 'required|integer',
            ]);
    
            // $tempCal = TempCalculate::firstOrCreate([
            //     'session_id' => $validatedData['session_id'],
            // ]);
    
            $tempCal = new TempCalculate();
            $tempCal->session_id = $validatedData['session_id'];
            $tempCal->item_id = $validatedData['item_id'];
            $tempCal->jumlah = $validatedData['jumlah'];
            $tempCal->harga = $validatedData['harga'];
            $tempCal->subtotal = $tempCal->jumlah * $tempCal->harga;
    
            $tempCal->save();
    
            return redirect()->back()->with('success', 'Item berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back();
        }
    }
}
