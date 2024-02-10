<?php

namespace App\Http\Controllers\Admin;

use App\Library\Grid\Grid;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\SellerDetail;
use Illuminate\Http\Request;


class SellerDetailController extends AdminController
{


    protected $savedmeters;

    public function index()
    {
        $sellers = SellerDetail::with('user')->get();
        
        return view('admin.seller.grid', compact('sellers'));
    }

    public function verify(Request $request)
    {

        $sellerdetail = SellerDetail::where('user_id',$request->id)->first();
        $productcategory = ProductCategory::where('seller_detail_id', $sellerdetail->id)->first();
        $sellerdetail->is_verified = 1;
        $productcategory->is_active = 1;
        $sellerdetail->save();
        $productcategory->save();

        $sellers = SellerDetail::with('user')->get();
        
        return view('admin.seller.grid', compact('sellers'));
        //return view('admin.seller.index');
    }

}