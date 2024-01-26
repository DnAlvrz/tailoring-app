<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function userOrders(int $id) {
        $user =  User::with(['orders', 'orders.productOrders'])->find($id);
        $orders = $user->orders;
        if(!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'No user found!'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'orders' => $orders
        ], 200);
    }
}
