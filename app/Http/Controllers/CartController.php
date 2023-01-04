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
            'user_id'=>auth()->user()->id,
        ]);
           $cart_id=Cart::where('user_id',auth()->user()->id)->first();
            Cart_Product::create(['cart_id'=>$cart_id->id,'product_id'=>$request->product_id,'quantity'=>$request->quantity]);
    DB::commit();
        return redirect()-> route('cart.cartlist');
    }















    public function cartlist(){
        $cart_id=Cart::where('user_id',auth()->user()->id)->first();
        $productList=Cart::with('products')->find($cart_id);

        return view('website.userProduct.MyCart',compact('productList'));

    }























    static function cartItem(){
        $userId= auth()->user()->id;
        return Cart::where('user_id',$userId)->count();
    }
}
