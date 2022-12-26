<?php

namespace App\Http\Controllers\Users\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

class OrderController extends Controller
{
    public function addOrder(OrderRequest $request)
    {
        try {
            $order = new Order();
            $order->user_id=$request->user_id;
            $order->save();
            $order_id=$order->id;

            $orderproduct = new OrderProduct();
            $orderproduct->order_id = $order_id;
            $orderproduct->product_id = $request->product_id;
            $orderproduct->quantity = $request->quantity;
            $orderproduct->save();
            return redirect()->route('cart.list')->with(['success' => trans('massage.success')]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => trans('massage.error')]);
        }
    }

}
