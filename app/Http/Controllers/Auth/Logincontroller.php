<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class Logincontroller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            "email" => 'required|email',
            'password'=>'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(["message" => "Unauthorized"], 401);
        }

        $token = $user->createToken('apiTodos')->plainTextToken;

        return response()->json([
            "message" => "Login Berhasil",
            "token" => $token,
            "user" => $user
        ]);
    }
}
 