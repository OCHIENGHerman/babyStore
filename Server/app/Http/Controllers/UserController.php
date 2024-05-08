<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();

        return response()->json($users);
    }
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->only('firstname', 'lastname', 'email', 'password'),[
            'firstname' => ['required', 'min:2', 'max:50', 'string'],
            'lastname' => ['required', 'min:2', 'max:50', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:255', 'string']
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

    
        $user = User::create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'), 
            'password' => Hash::make($request->input('password'))
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $user->assignRole($userRole);

        $user_role = $user->getRoleNames();
        


        return response()->json([
            "status" => 200,
            "message" => "User created",
            "User Details" => $user,
            $user_role
        ]);


    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->only('email', 'password'), [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'min:8', 'max:255', 'string']
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        if (!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                "message" => "Invalid credentials",
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();


        $request->session()->put('user_id', $user->id);

        $token = $user->createToken("user_token")->accessToken;

        $user_role = $user->getRoleNames();

        return response()->json([
            "Token" => $token,
            "User" => $user,
            $user_role
        ]);
    }


    public function profile($id)
    {
        $user = Auth::user();
        
        if ($user->id !== $id){
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $user_info = User::find($id);

        return response()->json([
            "status" => true,
            "Message" => "Profile Information",
            "User" => $user_info
        ]);
    }

    public function logout(Request $request)
    {

        $request->session()->forget('user_id');

        auth()->user()->token()->revoke();

        return response()->json([
            "message" => "Logged Out"
        ]);
    }

    public function forgotPassword(Request $request)
    {

        $userExist = User::where('email', $request->input('email'))->first();

        if ($userExist){

            $userExist->password = Hash::make($request->input('password'));

            $userExist->save();

            return response()->json([
                "message" => "Password changed",
                "User" => $userExist
            ]);

        } else{
            return response()->json([
                "message" => "User doesn't exist"
            ]);
        }
    }


    public function allUser()
    {
        $users = User::with('roles')->get();

        return response()->json($users);
    }

    public function singleCustomer($id)
    {
        $singleCustomer = User::find($id);

        if (!$singleCustomer){
            return response()->json([
                'message' => 'User not found'
            ]);
        }

        return response()->json(
            $singleCustomer
        );
    }

    public function editUser(Request $request)
    {
        $userExist = User::where('email', $request->input('email'))->first();

        if ($userExist){
            $userExist->firstname = $request->input('firstname');
            $userExist->lastname = $request->input('lastname');
            $userExist->email = $request->input('email');
            $userExist->password = $request->input('password');

            $userExist->save();

            return response()->json([
                'message' => 'user details updated',
                'User' => $userExist
            ]);
        }else{
            return response()->json([
                'message' => 'User not found'
            ]);
        }
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        $user->delete();

        return response()->json([
            'messages' => 'user deleted'
        ]);
    }
}
