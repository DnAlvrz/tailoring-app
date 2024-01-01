<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    //
    public function register (Request $request) {
        $validator  = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255',
            'date_of_birth' => 'required|date',
            'email' => 'required|email|unique:users|max:255',
            'password'=> 'required|min:8|max:100',
            'confirm_password'=> 'required|same:password',
        ]);

        if($validator->fails()) {
            return response()-> json([
                'status'=> 422,
                'errors'=> $validator->messages(),
            ], 422);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'email' =>  $request->email,
            'password' => Hash::make($request->password)
        ]);
        if($user) {
            return response()->json([
                'status'=> 201,
                'message' => 'User account registered',
                'data'=> $user
            ], 201);
        }
        return response()->json([
            'status'=> 500,
            'message' => 'Something went wrong'
        ], 500);
    }

    public function login(Request $request) {

    }
}
