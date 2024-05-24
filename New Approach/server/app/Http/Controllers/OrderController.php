<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexOrders()
    {
        $orders = Order::all();

        return response()->json(
            $orders
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->all()
            ], 422);
        }

        $order = Order::create($request->all());

        return response()->json([
            "message" => "Order created successfully",
            "order" => $order
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showOrder($id)
    {
        $order = Order::find($id);

        if(!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json(
            $order
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroyOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }
}
