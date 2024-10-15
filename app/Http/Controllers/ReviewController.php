<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\review;
use App\Models\registeration;
use Nette\Utils\Strings;

use function Laravel\Prompts\error;

class ReviewController extends Controller
{
    public function AddReview(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'client_id' => 'required',
            'rating' => 'required',
            'comment' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ]);
        }

        $user = auth()->user();
        $newReview = new review();
        $newReview->user_id = $request->input('client_id');
        $newReview->reviewer = $user->id;
        $newReview->review = $request->input('comment');
        $newReview->rating = $request->input('rating');
        $newReview->save();
        return response()->json([
            'message' => 'Review Submitted'
        ], 200);
    }

    public function getReviews(String $id)
    {
        $array = [];
        $review = review::where('user_id', $id)->get();
        foreach ($review as $item) {
            $existing = registeration::where('id', $item->reviewer)->first();
            $array[] = [
                'id' => $item->id,
                'review' => $item->review,
                'rating' => $item->rating,
                'image' => $existing->profile,
                'name' => $existing->bussiness_owner
            ];
        }
        return response()->json([
            'data' => $array
        ], 200);
    }
}
