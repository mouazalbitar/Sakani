<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddApartmentRequest;
use App\Http\Resources\ApartmentResource;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::all();
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => ApartmentResource::collection($apartments)
        ]);
    }

    public function avaliable_apartment()
    {
        $apartments = Apartment::where('is_approved', 'approved')->get();
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => ApartmentResource::collection($apartments)
        ]);
    }

    public function waitingList()
    {
        $apartments = Apartment::where('is_approved', 'waiting')->get();
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => ApartmentResource::collection($apartments)
        ]);
    }

    public function rejectedList()
    {
        $apartments = Apartment::where('is_approved', 'rejected')->get();
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => ApartmentResource::collection($apartments)
        ]);
    }

    public function accept_apartment(int $id)
    {
        $apartment = Apartment::findOrFail($id);
        $apartment->is_approved = 'approved';
        $apartment->save();
        return response()->json([
            'message'=>'Complete Successfully.',
            'data'=>ApartmentResource::collection($apartment)
        ], 200);
    }
    public function reject_apartment(int $id)
    {
        $apartment = Apartment::findOrFail($id);
        $apartment->is_approved = 'rejected';
        $apartment->save();
        return response()->json([
            'message'=>'Complete Successfully.',
            'data'=>ApartmentResource::collection($apartment)
        ], 200);
    }


    public function add_apartment(AddApartmentRequest $request)
    {
        $userId = Auth::user()->id;
        $data = $request->validated();
        $data['owner_id'] = $userId;
        if ($request->hasFile('img1')) {
            $path = $request->file('img1')->store('ApartmentsPhoto', 'public');
            $data['img1'] = $path;
        }
        if ($request->hasFile('img2')) {
            $path2 = $request->file('img2')->store('ApartmentsPhoto', 'public');
            $data['img2'] = $path2;
        }
        if ($request->hasFile('img3')) {
            $path3 = $request->file('img3')->store('ApartmentsPhoto', 'public');
            $data['img3'] = $path3;
        }
        $apartment = Apartment::create($data);
        return response()->json([
            'message' => 'The Apartment has Successfully Added',
            'data' => $apartment,
            'status' => 200
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
