<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\registeration;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\welcomeMail;
use App\Mail\verifiedComapny;
use App\Mail\bannedCompany;
use App\Mail\reminderFillForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;



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
            'email'
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
            'cnic',
            'front',
            'back',
            'certificate'
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
            'email'
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
            'cnic',
            'front',
            'back',
            'certificate'
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
            'email'
        ]));
        $newUser->password = bcrypt($request->input('password'));
        $newUser->bussiness_fname = '';
        $newUser->bussiness_lname = '';
        $newUser->area_code = '';
        $newUser->phone_number = '';
        $newUser->street_address = '';
        $newUser->city_name = '';
        $newUser->province = '';
        $newUser->cnic = '';
        $newUser->front = '';
        $newUser->back = '';
        $newUser->certificate = '';
        $newUser->profile = asset('assets/images/default.png');
        $newUser->save();

        Mail::to($request->input('email'))->queue(new welcomeMail($request->input('bussiness_owner')));

        return response()->json([
            'message' => 'Your application has been submitted. Please login to verity identity.'
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
            Mail::to($organization->email)->queue(new verifiedComapny($organization->bussiness_owner, $organization->bussiness_fname, $organization->bussiness_lname));
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
    // function for banned the organizations
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
            Mail::to($organization->email)->queue(new bannedCompany($organization->bussiness_owner, $organization->bussiness_fname, $organization->bussiness_lname));
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

    // function for banned the organizations
    public function reminderOrganizationRegisteration(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required',
            'data' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ], 401);
        }
        $organization = registeration::where('id', $request->input('id'))->first();
        if ($organization) {
            $organization->active = false;
            Mail::to($organization->email)->queue(new reminderFillForm($organization->bussiness_owner, $request->input('data')));
            $organization->save();
            return response()->json([
                'message' => 'Status Updated'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Not Found'
            ], 401);
        }
    }

    public function newPassword(Request $request)
    {
        $requestUser = Auth::user();

        $validate = Validator::make($request->all(), [
            'password' => 'required|',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ], 401);
        }

        $user = registeration::find($requestUser->id);
        if ($user) {
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json([
                'message' => "Password updated successfully"
            ], 200);
        } else {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {


        $validate = Validator::make($request->all(), [
            'bussiness_owner' => 'nullable|string',
            'bussiness_fname' => 'nullable',
            'bussiness_lname' => 'nullable',
            'area_code' => 'nullable',
            'phone_number' => 'nullable',
            'street_address' => 'nullable',
            'city_name' => 'nullable',
            'province' => 'nullable',
            'profile' => 'nullable',
            'cnic' => 'nullable',
            'front' => 'nullable',
            'back' => 'nullable',
            'certificate' => 'nullable',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 422);
        }

        $existing = auth()->user();
        $check = registeration::where('cnic', $existing->id)->first();
        if ($check) {
            return response()->json([
                'error' => 'Against this registeration company already registered'
            ], 403);
        } else {
            $user = registeration::where('id', $existing->id)->first();
            $user->bussiness_owner = $request->input('bussiness_owner');
            $user->bussiness_fname = $request->input('bussiness_fname');
            $user->bussiness_lname = $request->input('bussiness_lname');
            $user->area_code = $request->input('area_code');
            $user->phone_number = $request->input('phone_number');
            $user->street_address = $request->input('street_address');
            $user->city_name = $request->input('city_name');
            $user->province = $request->input('province');
            $user->cnic = $request->input('cnic');

            if ($request->file('profile')) {
                $profileImage = $request->file('profile');
                // Delete the old image if it exists
                if ($existing->logo) {
                    $oldImagePath = public_path('images/' . basename($existing->logo));
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $filename = time() . '_' . uniqid() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $user->profile = $imageUrl;
            }

            if ($request->file('front')) {
                $profileImage = $request->file('front');
                // Delete the old image if it exists
                if ($existing->logo) {
                    $oldImagePath = public_path('images/' . basename($existing->logo));
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $filename = time() . '_' . uniqid() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $user->front = $imageUrl;
            }

            if ($request->file('back')) {
                $profileImage = $request->file('back');
                // Delete the old image if it exists
                if ($existing->logo) {
                    $oldImagePath = public_path('images/' . basename($existing->logo));
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $filename = time() . '_' . uniqid() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $user->back = $imageUrl;
            }

            if ($request->file('certificate')) {
                $profileImage = $request->file('certificate');
                // Delete the old image if it exists
                if ($existing->logo) {
                    $oldImagePath = public_path('images/' . basename($existing->logo));
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $filename = time() . '_' . uniqid() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $user->certificate = $imageUrl;
            }
            $user->save();
            return response()->json([
                'message' => 'Updated Successfully'
            ]);
        }
    }


    public function edit()
    {
        $existing = auth()->user();
        $user = registeration::where('id', $existing->id)->first();
        if ($user) {
            return response()->json([
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'error' => 'No record found !!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function getOrganization(string $id)
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
            'cnic',
            'front',
            'back',
            'certificate'
        )->where('id', '=', $id)->get();
        if ($organization) {
            return response()->json([
                'data' => $organization
            ], 200);
        } else {
            return response()->json([
                'error' => 'No record found'
            ], 404);
        }
    }
}
