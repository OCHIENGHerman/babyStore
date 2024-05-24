<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthController extends Controller
{
    public function indexUsers()
    { 
        try 
        {
            $users = User::all();

            return response()->json(
                $users, 200
            );

        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try
        {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);
            
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                "status" => true,
                "message" => "User successfully registered",
                "user" => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try
        {
            $request->validate([
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ]);

            $token = auth()->attempt([
                'email' => $request->email,
                'password' => $request->password
            ]);

            if(!$token)
            {
                return response()->json([
                    "status" => false,
                    "message" => "Unauthorized"
                ], 401);
            }

            $user = auth()->user();

            return response()->json([
                "status" => true,
                "message" => "User logged in successfully",
                "token" => $token,
                "user" => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function profile()
    {
        try
        {
            $userData = request()->user();

            return response()->json([
                "status" => true,
                "message" => "Profile data",
                "data" => $userData,
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function refreshToken()
    {
        try{
            $token = auth()->refresh();

            return response()->json([
                "status" => true,
                "message" => "New access token",
                "token" => $token,
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try
        {
            auth()->logout();

            return response()->json([
                "status" => true,
                "message" => "User logged out successfully",
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function unauthenticated()
    {
        return response()->json([
            "status" => false,
            "message" => "Unauthenticated. Please login first",
        ], 401);
    }
}
