<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserDataRequest;
use App\Jobs\SendVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(CreateUserRequest $request)
    {
        // Hash::make($request->password);  //hashing in Model
        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('UsersPhoto', 'public');
            $validated['photo'] = $path;
        }
        if ($request->hasFile('id_img')) {
            $path2 = $request->file('id_img')->store('UsersIdPhoto', 'public');
            $validated['id_img'] = $path2;
        }
        $user = User::create($validated);

        return response()->json([
            'message' => 'The User has Successfully Registered, Input The Verification code.',
            'data' => $user,
            'status' => 201
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('phone_number', 'password')))
            return response()->json([
                'message' => 'Login Failed, Incorrect Phone Number or Password.',
            ], 404);
        $user = User::where('phone_number', $request->phone_number)->firstOrFail();
        if ($user->is_approved == 'waiting') {
            Auth::logout();
            return response()->json([
                'message' => 'Login Failed, Your Account has not been approved by the Admin.'
            ], 401);
        }
        if ($user->is_approved == 'disapproved') {
            Auth::logout();
            return response()->json([
                'message' => 'Login Failed, Your Account has been Rejected.'
            ], 401);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        $user->makehidden([
            'created_at',
            'updated_at'
        ]);
        return response()->json([
            'message' => 'Login Successful',
            'data' => $user,
            'token' => $token,
        ]);
    }

    public function loginAdmin(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('phone_number', 'password')))
            return response()->json([
                'message' => 'Login Failed, Incorrect Phone Number or Password.',
            ], 404);
        $user = User::where('phone_number', $request->phone_number)->firstOrFail();
        if ($user->is_approved == 0) {
            Auth::logout();
            return response()->json([
                'message' => 'Login Failed, Your Account has not been approved by the Admin.'
            ], 401);
        }
        if ($user->type == 0) {
            Auth::logout();
            return response()->json([
                'message' => 'Login Failed, Just for Admin.'
            ], 403);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'message' => 'Login Successful',
            'data' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();
        if ($token) {
            // delete via tokens relationship to avoid calling delete on token model directly
            $request->user()->tokens()->where('id', $token->id)->delete();
        }
        return response()->json([
            'message' => 'Logout Successful',
            'status' => 200
        ]);
    }





    public function acceptUser(int $id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = 'approved';
        $user->save();
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => $user
        ], 200);
    }

    public function rejectUser(int $id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = 'rejected';
        $user->save();
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => $user
        ], 200);
    }

    public function index()
    {
        $users = User::all();
        return response()->json([
            'message' => 'Complete process.',
            'data' => $users
        ], 200);
    }

    public function acceptedUsers()
    {
        $users = User::where('is_approved', 'approved')->get();
        return response()->json([
            'message' => 'Complete process.',
            'data' => $users
        ], 200);
    }

    public function rejectedUsers()
    {
        $users = User::where('is_approved', 'rejected')->get();
        return response()->json([
            'message' => 'Complete process.',
            'data' => $users
        ], 200);
    }

    public function waitingList()
    {
        $users = User::where('is_approved', 'waiting')->get();
        return response()->json([
            'message' => 'Complete process.',
            'data' => $users
        ], 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function updateProfile(UpdateUserDataRequest $request)
    {
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $user->update($request->validated());
        $user->makeHidden([
            'number_verified_at',
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

    public function update(UpdateUserDataRequest $request)
    {
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $user->update($request->validated());
        $user->makeHidden([
            'number_verified_at',
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

    // public function acceptAccount(){
    //     $userId = Auth::user()->id;
    // }
}
