<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Transaction::query();

        $pagination = 10;

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('email', 'LIKE', '%' . $search . '%');
            });
        }

        $query->orderBy('created_at', 'desc');

        $transactions = $query->paginate($pagination);

        return view('admin.pages.transactions', compact('transactions', 'search'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    public function show(Request $request, int $id)
    {
        $transaction = Transaction::findOrFail($id);
        $detailTransactions = $transaction->details;
        $allItems = [];
        $pagination = 10;

        foreach($detailTransactions as $detail) {
            $productItem = Product::findOrFail($detail->product_id); 
            $allItems[] = [
                "id" => $detail->product_id,
                "merk" => $productItem->merk,
                "jumlah" => $detail->jumlah,
                "harga" => $detail->harga,
                "subtotal" => $detail->subtotal,
            ];
        }

        return view('admin.pages.transaction_show', compact('transaction', 'detailTransactions', 'allItems'))->with('i', ($request->input('page', 1) - 1) * $pagination);;
    }

    public function destroy($id)
    {
        // dd($id);
        $transaction = Transaction::findOrFail($id);

        $transaction->details()->delete();

        $transaction->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus!');
        // dd($calcItem);
        // if ($calcItem) {
        //     $calcItem->delete();
        // }

        return redirect()->back()->with('error', 'Item tidak ditemukan atau terjadi kesalahan.');
    }

}
