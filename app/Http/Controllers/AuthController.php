<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){

        $fields = $request->validate([
            "name" => "required|string",
            "email" => "required|unique:users,email",
            "password" => "required|confirmed"
        ]);

        $user = User::create([
            "name" => $fields['name'],
            "email" => $fields['email'],
            "password" => bcrypt($fields['password'])
        ]);

        $token = $user->createToken("ddmccrm-token")->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function logout(Request $request){

        auth()->user()->tokens->delete();

        return response()->json([
            'data' => ' deleted success'
        ]);
    }
}
  