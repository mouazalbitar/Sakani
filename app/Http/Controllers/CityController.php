<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        //
    }

    public function show(City $city)
    {
        //
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
