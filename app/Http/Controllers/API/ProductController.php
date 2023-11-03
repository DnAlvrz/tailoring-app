<?php

namespace App\Http\Controllers\API;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //


    public function index() {
        $products = Product::all();
        if($products->count() > 0) {
            return response()->json([
                'status' => 200,
                'products' => $products
            ], 200);
        } 
        else {
            return response()->json([
                'status' => 404,
                'message' => 'No products found!'
            ], 404);
        }
    }
    
    public function store(Request $request) {
        $validator  = Validator::make($request->all(), [
            'name' => 'required|unique:products|max:255',
            'productId' => 'required|unique:products|max:255',
            'description'=> 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
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
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
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
    }

    public function edit(Request $request, int $id) {
    }

    public function destroy ($id) {
    }


}
