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

        $otp = (string) rand(100000, 999999);
        // صلاحية الرمز 5 دقائق
        Cache::put('otp_' . $user->phone_number, $otp, now()->addMinutes(5));

        // 2. إرسال الوظيفة إلى قائمة الانتظار
        SendVerification::dispatch($user->phone_number, $otp);
        return response()->json([
            'message' => 'The User has Successfully Registered, Input The Verification code.',
            'data' => $user,
            'status' => 201
        ]);
    }


    // AuthController.php

    public function verifyWhatsapp(Request $request)
    {
        $request->validate([
            // إزالة القيود المحلية، والاكتفاء بالتحقق من وجوده في جدول المستخدمين
            'phone_number' => 'required|string|exists:users,phone_number',
            'otp' => 'required|numeric|digits:6',
        ]);

        $storedOtp = Cache::get('otp_' . $request->phone_number);

        if (!$storedOtp || $storedOtp != $request->otp) {
            return response()->json(['message' => 'فشل التحقق. الرمز المدخل غير صحيح أو انتهت صلاحيته.'], 400);
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        // تحديث حقل التحقق
        $user->phone_number_verified_at = now();
        $user->save();

        // إزالة الرمز من الكاش
        Cache::forget('otp_' . $request->phone_number);

        // تسجيل الدخول ومنح التوكن (بعد نجاح التحقق)

        return response()->json([
            'message' => 'تم تأكيد رقم الهاتف بنجاح وتم تسجيل الدخول.',
            'user' => $user,
        ], 200);
    }


    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('phone_number', 'password')))
            return response()->json([
                'message' => 'Login Failed, Incorrect Phone Number or Password.',
            ], 404);
        $user = User::where('phone_number', $request->phone_number)
            ->with('cityData') // اسم الدالة يلي عاملة العلاقة
            ->firstOrFail();
        if ($user->is_approved == 0) {
            Auth::logout();
            return response()->json([
                'message' => 'Login Failed, Your Account has not been approved by the Admin.'
            ], 401);
        }
        $token = $user->createToken('authToken')->plainTextToken;
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
        $user = User::where('phone_number', $request->phone_number)
            ->with('cityData') // اسم الدالة يلي عاملة العلاقة
            ->firstOrFail();
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
















    public function acceptUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = 1;
        $user->save();
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => $user
        ], 201);
    }






    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->type == 0) {
            return response()->json([
                'message' => 'unauthorized.'
            ], 403);
        }
        $users = User::all();
        return response()->json([
            'message' => 'Complete process',
            'data' => $users
        ], 200);
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
