<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cart_Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    public function addToMyCart(Request $request)
    {

        DB::beginTransaction();
        Cart::updateOrCreate([
            'user_id' => auth()->user()->id,
        ]);
        $cart_id = Cart::where('user_id', auth()->user()->id)->first();
        Cart_Product::create(['cart_id' => $cart_id->id, 'product_id' => $request->product_id, 'quantity' => $request->quantity]);
        DB::commit();
        return redirect()->route('cart.cartlist');
    }


    public function cartlist()
    {
        $cart_id = Cart::where('user_id', auth()->user()->id)->first();
        $productList = Cart::with('products')->find($cart_id);
        return view('website.userProduct.MyCart', compact('productList'));
    }


    public function removeCart($product_id)
    {
        Cart_Product::where('product_id', $product_id)->delete();
        return redirect()->back();
    }

    public function updateCart(Request $request)
    {

        Cart_Product::where('product_id', $request->id)->update([
            'quantity' => $request->quantity,
        ]);
        return redirect()->back();
    }


    static function cartItem()
    {
        $userId = auth()->user()->id;
        return Cart::where('user_id', $userId)->count();
    }




    public function clearAllCart(Request $request)
    {
        $product_cart= Cart_Product::where('product_id', $request->id)->first();
        Cart::where('id',$product_cart->cart_id)->delete();
        return redirect()->route('home');
    }
}
