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
            $user = auth('web')->user();
            $order = $user->orders()->create();
            $order['Total']=$request->Total;
            $order->products()->attach($request->products);
            $order->save();
            \Cart::clear();
            return redirect()->route('cart.list')->with(['success' => trans('massage.success')]);
        } catch (\Exception $exception) {
            return $exception->getMessage();
            return redirect()->back()->withErrors(['error' => trans('massage.error')]);
        }
    }

}
