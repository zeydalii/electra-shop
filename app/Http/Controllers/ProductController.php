<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Product::query();

        $pagination = 4;

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('merk', 'LIKE', '%' . $search . '%');
            });
        }

        $products = $query->paginate($pagination);

        return view('admin.pages.products', compact('products', 'search'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    public function store(Request $request)
    {
        // dd($request);
        // try {
            $validatedData = $request->validate([
                'image' => 'required|image|file|max:5120|mimes:jpeg,png,jpg,gif,webp',
                'merk' => 'required|min:3|max:255',
                'harga' => 'required|int',
                'stock' => 'required|int',
            ]);
    
            $product = new Product();
            $product->merk = $validatedData['merk'];
            $product->harga = $validatedData['harga'];
            $product->stock = $validatedData['stock'];
            $product->active = $request->input('active', 0);

            $imagePath = $request->file('image')->store('images/products', 'public');
            $product->image = $imagePath;

            $product->save();
    
            return redirect('/admin/products')->with('storeSuccess', 'Data produk berhasil dibuat!');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     dd($e->getMessage());
        //     return redirect()->back();
        // }
        
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        try {
            $product = Product::findOrFail($id);

            $rules = [
                'image' => 'nullable|image|file|max:5120|mimes:jpeg,png,jpg,gif,webp',
                'merk' => 'required|min:3|max:255',
                'harga' => 'required|int',
                'stock' => 'required|int',
                'active' => 'nullable'
            ];

            $validatedData = $request->validate($rules);

            $product->merk = $validatedData['merk'];
            $product->harga = $validatedData['harga'];
            $product->stock = $validatedData['stock'];
            $product->active = $validatedData['active'];
            
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($product->image);
    
                $imagePath = $request->file('image')->store('images/products', 'public');
                $product->image = $imagePath;
            }
    
            $product->save();
    
            return redirect('/admin/products')->with('updateSuccess', 'Data produk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back();
        }
        
    }

    public function destroy($id)
    {
        // dd($id);
        // try {
            $product = Product::findOrFail($id);

            Storage::disk('public')->delete($product->image);

            $product->delete();
    
            return redirect('/admin/products')->with('deleteSuccess', 'Data produk berhasil dihapus!');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     dd($e->getMessage());
        //     return redirect()->back();
        // }
        
    }
}
