<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\registeration;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\welcomeMail;
use Illuminate\Support\Facades\Mail;

class RegisterationController extends Controller
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
            'bussiness_fname' => 'required|string',
            'bussiness_lname' => 'required|string',
            'bussiness_owner' => 'required|string',
            'area_code' => 'required|string',
            'phone_number' => 'required|string',
            'street_adress' => 'required|string',
            'city_name' => 'required|string',
            'provice' => 'required|string',
            'bussiness_type' => 'required|string',
            'password' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'required|email'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 422);
        }


        $User = registeration::where('email', $request->input('email'))->first();
        if ($User) {
            return response()->json([
                'message' => 'This user already Exists'
            ]);
        } else {
            $newUser = new registeration();
            $newUser->bussiness_fname = $request->input('bussiness_fname');
            $newUser->bussiness_lname = $request->input('bussiness_lname');
            $newUser->bussiness_owner = $request->input('bussiness_owner');
            $newUser->phone_number = $request->input('phone_number');
            $newUser->area_code = $request->input('area_code');
            $newUser->street_address = $request->input('street_adress');
            $newUser->city_name = $request->input('city_name');
            $newUser->province = $request->input('provice');
            $newUser->bussiness_type = $request->input('bussiness_type');
            $newUser->password = Hash::make($request->input('password'));
            if ($request->hasFile('logo')) {
                $newPicture = $request->file('logo');
                $fileName = time() . '.' . $newPicture->getClientOriginalExtension();
                $newPicture->move(public_path('images'), $fileName);
                $imageUrl = asset('images/' . $fileName);
                $newUser->logo = $imageUrl;
            }
            $newUser->email = $request->input('email');
            $newUser->save();
            Mail::to($request->input('email'))->send(new welcomeMail($request->input('bussiness_owner')));
            return response()->json([
                'message' => 'Your applicaiton submitted, wait for approval'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
