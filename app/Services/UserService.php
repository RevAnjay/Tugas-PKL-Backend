<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Response;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function HandleSignUp(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        return (object) [
            'user' => $user,
            'token' => $user->createToken('auth-token')->plainTextToken,
        ];

    }
    public function HandleSignIn(LoginRequest $request)
    {
        $validated = $request->validated();

        if(!Auth::attempt($validated)) {
            return ResponseHelper::error(message: 'maaf authentikasi gagal', status: Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        return (object) [
            'user' => $user,
            'token' => $user->createToken('auth-token')->plainTextToken,
        ];
    }

}
