<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserDataRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(CreateUserRequest $request)
    {
        // Hash::make($request->password);  //hashing in Model
        $validated = $request->validated();
        if ($request->hasFile('photo')){
            $path = $request->file('photo')->store('UsersPhoto', 'public');
            $validated['photo']=$path;
        }
        if ($request->hasFile('id_img')){
            $path2 = $request->file('id_img')->store('UsersIdPhoto', 'public');
            $validated['id_img']=$path2;
        }
        $user = User::create($validated);
        return response()->json([
            'message' => 'The User has Successfully Registered.',
            'data' => $user,
            'status' => 201
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('phone_number', 'password')))
            return response()->json([
                'message' => 'Login Failed, Incorrect Phone Number or Password.',
                'status' => 401
            ]);
        $user = User::where('phone_number', $request->phone_number)
            ->with('cityData') // اسم الدالة يلي عاملة العلاقة
            ->firstOrFail();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'message' => 'Login Successful',
            'data' => $user,
            'token' => $token,
            'status' => 200
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout Successful',
            'status' => 200
        ]);
    }














    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(UpdateUserDataRequest $request)
    {
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $user->update($request->all());
        $user->makeHidden([
            'type',
            'is_approved',
            'created_at',
            'updated_at'
        ]);
        return response()->json([
            'message' => 'Updated Successful',
            'data' => $user,
            'status' => 201
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
