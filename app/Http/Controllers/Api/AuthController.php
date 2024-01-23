<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(AuthLoginRequest $request)
    {
        try {
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Mật khẩu không chính xác',
                    'errors' => [
                        'password' => [
                            'Mật khẩu không chính xác'
                        ]
                    ]
                ], 403);
            }

            $user = User::where('email', '=', $request->input('email'))->first();
            $user->last_login_at = Carbon::now();
            $user->last_login_ip = $request->ip();
            $user->save();

            $exp = now()->addWeek();
            $cookie = cookie(
                'token',
                $user->createToken("API_TOKEN", ['*'], $exp)->plainTextToken,
                now()->diffInMinutes($exp) // to minutes
            );

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Đăng nhập thành công',
            ], 200)->withCookie($cookie);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Logout the User
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logoutUser(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            $cookie = cookie(
                'token',
                null,
                0,
            );

            return response()->json([
                'status' => true,
                'message' => 'Đăng xuất thành công',
            ], 200)->withCookie($cookie);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
