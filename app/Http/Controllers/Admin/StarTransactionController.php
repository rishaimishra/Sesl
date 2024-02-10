<?php

namespace App\Http\Controllers\Admin;

use App\Library\Grid\Grid;
use App\Models\StarTransaction;
use Illuminate\Http\Request;


class StarTransactionController extends AdminController
{


    public function index()
    {
        $transactions = StarTransaction::with('user')->get();
        
        return view('admin.startransaction.grid', compact('transactions'));
    }
}