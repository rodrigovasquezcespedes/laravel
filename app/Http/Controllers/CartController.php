<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        return $cart->load('items.product');
    }

    public function add(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $item = $cart->items()->updateOrCreate(
            ['product_id' => $data['product_id']],
            ['quantity' => $data['quantity']]
        );
        return $item->load('product');
    }

    public function remove(Request $request, $itemId)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $item = $cart->items()->findOrFail($itemId);
        $item->delete();
        return response()->noContent();
    }

    public function clear(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $cart->items()->delete();
        return response()->noContent();
    }
}
