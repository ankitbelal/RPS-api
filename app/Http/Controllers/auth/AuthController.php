<?php

namespace App\Http\Controllers\auth;

use App\Helpers\ApiResponse;
use App\Models\auth\UserLoginActivity;
use Illuminate\Http\Request;
use App\Models\auth\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthController extends Controller
{
    private $apiResponse;

    public function __construct(ApiResponse $apiResponse) {
        $this->apiResponse = $apiResponse;
    }

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
        return $this->apiResponse->commonResponse("error",'Invalid credentials', 401);
    }

    $token = $user->createToken('API Token')->plainTextToken;
    UserLoginActivity::create([
        'user_id'    => $user->id,
        'user_type'  => $request->user_type,
        'action'    => 'login',
        'ip_address' => $request->ip(),
        'platform' => $request->header('User-Agent'),
    ]);

   return $this->apiResponse->successResponse('Login successful', [
        'user'  => $user,
        'token' => $token,
    ], 200);
}
catch(Exception $e){
    return $this->apiResponse->failedResponse("something went wrong", $e->getMessage(), 500);
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