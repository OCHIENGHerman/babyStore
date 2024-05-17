<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexCategories()
    {
        $categories = Category::all();

        return response()->json(
            $categories
        );
    }

    public function singleCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'category not found'
            ], 404);
        }

        return response()->json(
            $category
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }

        Category::create([
            'name' => $request->name,
        ]);

        return response()->json([
            "message" => "Category created successfully",
            "category" => $category
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editCategory(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCategory(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'category not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $category->name = $request->input('name');
        $category->save();

        return response()->json([
            'message' => 'category updated successfully',
            'category' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    // FindorFail
    // $category = Category::findOrFail($id); 
    // Check on it later and catch exceptions 

    // try {
    //     $category = Category::findOrFail($id);
    //     $category->delete();
    
    //     return response()->json([
    //         'message' => 'Category deleted successfully'
    //     ]);
    // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //     return response()->json([
    //         'message' => 'Category not found'
    //     ], 404);
    // }
     public function destroyCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'category not found'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'category deleted successfully'
        ]);
    }
}
