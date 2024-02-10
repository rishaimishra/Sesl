<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CartItem extends Pivot
{
    //protected $fillable = ['cart_id', 'product_id', 'name', 'quantity','price'];
	protected $fillable = ['quantity'];
	
	protected $table = 'cart_items';
	
    protected $touches = [
        'cart'
    ];
	
    public function cart()
    {
        return $this->belongsTo(Cart::class)->withDefault();
    }
}
