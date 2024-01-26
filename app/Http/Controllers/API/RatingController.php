<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\OrderRating;

class RatingController extends Controller
{
    //
    public function index() {
        $ratings = OrderRating::all();
        if($ratings->count() > 0) {
            return response()->json([
                'status' => 200,
                'ratings' => $ratings
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No ratings found!'
        ], 404);
    }

    public function store(Request $request) {
        $validator  = Validator::make($request->all(), [
            'order_id' => 'required|numeric',
            'rating'=> 'required|numeric',
        ]);

        if($validator->fails()) {
            return response()-> json([
                'status'=> 422,
                'errors'=> $validator->messages(),
            ], 422);
        }


        $rating = OrderRating::create([
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'message' => isset($request->message) ? $request->message : '' ,

        ]);

        if($rating) {
            return response()->json([
                'status'=> 201,
                'message' => 'Successfully added rating to order.'
            ], 200);
        }

        return response()->json([
            'status'=> 500,
            'message' => 'Internal Server Error'
        ], 500);
    }

    public function show(int $id) {
        $rating = OrderRating::find($id);

        if($product) {
            return response()->json([
                'status' => 200,
                'rating' => $rating
            ], 200);
        }
        else {
            return response()->json([
                'status' => 404,
                'message' => 'No such rating found'
            ], 404);
        }
    }

    public function edit(Request $request, int $id) {
        $validator  = Validator::make($request->all(), [
            'rating' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return response()-> json([
                'status'=> 422,
                'errors'=> $validator->messages(),
            ], 422);
        }

        $rating = OrderRating::find($id);

        if($rating) {
            $rating->update([
                'rating' => $request->rating,
                'message' => isset($request->message) ? $request->message : '' ,
            ]);

            return response()->json([
                'status'=> 200,
                'message' => 'Successfully updated rating.'
            ], 200);
        }

        return response()->json([
            'status'=> 500,
            'message' => 'Internal Server Error'
        ], 500);
    }

    public function destroy ($id) {
        $rating = OrderRating::find($id);
        if($rating){
            $rating->delete();
            return response()->json([
                'status' => 204,
                'message' => 'Rating removed'
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No such rating found'
        ], 404);
    }
}
