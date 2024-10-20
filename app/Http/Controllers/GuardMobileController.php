<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\guardsresetpassword;
use App\Events\Alram;
use Carbon\Carbon;
use App\Models\Guards;
use App\Models\review;
use App\Models\ContractModel;
use App\Models\AttendenceModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GuardMobileController extends Controller
{


    public function loginGuard(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 403);
        } else {

            $user = Guards::where('email', $request->input('email'))
                ->first();
            if ($user && Hash::check($request->input('password'), $user->Password)) {
                $token = $user->createToken($request->input('email'))->plainTextToken;
                $comapny = ContractModel::where('Guards_id', $user->id)->first();
                return response()->json([
                    'message' => 'Login Successfull',
                    'token' => $token,
                    'guard' => $user->id,
                    'Organization' => $comapny->CompanyId,
                    'user' => $user
                ], 200);
            } else {
                return response()->json([
                    'error' => 'check your email and password'
                ], 403);
            }
        }
    }

    public function UpdateGuard(Request $request)
    {
        $loged = auth()->user();
        $user = Guards::where('id', $loged->id)
            ->first();

        if ($request->file('profile')) {
            $profileImage = $request->file('profile');
            if ($user->profile_image) {
                $oldImagePath = public_path('images/' . basename($user->profile_image));
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $filename = time() . '_' . uniqid() . '.' . $profileImage->getClientOriginalExtension();
            $profileImage->move(public_path('images'), $filename);
            $imageUrl = asset('images/' . $filename);
            $user->profile_image = $imageUrl;
        }
        $user->First_Name = $request->input('First_Name');
        $user->Last_Name = $request->input('Last_Name');
        $user->Emergency_Contact = $request->input('Emergency_Contact');
        $user->Address = $request->input('Address');
        $user->City = $request->input('City');
        $user->Qualification = $request->input('Qualification');
        $user->Postal_Code = $request->input('Postal_Code');
        $user->save();
        return response()->json([
            'message' => 'Update Sccessfully',
            'user' => $user
        ], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }

    public function passwordReset(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ], 403);
        }
        $user = Guards::where('Email', $request->input('email'))->first();
        if ($user) {
            $name = $user->First_Name . " " . $user->Last_Name;
            $randomPassword = Str::random(10);
            $user->Password = Hash::make($randomPassword);
            Mail::to($user->Email)->queue(new guardsresetpassword($name, $randomPassword));
            $user->save();
            return response()->json([
                'message' => 'Your password has been reset. Please check your email for the new password.'
            ]);
        } else {
            return response()->json([
                'error' => 'Invalid email address !!',
            ], 403);
        }
    }

    public function changePassword(Request $request)
    {
        $loged = auth()->user();
        $validate = Validator::make($request->all(), [
            'password' => 'required',
            'confirm' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ], 403);
        }
        if ($request->input('confirm') == $request->input('password')) {
            $user = Guards::where('id', $loged->id)->first();
            if ($user) {
                $user->Password = Hash::make($request->input('confirm'));
                $user->save();
                return response()->json([
                    'message' => 'Your password has been updated'
                ]);
            } else {
                return response()->json([
                    'error' => 'Invalid email address !!',
                ], 401);
            }
        } else {
            return response()->json([
                'error' => 'Password not match',
            ], 401);
        }
    }

    public function reviews(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'client_id' => 'required',
            'rating' => 'required',
            'comment' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ]);
        }

        $user = auth()->user();
        $newReview = new review();
        $newReview->user_id = '1';
        $newReview->reviewer = 'g-' . $user->id;
        $newReview->review = $request->input('comment');
        $newReview->rating = $request->input('rating');
        $newReview->save();
        return response()->json([
            'message' => 'Review Submitted'
        ], 200);
    }


    public function getAttendence()
    {
        $user = auth()->user();
        $today = Carbon::now()->toDateString();
        $dbDate = AttendenceModel::whereDate('created_at', $today)
            ->where('Guard_id', $user->id)
            ->first();
        return response()->json([
            'data' => $dbDate
        ], 200);
    }

    public function startAlram(Request $request)
    {
        $alarm = $request->input('alarm');
        $id = $request->input('id');
        if ($request->input('alarm') == '1') {
            broadcast(new Alram($alarm, $id))->toOthers();
            return response()->json([
                'message' => 'Alram Started',
                'data' => $id
            ], 200);
        } else if ($request->input('alarm') == '0') {
            broadcast(new Alram($alarm, $id))->toOthers();
            return response()->json([
                'error' => 'Alram Off',
                'data' => $id
            ], 403);
        }
    }
}
