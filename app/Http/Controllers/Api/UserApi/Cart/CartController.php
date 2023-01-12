<?php

namespace App\Http\Controllers\Api\UserApi\Cart;

use App\Http\Controllers\Api\GeneralApiTrait;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Cart_Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    use GeneralApiTrait;
    public function addToMyCart(Request $request)
    {

//        dd($request);
        try {
            DB::beginTransaction();
            Cart::updateOrCreate([
                'user_id' => auth()->guard('user-api')->user()->id,
            ]);

            $cart_id = Cart::where('user_id', auth()->guard('user-api')->user()->id)->first();

              $product= Cart_Product::where('cart_id',$cart_id->id)->where('product_id', $request->product_id)->first();
            if($product){
                if ($product->product_id == $request->product_id){
                    Cart_Product::where('cart_id',$cart_id->id)->where('product_id', $request->product_id)->update([
                        'quantity' => $request->quantity +$product->quantity ,
                    ]);
                }
            }
           else{
                Cart_Product::create([
                    'cart_id' => $cart_id->id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity
                ]);
            }
            DB::commit();
            return $this->returnSuccessMessage('The Product Added To Your Cart Successful','201');

        } catch (\Exception $exception) {
            return $this->returnError('Some Thing Went Wrong ','4001');
        }

    }


//    public function cartlist()
//    {
//        try {
//            $cart_id = Cart::where('user_id', auth()->guard('user-api')->user()->id)->get();
//            return $cart_id;
//            $productList = Cart::with('products')->find($cart_id);
//
////            return view('website.userProduct.MyCart', compact('productList'));
//            return $this->returnData('productList',$productList,'ok');
//        } catch (\Exception $exception) {
//            return $this->returnError($exception->getMessage().'Some Thing Went Wrong ','4001');
//        }
//
//    }
    public function cartlist()
    {
        try {
            $cart_id = Cart::where('user_id', auth()->guard('user-api')->user()->id)->first();

            $productList = Cart::with('products')->find($cart_id);

//            return view('website.userProduct.MyCart', compact('productList'));
            return $this->returnData('productList',$productList,'ok');
        } catch (\Exception $exception) {
            return $this->returnError('Some Thing Went Wrong ','4001');
        }

    }


    public function removeCart($product_id)
    {
        try {
            Cart_Product::where('product_id', $product_id)->delete();
            return $this->returnSuccessMessage('The Product Deleted Successful In Your Cart','201');
        } catch (\Exception $exception) {
            return $this->returnError('Some Thing Went Wrong ','4001');
        }

    }

    public function updateCart(Request $request)
    {

        try {
            $cart_id = Cart::where('user_id', auth()->guard('user-api')->user()->id)->first();
            Cart_Product::where('cart_id',$cart_id->id)->where('product_id', $request->id)->update([
                'quantity' => $request->quantity,
            ]);
            return $this->returnSuccessMessage('The Product Quantity Updated Successful','201');
        } catch (\Exception $exception) {
            return $this->returnError($exception->getMessage().' Some Thing Went Wrong ','4001');
        }

    }


    static function cartItem()
    {
        try {
            if (!empty(auth()->user())) {
                $userId = auth()->user()->id;
                $products = Cart::where('user_id', $userId)->first();
                $count= Cart_Product::where('cart_id', $products->id)->with('products')->count();
                if (!empty($count)){
                    return $count;
                }
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
            return redirect()->back()->withErrors(['error' => trans('massage.error')]);
        }

    }


    public function clearAllCart(Request $request)
    {
        try {
            Cart::where('id',$request->id)->where('user_id',auth()->guard('user-api')->user()->id)->delete();
            return $this->returnSuccessMessage('Your Cart Is Cleared Successful','201');
        } catch (\Exception $exception) {
            return $this->returnError($exception->getMessage().'Some Thing Went Wrong ','4001');
        }

    }
}
