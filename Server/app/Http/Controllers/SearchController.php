<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class SearchController extends Controller
{
    public function searchAllModels(Request $request)
    {
        $query = $request->input('query');

        $products = Product::search($query)->get();
        $users = User::search($query)->get();

        $results = [
            'products' => $products,
            'users' => $users
        ];

        return response()->json(
            $results
        );
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('query');

        $products = Product::search($query)->get();

        return response()->json(
            $products
        );
    }
}
