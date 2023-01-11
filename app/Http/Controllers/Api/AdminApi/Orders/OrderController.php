<?php

namespace App\Http\Controllers\Api\AdminApi\Orders;

use App\Http\Controllers\Api\GeneralApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderResource;
use App\Models\Order;
use PHPUnit\Exception;

class OrderController extends Controller
{
    use GeneralApiTrait;
    public function ShowIndex(){
        $orders=Order::with('products')->get();
        return $this->returnData( 'Orders',OrderResource::collection($orders)  ,"ok");
    }
    public function showDetails($order_id){

        $orders =Order::find($order_id);
        if (!$orders){
            return $this->returnError( 401,"this Order does not exits");
        }
         $products=$orders->products;

        return $this->returnData('products', OrderResource::collection($products)  ,"ok");
    }
    public function destroy($id){
        try {
            $orders=Order::find($id);
            if (!$orders){
                return $this->returnError( 401,"this Order does not exits");
            }
            $orders->delete();
            return $this->returnSuccessMessage( "Order Deleted Successful",200);
        }catch (Exception $exception){
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }

    public function changeStatusToPay($order_id){

        try {
            $order = Order::find($order_id);
            if (!$order) {
                return $this->returnError( 401,"this Order does not exits");
            }
            $active = $order->status == 'pending' ? 'pay' : 'pending';
            $order->update([$order->status=$active]);
            return $this->returnSuccessMessage( " Status changed To Pay Successful",200);

        } catch (\Exception $exception) {
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }

    }

    public function changeStatusToDelivered($order_id){

        try {
            $order = Order::find($order_id);
            if (!$order) {
                return $this->returnError( 401,"this Order does not exits");
            }
            $active = $order->status == 'pay' ? 'deliveried' : 'pending';
            $order->update([$order->status=$active]);
            return $this->returnSuccessMessage (" Status changed To Delivered Successful",200);

        } catch (\Exception $exception) {
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }

    }

}
