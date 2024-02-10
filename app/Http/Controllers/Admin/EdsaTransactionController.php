<?php

namespace App\Http\Controllers\Admin;

use App\Library\Grid\Grid;
use App\Models\EdsaTransaction;
use Illuminate\Http\Request;


class EdsaTransactionController extends AdminController
{


    public function index()
    {
        $transactions = EdsaTransaction::with('user')->get();
        
        return view('admin.edsatransaction.grid', compact('transactions'));
    }
}