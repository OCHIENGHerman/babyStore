<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexCarts()
    {
        $carts = Cart::all();

        return response()->json(
            $carts
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function storeCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'min:1'],
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $cart = Cart::create($request->all());

        return response()->json([
            "message" => "Product added to cart successfully",
            "Cart" => $cart
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showCart($id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json([
               'message' => 'Cart not found'
            ], 404);
        }

        return response()->json(
            $cart
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCart(Request $request, $id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json([
                'message' => 'Cart not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => ['required', 'min:1']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json([
            'message' => 'Cart updated successfully',
            'Cart' => $cart
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCart($id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json([
                'message' => 'Cart not found'
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'message' => 'Cart deleted successfully'
        ]);
    }
}
