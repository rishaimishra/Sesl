<?php

namespace App\Http\Controllers\Admin;

use App\Library\Grid\Grid;
use App\Models\DstvTransaction;
use Illuminate\Http\Request;


class DstvTransactionController extends AdminController
{


    public function index()
    {
        $transactions = DstvTransaction::with('user')->get();
        
        return view('admin.dstvtransaction.grid', compact('transactions'));
    }
}