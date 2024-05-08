<?php

namespace App\Http\Controllers;

use App\Models\UserCart;
use Illuminate\Http\Request;

class UserCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllCartItems()
    {
        $cartItems = UserCart::all();

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

    public function getAllCartItemsByUserId($userId)
    {
        $cartItems = UserCart::where('user_id', $userId)->get();
        return response()->json(
            $cartItems
        );
    }

    public function editCartItem(Request $request)
    {
       $cartItem = UserCart::findOrFail($id);

       $request->validate([
        'quantity' => ['required', 'integer', 'min:1'],
       ]);

       $cartItem->update($request->all());
       return response()->json($cartItem, 200);
    }

    public function deleteCartItem($id)
    {
        $cartItem = UserCart::findOrFail($id);

        $cartItem->delete();

        return response()->json([
            'message' => 'Cart deleted'
        ], 204);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserCart $userCart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserCart $userCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserCart $userCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserCart $userCart)
    {
        //
    }
}
