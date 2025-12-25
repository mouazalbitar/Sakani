<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddGovernorateRequest;
use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{

    public function index()
    {
        $gov = Governorate::all();
        return response()->json([
            'message' => 'Complete Successfully.',
            'data'=>$gov
        ], 200);
    }

    public function store(AddGovernorateRequest $request)
    {
        $gov = Governorate::create($request->validated());
        return response()->json([
            'message' => 'Governorate Added Successfully',
            'data' => $gov
        ], 201);
    }

    public function update(AddGovernorateRequest $request, int $id){
        $gov = Governorate::findOrFail($id);
        $gov->update($request->validated());
        return response()->json([
            'message' => 'Governorate Updated Successfully',
            'data' => $gov
        ], 200);
    }
}
