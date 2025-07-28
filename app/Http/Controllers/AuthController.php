<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'status' => 'sukses',
                'message' => 'kamu telah berhasil register',
                'token' => $token,
            ]);
        } catch (\Throwable $thrw) {
            return response()->json([
                'status' => 'failed',
                'message' => $thrw->getMessage(),
            ]);
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
            $user = User::where('username', $request->username)->first();
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response();
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

        return response()->json([
            'status' => 'success',
            'message' => 'kamu telah berhasil logout',
        ]);
    }
}
