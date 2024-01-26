<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Models\Order;
class ProductOrderController extends Controller
{
    public function index() {
        $product_orders = ProductOrder::all();
        if($product_orders->count() > 0) {
            return response()->json([
                'status' => 200,
                'productOrders' => $product_orders
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No product orders found!'
        ], 404);
    }

    public function store(Request $request) {
        $order = Order::find($request->order_id);

        if(!$order){
            return response()->json([
                'status' => 404,
                'error' => 'Invalid Order'
            ], 404);
        }

        $product_orders = [];

        foreach ($request->products as $key=>$product){
            $product_order = Product::find($product['id']);
            if($product_order && $product_order->quantity >= $product['quantity'] ) {
                array_push($product_orders, $request->products[$key]);
            }
            else if ($product_order && $product_order->quantity < $product['quantity'] ) {
                return response()-> json([
                    'status'=> 422,
                    'errors'=>'Order invalid. Product quantity insuffucient',
                ], 422);
            }
            else {
                return response()-> json([
                    'status'=> 422,
                    'errors'=>'Order Invalid. Product not found',
                ], 422);
            }

        }

        $new_product_orders = [];

        if($request->order_id && count($product_orders) > 0) {
            foreach($product_orders as $product) {
                $new_product_order = ProductOrder::create([
                    'order_id' => $order->id,
                    'name' => $product['name'],
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'total'=> $product['total']
                ]);
                if(!$new_product_order) {
                    return response()->json([
                        'status'=> 500,
                        'error' => 'Internal Server Error'
                    ], 500);
                }
                array_push($new_product_orders, $new_product_order);
            }
        }

        if(count($new_product_orders) == count($request->products)) {
            return response()->json([
                'status'=> 201,
                'message' => 'Product orders created',
                'newProductOrders'=> $new_product_orders
            ], 201);
        }
        return response()->json([
            'status'=> 500,
            'error' => 'Internal Server Error'
        ], 500);
    }


    public function delete($id) {
        $product_order = ProductOrder::find($id);
        if($product_order){
            $product_order->delete();
            return response()->json([
                'status' => 204,
                'error' => 'Product order removed'
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No such product order found'
        ], 404);
    }
    public function edit(Request $request, int $id) {

    }
    public function show($id) {
        $product_order = ProductOrder::find($id);
        if($product_order) {
            return response()->json([
                'status' => 200,
                'productOrder' => $product_order
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No such product order found'
        ], 404);
    }
}
