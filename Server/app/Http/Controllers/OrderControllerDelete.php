<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        //get the current user id
        $user = Auth::user();
        $user_id = $user->id;

        $order_details = Orders::create([
            'user_id' => $user_id,
            'tax' => $request->input('tax'),
            'total_amount' => $request->input('total_amount')
        ]);

        //retrieve the order id
        $order_id = $order_details->id;


        $createdOrderItem = [];

        //create order items for each item in the request

        foreach($request->input('items') as $item){
            
            $order_item = OrderItem::create([
                'product_id' => $item['product_id'],
                'order_id' => $order_id,
                'price' => $item['price']   //accessing price direct from array
            ]);

            $createdOrderItem[] = $order_item;
        }


        return response()->json($createdOrderItem);

    }

    public function numberOfOrders()
    {
        $orders = Orders::all();

        return count($orders);
    }
}
