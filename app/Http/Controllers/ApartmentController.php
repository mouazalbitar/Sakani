<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddApartmentRequest;
use App\Http\Resources\ApartmentResource;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::all();
        return response()->json([
            'message'=>'The Operation was Successful.',
            'data'=>ApartmentResource::collection($apartments)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddApartmentRequest $request)
    {
        $userId = Auth::user()->id;
        $data = $request->validated();
        $data['owner_id'] = $userId;
        $apartment = Apartment::create($data);
        return response()->json([
            'message'=>'The Apartment has Successfully Added',
            'data'=>$apartment,
            'status'=>200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}
