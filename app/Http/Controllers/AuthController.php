<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['loginUser','registerUser']]);
    }

    public function registerUser(StoreUserRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = User::create([
                'username' => $validated['username'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'birthday' => $validated['birthday'],
                'password' => Hash::make($validated['password'])
            ]);

            return response()->json([
                'status' => true,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only(["username","password"]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken(auth()->user());
    }

    protected function respondWithToken($user)
    {

        $token = $user->createToken("API TOKEN")->plainTextToken;

        return response()->json([
            'status' => true,
            'token' => $token
        ], 200);
    }

    public function me(Request $request)
    {
        return $request->user();
    }



}
