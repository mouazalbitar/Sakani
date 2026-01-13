<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReviewRequest;
use App\Models\Apartment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(){}
    public function store(AddReviewRequest $request)
    {
        $userId = Auth::user()->id;
        $data = $request->validated();
        $data['tenant_id'] = $userId;
        $apartment = Apartment::findOrFail($data['apartment_id']);
        $this->authorize('create', [Review::class, $apartment]);
        $rating = Review::create($data);
        return response()->json([
            'message'=>'The Review was added Successful.',
            'data'=>$rating
        ], 201);
    }

    public function apartmentReview(Apartment $apartment){
        $reviews = Review::where('apartment_id', $apartment->id)->get();
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => $reviews
        ], 200);
    }

    public function show(Review $review){}

    public function update(Request $request, Review $review){}

    public function destroy(Review $review){}
}
