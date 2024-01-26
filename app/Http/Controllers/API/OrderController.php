<?php

namespace App\Http\Controllers\API;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::with('user','productOrders')->get();
        if($orders->count() > 0) {
            return response()->json([
                'status' => 200,
                'orders' => $orders
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No orders found!'
        ], 404);
    }

    public function store(Request $request) {
        $validator  = Validator::make($request->all(), [
            'user' => 'required|numeric',
            'address' => 'required|string|max:255',
            'contactNumber' => 'required|string|min:11',
            'totalAmount' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return response()-> json([
                'status'=> 422,
                'errors'=> $validator->messages(),
            ], 422);
        }

        $order = Order::create([
            'user_id' => $request->user,
            'address' => $request->address,
            'contactNumber' => $request->contactNumber,
            'totalAmount' => $request->totalAmount,
            'status'=> 'pending',
            'is_delivered'=> false
        ]);

        if($order) {
            return response()->json([
                'status'=> 200,
                'message' => 'Successfully added order to pending orders list.',
                'id'=>$order->id
            ], 201);
        }

        return response()->json([
            'status'=> 500,
            'message' => 'Internal Server Error'
        ], 500);
    }

    public function show($id) {
        $order = Order::find($id);
        if($order) {
            return response()->json([
                'status' => 200,
                'order' => $order
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No such order found'
        ], 404);
    }


    public function updateStatus(Request $request, int $id) {
        $order = Order::find($id);
        if(!$order) {
           return response()->json([
            'status'=> 404,
            'message' => 'No such order found'
        ], 404);
        }

        $order->update([
            'status'=> $request->status,
        ]);

        return response()->json([
            'status'=> 200,
            'message' => 'Successfully updated order.'
        ], 200);
    }

    public function edit(Request $request, int $id) {
        $validator  = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'contactNumber' => 'required|digits:10',
            'totalAmount'=> 'required|numeric',
            'status'=> 'required|string|max:255',
            'is_delivered'=> 'required|boolean|min:1'
        ]);
        if($validator->fails()) {
            return response()-> json([
                'status'=> 422,
                'errors'=> $validator->messages(),
            ], 422);
        }
        $order = Order::find($id);

        if($order) {
            $order->update([
                'address' => $request->address,
                'contactNumber' => $request->contactNumber,
                'quantity' => $request->description,
                'totalAmount' =>$request->totalAmount,
                'status'=> $request->status,
                'is_delivered'=> $request->is_delivered
            ]);

            return response()->json([
                'status'=> 200,
                'message' => 'Successfully updated order.'
            ], 200);
        }

        return response()->json([
            'status'=> 500,
            'message' => 'Internal Server Error'
        ], 500);

    }

    public function destroy($id) {
        $order = Order::find($id);
        if($order){
            $order->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Order removed'
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No such order found'
        ], 404);
    }
}
