<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function ShowIndex(){
        $orders=Order::with('products')->get();
//        return  dd($orders);
        return view('admin.Orders.index',compact('orders'));
    }
    public function showDetails($order_id){

        $orders =Order::find($order_id);
        if (!$orders){
            return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
        }
          $orders=Order::with('products')->get();
//        return dd($orders);
        return view('admin.Orders.show',compact('orders'));

    }

}