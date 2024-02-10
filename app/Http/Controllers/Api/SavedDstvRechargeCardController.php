<?php

namespace App\Http\Controllers\Api;


use App\Models\SavedDstvRechargeCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



class SavedDstvRechargeCardController extends ApiController
{

    protected function getUserSavedRechargeCards()
    {
        return request()->user()->saveddstvrechargecards();
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $saveddstvrechargecards = SavedDstvRechargeCard::where('user_id',$user->id)->get();
        return $this->success('', [
            'saveddstvrechargecards' => $saveddstvrechargecards
        ]);
    }

    public function create(Request $request)
    {
        $saveddstvrechargecard = new SavedDstvRechargeCard();

        $user = $request->user();
        $saveddstvrechargecard->user_id = $user->id;
        $saveddstvrechargecard->recharge_card_number = $request->recharge_card_number;
        $saveddstvrechargecard->recharge_card_name = $request->recharge_card_name;
        $saveddstvrechargecard->save();

        return $this->success("Success", [
        ]);


    }

    public function delete(Request $request) {
        $id = $request->id;
        $saveddstvrechargecard = SavedDstvRechargeCard::find($id);
        $saveddstvrechargecard->delete();
        
        return $this->success("Success", [
        ]);
    }
}