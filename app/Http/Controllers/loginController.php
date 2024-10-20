<?php

namespace App\Http\Controllers;

use App\Models\login;
use App\Mail\resetPasswordMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class loginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = login::where('email', $request->email)->first();

        if ($user) {
            if ($user && Hash::check($request->password, $user->password)) {
                $token = $user->createToken($request->email)->plainTextToken;
                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'role' => $user->bussiness_type,
                    'activation' => $user->active,
                    'userLoged' => $user->id
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Incorrect password',
                ], 404);
            }
        } else {
            return response()->json([
                'error' => 'Invalid email address',
            ], 404);
        }
    }


    /**
     * Display the specified resource.
     */
    public function passwordReset(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ],403);
        }
        $user = login::where('email', $request->email)->first();
        if ($user) {
            $randomPassword = Str::random(10);
            $user->password = Hash::make($randomPassword);
            Mail::to($user->email)->queue(new resetPasswordMail($user->bussiness_owner, $randomPassword));
            $user->save();
            return response()->json([
                'message' => 'Your password has been reset. Please check your email for the new password.'
            ]);
        } else {
            return response()->json([
                'error' => 'Invalid email address !!',
            ], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
