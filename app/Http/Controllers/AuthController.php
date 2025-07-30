<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(StoreUserRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'username' => 'required|unique:users,username',
        //     'password' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'failed',
        //         'message' => 'maaf username/passwordmu tidak valid'
        //     ]);
        // }

        // $password = Hash::make($request->password);

        // $user = User::create([
        //     'username' => $request->username,
        //     'password' => $password,
        // ]);

        // $token = $user->createToken('auth-token')->plainTextToken;

        // return response()->json([
        //     'status' => 'sukses',
        //     'username' => $request->username,
        //     'token' => $token,
        // ]);

        try {
            return ResponseHelper::success($this->userService->HandleSignUp($request), 'kamu berhasil register');
        } catch (\Throwable $thrw) {
            return ResponseHelper::error(message: $thrw->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'username' => 'required',
        //     'password' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'failed',
        //         'message' => 'maaf username/passwordmu tidak valid',
        //     ]);
        // }

        try {
            // $user = User::where('username', $request->username)->first();
            // $token = $user->createToken('auth-token')->plainTextToken;
            // return response()->json([
            //     'status' => 'success',
            //     'token' => $token,
            // ]);
            return ResponseHelper::success($this->userService->handleSignIn($request), 'kamu berhasil login');
        } catch (\Throwable $thrw) {
            return ResponseHelper::error(message: $thrw->getMessage());
        }

        // $user = User::where('username', $request->username)->first();

        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     return response()->json([
        //         'message' => 'maaf username/password salah'
        //     ]);
        // }

        // $token = $user->createToken('auth-token')->plainTextToken;

        // return response()->json([
        //     'status' => 'sukses',
        //     'message' => 'kamu berhasil login!',
        //     'token' => $token,
        // ]);
    }

    public function logout()
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'maaf kamu belum login',
            ]);
        }

        Auth::user()->tokens()->delete();

        return ResponseHelper::success(message: 'kamu berhasil logout');
    }
}
