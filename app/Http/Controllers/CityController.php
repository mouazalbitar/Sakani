<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCityRequest;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => $cities
        ], 200);
    }

    public function store(AddCityRequest $request)
    {
        $city = City::create($request->validated());
        return response()->json([
            'message' => 'City Created Successfully.',
            'data' => $city
        ], 201);
    }

    public function showCities(int $id)
    {
        $cities = City::where('govId', $id)->get();
        $cities->makeHidden(['govId', 'governorate']);
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => $cities
        ], 200);
    }

    public function update(Request $request, City $city)
    {
        //
    }

    public function destroy(City $city)
    {
        //
    }
}
