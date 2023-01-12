<?php

namespace App\Http\Controllers\Api\UserApi\Order;

use App\Http\Controllers\Api\GeneralApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use GeneralApiTrait;
    public function addOrder(Request $request)
    {

        try {
            DB::beginTransaction();
            $user = auth()->guard('user-api')->user();

            $cart_id = Cart::where('user_id', auth()->guard('user-api')->user()->id)->first();
            $productList = Cart::with('products')->find($cart_id);
            $total=0;
            foreach ($productList as $products)
                foreach($products -> products as $product)
                    $total +=$product->pivot->quantity * $product->price;
            $order = $user->orders()->create(['Total' => $total]); // insert into orders table user id and total price
//            $order->products()->attach($request->products); add products with attach method
            $products=$request->products;
            $quantities=$request->quantity;
            for ($i=0; $i<count($products); $i++){
                $product=Product::where('id',$products[$i])->first();
                // update base table product add new quantity after insert order quantity
                $product->update(['quantity'=>$product->quantity-$quantities[$i]]);
                //insert into orderProduct order id product id and quantity for only product
                OrderProduct::create(['order_id'=>$order->id,'product_id'=>$products[$i],'quantity'=>$quantities[$i]]);
            }
            Cart::where('user_id', auth()->user()->id)->delete();
            DB::commit();
            return $this->returnSuccessMessage('Your Orders Added Successful',201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->returnError( 404, $exception->getMessage()." some thing wrong please try later");
        }
    }
}
