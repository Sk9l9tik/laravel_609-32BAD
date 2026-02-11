<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $fiedls = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fiedls['email'])->first();

        if (!$user){
            return response(['message' => 'wrong email'], 401);
        }

        if (!Hash::check($fiedls['password'], $user->password)){
            return response(['message' => 'wrong password'], 401);
        }


        $token = $user->createToken("myapptoken")->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }
}
