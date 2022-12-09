<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function auth(AuthRequest $request)
    {
        $user = User::firstWhere('email', $request->email);

        if (!$user) {
            throw new AuthException('User not found');
        }

        if (!Hash::check($request->password, $user->password)) {
            throw new AuthException('Password is wrong');
        }

        $token = $user->createToken($user->name . '-access');

        return UserResource::make($user)->additional(['token' => $token->plainTextToken])->response();
    }

    public function register(RegisterRequest $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        try {
            $user = User::create($request->only('name', 'email', 'password'));
        } catch (\Exception $e) {
            throw new AuthException('A user with such an email already exists');
        }

        $token = $user->createToken($user->name . '-access');

        return UserResource::make($user)->additional(['token' => $token->plainTextToken])->response();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['status' => true]);
    }
}
