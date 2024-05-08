<?php

namespace App\Http\Controllers;

use App\Models\UserCart;
use Illuminate\Http\Request;

class UserCartController extends Controller
{
    public function getAllCartItems()
    {
        $cartItems = UserCart::all();

        return response()->json(
            $cartItems
        );
    }

    public function getCartItemsByUserId(Request $request, $userId)
    {
        $cartItems = UserCart::where('user_id', $userId)->get();
        return response()->json(
            $cartItems
        );
    }

    public function addItemToCart(Request $request)
    {
        {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $cartItem = UserCart::create($request->all());

            return response()->json([
                "Message" => "Added an Item to cart"
            ], 201);
        }
    }

    public function editCartItem(Request $request, $id)
    {
        $cartItem = UserCart::findOrFail($id);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1']
        ]);

        $cartItem->update($request->all());
        return response()->json(
            $cartItem, 200
        );
    }

    public function deleteCartItem(Request $request, $id)
    {
        $cartItem = UserCart::findOrFail($id);

        $cartItem->delete();

        return response()->json([
            'message' => 'Cart deleteted successfully'
        ], 204);
    }
}
