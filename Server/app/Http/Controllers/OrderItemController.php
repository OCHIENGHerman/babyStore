<?php

namespace App\Http\Controllers;

use App\Models\Order_Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexOrderItems()
    {
        $orderItems = Order_Item::all();

        return response()->json(
            $orderItems
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function storeOrderItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', 'exists:orders,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer'],
            'unit_price' => ['required', 'integer'],
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $orderItem = Order_Item::create($request->all());

        return response()->json([
            "message" => "Order item created successfully",
            "OrderItem" => $orderItem
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showOrderItem($id)
    {
        $orderItem = Order_Item::find($id);

        if (!$orderItem) {
            return response()->json([
                'message' => 'Order item not found'
            ], 404);
        }

        return response()->json(
            $orderItem
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOrderItem(Request $request, $id)
    {
        $orderItem = Order_Item::find($id);

        if (!$orderItem) {
            return response()->json([
                'message' => 'Order item not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => ['integer'],
            'unit_price' => ['integer'],
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        $orderItem->update($request->all());
        $orderItem->save();

        return response()->json([
            "message" => "Order item updated successfully",
            "OrderItem" => $orderItem
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyOrderItem($id)
    {
        $orderItem = Order_Item::find($id);

        if (!$orderItem) {
            return response()->json([
                'message' => 'Order item not found'
            ], 404);
        }

        $orderItem->delete();

        return response()->json([
            "message" => "Order item deleted successfully"
        ], 200);
    }
}
