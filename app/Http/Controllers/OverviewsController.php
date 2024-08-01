<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Score;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class OverviewsController extends Controller
{
    public function index(Request $request)
    {
        $usersData = User::count();
        $productsData = Product::count();
        $transactionsData = Transaction::count();

        return view('admin.pages.overviews', compact('usersData', 'productsData', 'transactionsData'));
    }
}