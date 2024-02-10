<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

class CartController extends ApiController
{

    protected function getUserCart()
    {

        $cart = request()->user()->cart()->firstOrCreate([]);
        //$digitalAddresses = request()->user()->digitalAddresses()->with('address','address.addressArea','address.addressChiefdom','address.addressSection','addressArea','addressChiefdom','addressSection')->paginate();

        return $cart->load('products.images', 'digitalAddresses');
        //return $cart->merge($digitalAddresses)
    }

    function getCart()
    {
        return $this->genericSuccess($this->getUserCart());
    }


    function addDigitalAddress(Request $request)
    {
        $request->validate([
            'digital_address_id' => 'required|exists:digital_addresses,id',
        ]);

        $user = $request->user();
        request()->user()->cart()->update(["digital_address_id" => $request->input('digital_address_id')]);

        return $this->success('Product successfully added.', [
            'cart' => $this->getUserCart()
        ]);
        //return $this->genericSuccess($user->cart->with('cartItems')->get());

    }

    function addCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1|max:999999'
        ]);

        $user = $request->user();

        $cart = $user->cart()->firstOrCreate([]);

        $cart->products()->syncWithoutDetaching([$request->input('product_id') => ['quantity' => $request->input('quantity')]]);

        return $this->success('Product successfully added.', [
            'cart' => $this->getUserCart()
        ]);
        //return $this->genericSuccess($user->cart->with('cartItems')->get());

    }

    function updateCart(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1|max:999999',
        ]);

        $user = $request->user();

        $product = $user->cart->products()->find($request->input('product_id'));

        if ($product) {
            $product->pivot->quantity = $request->input('quantity');
            $product->pivot->save();
        }

        return $this->success('Product successfully updated.', [
            'cart' => $this->getUserCart()
        ]);
    }

    function deleteItemFromCart(Request $request)
    {

        $user = $request->user();

        //$user->cart->products()->where(['product_id'=>$request->product_id])->delete();
        $user->cart->products()->detach($request->input('product_id'));
        return $this->success('Product successfully deleted.', [
            'cart' => $this->getUserCart()
        ]);
        //return $this->genericSuccess($user->cart->with('cartItems')->get());

    }
}
