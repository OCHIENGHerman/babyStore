<?php

namespace App\Http\Controllers;

use App\Models\UserCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->only(
            'user_id', 'product_id', 'name', 'image_url', 'price'
        ), [
            'user_id' => ['required', 'exists:users,id'],
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'string'],
            'image_url' => ['required', 'string'],
            'price' => ['required', 'integer'],
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }

        UserCart::create([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            'name' => $request->input('name'),
            'image_url' => $request->input('image_url'),
            'price' => $request->input('price'),
        ]);

        return response()->json([
            "Message" => "Item Added To Cart"
        ]);
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
