<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\registeration;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\welcomeMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class RegisterationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organization = DB::table('registrations')->select(
            'id',
            'bussiness_fname',
            'bussiness_lname',
            'bussiness_owner',
            'area_code',
            'phone_number',
            'street_address',
            'city_name',
            'province',
            'bussiness_type',
            'email',
            'logo'
        )->where('active', '=', '1')
            ->whereRaw('LOWER(bussiness_type) = ?', ['provider'])->get();
        return response()->json([
            'data' => $organization
        ], 200);
    }

    public function inActiveCompanies()
    {
        $organization = DB::table('registrations')->select(
            'id',
            'bussiness_fname',
            'bussiness_lname',
            'bussiness_owner',
            'area_code',
            'phone_number',
            'street_address',
            'city_name',
            'province',
            'bussiness_type',
            'email',
            'logo'
        )->where('active', '=', '0')
            ->whereRaw('LOWER(bussiness_type) = ?', ['provider'])->get();
        return response()->json([
            'data' => $organization
        ], 200);
    }

    public function registerClientOrganization()
    {
        $organization = DB::table('registrations')->select(
            'id',
            'bussiness_fname',
            'bussiness_lname',
            'bussiness_owner',
            'area_code',
            'phone_number',
            'street_address',
            'city_name',
            'province',
            'bussiness_type',
            'email',
            'logo'
        )->where('active', '=', '1')
            ->whereRaw('LOWER(bussiness_type) = ?', ['taker'])->get();
        return response()->json([
            'data' => $organization
        ], 200);
    }
    public function unRegisterClientOrganization()
    {
        $organization = DB::table('registrations')->select(
            'id',
            'bussiness_fname',
            'bussiness_lname',
            'bussiness_owner',
            'area_code',
            'phone_number',
            'street_address',
            'city_name',
            'province',
            'bussiness_type',
            'email',
            'logo'
        )->where('active', '=', '0')
            ->whereRaw('LOWER(bussiness_type) = ?', ['taker'])->get();
        return response()->json([
            'data' => $organization
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'bussiness_owner' => 'required|string',
            'bussiness_type' => 'required|string',
            'password' => 'required|string',
            'conform_password' => 'required|same:password',
            'email' => 'required|email|unique:registrations,email'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 422);
        }

        $newUser = new registeration();
        $newUser->fill($request->only([
            'bussiness_owner',
            'bussiness_type',
            'password',
            'email'
        ]));
        $newUser->bussiness_fname = '';
        $newUser->bussiness_lname = '';
        $newUser->area_code = '';
        $newUser->phone_number = '';
        $newUser->street_address = '';
        $newUser->city_name = '';
        $newUser->province = '';
        $newUser->save();

        Mail::to($request->input('email'))->send(new welcomeMail($request->input('bussiness_owner')));

        return response()->json([
            'message' => 'Your application has been submitted. Please wait for approval.'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function activeOrganizationsMethod(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()
            ], 401);
        }
        $organization = registeration::where('id', $request->input('id'))->first();
        if ($organization) {
            $organization->active = true;
            $organization->save();
            return response()->json([
                'message' => 'Status Updated'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not Found'
            ], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function inActiveOrganizationsMethod(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()
            ], 401);
        }
        $organization = registeration::where('id', $request->input('id'))->first();
        if ($organization) {
            $organization->active = false;
            $organization->save();
            return response()->json([
                'message' => 'Status Updated'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not Found'
            ], 401);
        }
    }

    public function newPassword(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'password' => 'required|',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ], 401);
        }

        $user = Auth::user();
        if ($user) {
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json([
                'message' => "Password updated successfully"
            ], 200);
        } else {
            return response()->json([
                'error' => 'User not found'
            ], 401);
        }
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
