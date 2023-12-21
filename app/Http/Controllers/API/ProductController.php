<?php

namespace App\Http\Controllers\API;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        if($products->count() > 0) {
            return response()->json([
                'status' => 200,
                'products' => $products
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No products found!'
        ], 404);
    }

    public function store(Request $request) {

        $validator  = Validator::make($request->all(), [
            'name' => 'required|unique:products|max:255',
            'productId' => 'required|unique:products|max:255',
            'description'=> 'required',
            'category'=> 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'images' => 'required|array'
        ]);

        if($validator->fails()) {
            return response()-> json([
                'status'=> 422,
                'errors'=> $validator->messages(),
            ], 422);
        }


        $product = Product::create([
            'name' => $request->name,
            'productId' => $request->productId,
            'category' => $request->category,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'images' => $request->images
        ]);

        if($product) {
            return response()->json([
                'status'=> 200,
                'message' => 'Successfully added product to product list.'
            ], 200);
        }

        return response()->json([
            'status'=> 500,
            'message' => 'Internal Server Error'
        ], 500);
    }

    public function show($id) {
        $product = Product::find($id);

        if($product) {
            return response()->json([
                'status' => 200,
                'product' => $product
            ], 200);
        }
        else {
            return response()->json([
                'status' => 404,
                'message' => 'No such product found'
            ], 404);
        }
    }

    public function edit(Request $request, int $id) {
        $validator  = Validator::make($request->all(), [
            'name' => 'required|unique:products|max:255',
            'productId' => 'required|max:255',
            'description'=> 'required',
            'category'=> 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return response()-> json([
                'status'=> 422,
                'errors'=> $validator->messages(),
            ], 422);
        }

        $product = Product::find($id);

        if($product) {
            $product->update([
                'name' => $request->name,
                'productId' => $request->productId,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'category' => $request->category,
                'price' => $request->price,
            ]);

            return response()->json([
                'status'=> 200,
                'message' => 'Successfully updated product.'
            ], 200);
        }

        return response()->json([
            'status'=> 500,
            'message' => 'Internal Server Error'
        ], 500);
    }

    public function destroy ($id) {
        $product = Product::find($id);
        if($product){
            $product->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Product removed'
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No such product found'
        ], 404);
    }


}
