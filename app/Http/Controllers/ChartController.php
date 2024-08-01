<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Product;
use App\Models\TempCalculate;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ChartController extends Controller
{
    public function index()
    {
        $currentSessionId = Session::getId();

        // $calcItems = DetailTempCalculate::all();
        $calcItems = TempCalculate::where('session_id', $currentSessionId)->get();

        $allItems = [];

        foreach($calcItems as $calcItem) {
            $existingItemKey = array_search($calcItem->item_id, array_column($allItems, 'id'));

            if ($existingItemKey !== false) {
                // Update quantity and subtotal of existing item
                $allItems[$existingItemKey]['jumlah'] += $calcItem->jumlah;
                $allItems[$existingItemKey]['subtotal'] += $calcItem->subtotal;

            } else {
                // Add new item to $allItems array with category_id as part of the key
                $productItem = Product::where('id', $calcItem->item_id)->firstOrFail();

                $allItems[] = [
                    "id" => $calcItem->item_id,
                    "merk" => $productItem->merk,
                    "image" => $productItem->image,
                    "jumlah" => $calcItem->jumlah,
                    "harga" => $calcItem->harga,
                    "subtotal" => $calcItem->subtotal,
                ];
            }
        }

        $title = 'Chart Page';

        return view('chart', compact('calcItems', 'allItems', 'title'));
    }

    public function store(Request $request)
    {
        // dd($request);

        $validatedData = $request->validate([
            'total' => 'required',
            'email' => 'required|email:dns',
        ]);

        DB::beginTransaction();

        try {
            $transaction = new Transaction();
            $transaction->total = $validatedData['total'];
            $transaction->email = $validatedData['email'];
            $transaction->save();

            $currentSessionId = Session::getId();

            $tempCal = TempCalculate::where('session_id', $currentSessionId)->get();
            // dd($tempCal);
            // $mergedDetails = [];

            // $groupedDetails = $tempCal->groupBy(['product_id']);

            // foreach ($groupedDetails as $productId => $itemDetails) {
            //     foreach ($itemDetails as $itemDetail) {
            //         // dd($itemDetail);
            //         $mergedDetail = new DetailTransaction();
            //         $mergedDetail->transaction_id = $transaction->id;
            //         $mergedDetail->product_id = $itemDetail->item_id;
            //         $mergedDetail->jumlah = $itemDetail->jumlah;
            //         $mergedDetail->harga = $itemDetail->harga;
            //         $mergedDetail->subtotal = $itemDetail->subtotal;

            //         $mergedDetail->save();

            //         $mergedDetails[] = $mergedDetail;
            //     }
            // }

            // dd($mergedDetails);

            $groupedDetails = $tempCal->groupBy('item_id');

            // Store data
            $existingProductIds = []; // Track which products have been aggregated

            foreach ($groupedDetails as $itemId => $items) {
                if ($items->count() > 1) {
                    // If there are multiple entries for this item_id, aggregate the data
                    $aggregatedDetail = $items->reduce(function ($carry, $item) {
                        $carry['jumlah'] += $item->jumlah;
                        $carry['subtotal'] += $item->subtotal;
                        return $carry;
                    }, ['jumlah' => 0, 'subtotal' => 0]);

                    $detailTransaction = new DetailTransaction();
                    $detailTransaction->transaction_id = $transaction->id;
                    $detailTransaction->product_id = $itemId;
                    $detailTransaction->jumlah = $aggregatedDetail['jumlah'];
                    $detailTransaction->harga = $items->first()->harga; // Assuming price is the same
                    $detailTransaction->subtotal = $aggregatedDetail['subtotal'];
                    $detailTransaction->save();

                    $existingProductIds[] = $itemId;
                }
            }

            // Save individual entries for items not aggregated
            foreach ($tempCal as $item) {
                if (!in_array($item->item_id, $existingProductIds)) {
                    $detailTransaction = new DetailTransaction();
                    $detailTransaction->transaction_id = $transaction->id;
                    $detailTransaction->product_id = $item->item_id;
                    $detailTransaction->jumlah = $item->jumlah;
                    $detailTransaction->harga = $item->harga;
                    $detailTransaction->subtotal = $item->subtotal;
                    $detailTransaction->save();
                }
            }

            TempCalculate::where('session_id', $currentSessionId)->delete();

            $transactionId = $transaction->id;

            DB::commit();

            return redirect()->back()->with('success', 'Item berhasil dicetak!')->with([
                'transactionId' => $transactionId,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        // dd($id);
        $currentSessionId = Session::getId();

        TempCalculate::where('session_id', $currentSessionId)
                              ->where('item_id', $id)
                              ->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus!');
        // dd($calcItem);
        // if ($calcItem) {
        //     $calcItem->delete();
        // }

        return redirect()->back()->with('error', 'Item tidak ditemukan atau terjadi kesalahan.');
    }
}
