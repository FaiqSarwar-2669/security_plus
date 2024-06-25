<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Guards;

class GuardController extends Controller
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
        $validator = Validator::make($request->all(), [
            'First_Name' => 'required',
            'Last_Name' => 'required',
            'Father_Name' => 'required',
            'DOB' => 'required',
            'Gender' => 'required',
            'Email' => 'required|email',
            'Mobile_Number' => 'required',
            'Emergency_Contact' => 'required',
            'Address' => 'required',
            'City' => 'required',
            'Qualification' => 'required',
            'Hobbies' => 'required',
            'Postal_Code' => 'required',
            'Religion' => 'required',
            'Category' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }
        $user = auth()->user();
        $existing = Guards::where('Email', $request->input('Email'))
            ->orWhere('Mobile_Number', $request->input('Mobile_Number'))
            ->first();

        if ($existing) {
            return response()->json([
                'error' => 'A guard with this email or mobile number already exists.'
            ], 409);
        } else {
            $newGuard = new Guards();
            $newGuard->user_id = $user->id;
            $newGuard->First_Name = $request->input('First_Name');
            $newGuard->Last_Name = $request->input('Last_Name');
            $newGuard->Father_Name = $request->input('Father_Name');
            $newGuard->DOB = $request->input('DOB');
            $newGuard->Gender = $request->input('Gender');
            $newGuard->Email = $request->input('Email');
            $newGuard->Mobile_Number = $request->input('Mobile_Number');
            $newGuard->Emergency_Contact = $request->input('Emergency_Contact');
            $newGuard->Address = $request->input('Address');
            $newGuard->City = $request->input('City');
            $newGuard->Qualification = $request->input('Qualification');
            $newGuard->Hobbies = $request->input('Hobbies');
            $newGuard->Postal_Code = $request->input('Postal_Code');
            $newGuard->Religion = $request->input('Religion');
            $newGuard->Category = $request->input('Category');
            $newGuard->Status = 'active';
            $newGuard->save();
            return response()->json([
                'message' => 'Register Guard Successfuly'
            ], 200);
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
