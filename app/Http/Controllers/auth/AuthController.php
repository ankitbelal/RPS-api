<?php

namespace App\Http\Controllers\auth;

use App\Models\auth\UserLoginActivity;
use Illuminate\Http\Request;
use App\Models\auth\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthController extends Controller
{

public function login(Request $request)
{
    try{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('API Token')->plainTextToken;
    UserLoginActivity::create([
        'user_id'    => $user->id,
        'user_type'  => $request->user_type,
        'action'    => 'login',
        'ip_address' => $request->ip(),
        'platform' => $request->header('User-Agent'),
    ]);

    return response()->json([
        'user'  => $user,
        'token' => $token,
    ], 200);
}
catch(Exception $e){
    return response()->json([
        'message' => 'An error occurred during login',
        'error' => $e->getMessage()
    ], 500);
}
}



public function logout(Request $request)
{
       $user = $request->user();
    if($user){
        UserLoginActivity::create([
            'user_id'    => $user->id,
            'user_type'  => $request->user_type,
            'action'    => 'logout',
            'ip_address' => $request->ip(),
            'platform' => $request->header('User-Agent'),
        ]);
            // Revoke the token that was used to authenticate the current request
    $user->currentAccessToken()->delete();

    return response()->json([
        'message' => 'User Logged out successfully'
    ], 200);
    }

    return response()->json([
        'message' => 'No Authenticated user found'
    ], 401);
}

}