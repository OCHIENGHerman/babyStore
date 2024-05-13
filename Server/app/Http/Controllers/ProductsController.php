<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function show()
    {
        $products = Products::all();

        return response()->json(
            $products
        );
    }

    public function singleProduct($id)
    {
        $singleProduct = Products::find($id);

        if (!$singleProduct){
            return response()->json([
                "message" => "Product not found"
            ]);
        }

        return response()->json(
            $singleProduct
        );
    }


    //Admin add products

    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->only('name', 'description', 'image_url', 'price','quantity', 'category_id'),[
            'name' => ['required', 'max:50', 'string'],
            'description' => ['required', 'string'],
            'image_url' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'category_id' => ['required', 'exists:categories,id']
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }

        Products::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image_url' => $request->input('image_url'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'category_id' => $request->input('category_id')
        ]);

        return response()->json([
            "Message" => "Product Added"
        ]);
    }

    public function editProduct (Request $request)
    {
        $product = Products::where('id', $request->input('id'))->first();

        if ($product){
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->image_url = $request->input('image_url');
            $product->price = $request->input('price');
            $product->quantity = $request->input('quantity');
            $product->category_id = $request->input('category_id');

            $product->save();

            return response()->json([
                'message' => 'product details updated'
            ]);
        }else{
            return response()->json([
                'message' => 'product not found'
            ]);
        }
    }

    public function deleteProduct($id)
    {
        $product = Products::find($id);

        $product->delete();

        return response()->json([
            'message' => 'product deleted'
        ]);
    }
}
