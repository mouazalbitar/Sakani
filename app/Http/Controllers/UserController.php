<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserDataRequest;
use App\Models\FcmToken;
use App\Models\User;
use App\Services\WhatsAppService;
use App\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(CreateUserRequest $request, WhatsAppService $whatsAppService)
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
        $phone = ltrim($validated['phone_number'], '+0');
        $isWhatsAppUser = $whatsAppService->checkPhoneExistence($phone);
        if (!$isWhatsAppUser) {
            return response()->json([
                'message' => 'This phone number doesn\'t has Whatsapp Account.'
            ], 422);
        }
        $otp = rand(100000, 999999);
        $validated['verification_code'] = $otp;
        $validated['verification_code_expires_at'] = Carbon::now()->addMinutes(5);
        User::create($validated);
        $message = "Your verification code is: {" . $otp . '}, Don\'t share it with any one!!';
        $whatsAppService->sendMessage($phone, $message);
        return response()->json([
            'message' => 'The User has Successfully Registered, Input The Verification code.'
        ], 201);
    }

    public function verifyOtp(Request $request)
    {
        // التحقق من المدخلات
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|numeric',
        ]);

        $user = User::find($request->user_id);

        // 1. هل الكود مطابق؟
        if ($user->verification_code != $request->otp) {
            return response()->json(['message' => 'رمز التحقق خاطئ'], 400);
        }

        // 2. هل انتهت صلاحية الـ 5 دقائق؟
        if (Carbon::now()->greaterThan($user->verification_code_expires_at)) {
            return response()->json(['message' => 'انتهت صلاحية الرمز، يرجى طلب رمز جديد'], 400);
        }

        // 3. نجاح التحقق: نمسح الكود من الداتابيز (لأمان أكثر)
        $user->update([
            'verification_code' => null,
            'verification_code_expires_at' => null
        ]);

        // 4. إصدار التوكن للدخول
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'تم التحقق من الرقم بنجاح.',
            'access_token' => $token,
            'user' => $user
        ], 200);
    }

    public function resendOtp(Request $request, WhatsAppService $whatsAppService)
    {
        // 1. التحقق من وجود المستخدم
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);

        // 2. توليد كود جديد وتحديث وقت الانتهاء
        $newOtp = rand(100000, 999999);

        $user->update([
            'number_verified_at' => now(), // توثيق وقت التحقق
            'verification_code' => null,
            'verification_code_expires_at' => null
        ]);

        // 3. تنظيف الرقم وإرسال الرسالة مجدداً
        $phone = ltrim($user->phone_number, '+0');
        $message = "رمز التحقق الجديد الخاص بك هو: " . $newOtp . " (صالح لمدة 5 دقائق)";

        try {
            $whatsAppService->sendMessage($phone, $message);
            return response()->json([
                'message' => 'تم إعادة إرسال كود جديد إلى واتساب بنجاح.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'فشل إرسال الرسالة، يرجى المحاولة لاحقاً.'
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('phone_number', 'password')))
            return response()->json([
                'message' => 'Login Failed, Incorrect Phone Number or Password.',
            ], 404);
        $user = User::where('phone_number', $request->phone_number)->firstOrFail();

        // if($user->status != UserStatus::APPROVED) {
        //     return response()->json([
        //         'message' => UserStatus::loginMessage($status);
        //     ], 403);
        // }

        if ($user->is_approved == 'waiting') {
            Auth::logout();
            return response()->json([
                'message' => 'Login Failed, Your Account has not been approved by the Admin.'
            ], 403);
        }
        if ($user->is_approved == 'rejected') {
            Auth::logout();
            return response()->json([
                'message' => 'Login Failed, Your Account has been Rejected.'
            ], 403);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        $user->makehidden([
            'created_at',
            'updated_at'
        ]);
        return response()->json([
            'message' => 'Login Successful', // use helper
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
        if ($user->is_approved == 'waiting' || $user->is_approved == 'rejected') {
            Auth::logout();
            return response()->json([
                'message' => 'Login Failed, Your Account has not been approved.'
            ], 403);
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
        FcmToken::where('token', $request->token)->delete();
        return response()->json([
            'message' => 'Logout Successful'
        ], 204);
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
            'message' => 'Complete Process.',
            'data' => $users
        ], 200);
    }

    public function rejectedUsers()
    {
        $users = User::where('is_approved', 'rejected')->get();
        return response()->json([
            'message' => 'Complete Process.',
            'data' => $users
        ], 200);
    }

    public function waitingList()
    {
        $users = User::where('is_approved', 'waiting')->get();
        return response()->json([
            'message' => 'Complete Process.',
            'data' => $users
        ], 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function showUser(int $id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => $user
        ], 200);
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

    public function destroy(string $id)
    {
        //
    }
}
