<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Guards;
use App\Models\registeration;
use Illuminate\Support\Facades\Auth;
use App\Models\ContractModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\GuardRejisteration;
use Illuminate\Support\Str;

class GuardController extends Controller
{

    public function deactiveGuards(String $id)
    {
        $existing = ContractModel::where('Guards_id', $id)->first();
        $guard = Guards::where('id', $id)->first();
        $guard->Status = '0';
        $existing->delete();
        $guard->save();
        return response()->json([
            'message' => 'Successfully Deactivated'
        ], 200);
    }


    public function firedGuard(String $id)
    {
        $guard = Guards::where('id', $id)->first();
        $guard->delete();
        return response()->json([
            'message' => 'Successfully Fired'
        ], 200);
    }


    public function store(Request $request)
    {
        $Password = Str::random(10);
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
            'identity' => 'required',
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
            $newGuard->Status = '0';
            $newGuard->Identity = $request->input('identity');
            $newGuard->Password = $Password;
            $newGuard->save();
            Mail::to($request->input('Email'))->queue(new GuardRejisteration(
                $request->input('First_Name'),
                $request->input('Last_Name'),
                $Password,
                $user->bussiness_owner,
                $request->input('Email')
            ));
            return response()->json([
                'message' => 'Register Guard Successfuly'
            ], 200);
        }
    }


    public function getAllGuards()
    {
        $user = Auth::user();
        $guards = Guards::where('user_id', $user->id)
            ->where('Status', '0')
            ->get();
        return response()->json([
            'data' => $guards
        ], 200);
    }


    public function getDataForGivingGuads(Request $request)
    {
        $comapny = registeration::where('email', $request->email)
            ->where('bussiness_type', 'Taker')->first();
        if ($comapny) {
            return response()->json([
                'data' => $comapny
            ], 200);
        } else {
            return response()->json([
                'error' => 'No Company Found'
            ], 200);
        }
    }


    public function contract(Request $request)
    {
        $auth = Auth::user();
        $user = registeration::where('id', $auth->id)->first();
        $guards = $request->Users;
        foreach ($guards as $guard) {
            $existing = Guards::where('id', $guard)->first();
            if ($existing) {
                $contracts = new ContractModel();
                $contracts->Guards_id = $existing->id;
                $contracts->CompanyId = $request->company;
                $contracts->CompanyName = $request->name;
                $contracts->OrganizationId = $user->id;
                $contracts->OrganizationName = $user->bussiness_owner;
                $contracts->Name = $existing->First_Name . ' ' . $existing->Last_Name;
                $contracts->Email = $existing->Email;
                $contracts->Mobile_Number = $existing->Mobile_Number;
                $contracts->Address = $existing->Address;
                $contracts->City = $existing->City;
                $existing->Status = $request->company;
                $existing->save();
                $contracts->save();
            }
        }
        return response()->json([
            'message' => 'Guards assigned successfully'
        ], 200);
    }


    public function getcontracts()
    {
        $user = Auth::user();
        $contracts = ContractModel::where('OrganizationId', $user->id)->get();
        foreach ($contracts as $contract) {
            // Check if the organization already exists in the array
            if (!isset($groupedContracts[$contract->CompanyName])) {
                $groupedContracts[$contract->CompanyName] = [
                    'CompanyId' => $contract->CompanyId,
                    'CompanyName' => $contract->CompanyName,
                    'Guards' => []
                ];
            }

            $groupedContracts[$contract->CompanyName]['Guards'][] = [
                'Guards_id' => $contract->Guards_id,
                'Name' => $contract->Name,
                'Email' => $contract->Email,
                'Mobile_Number' => $contract->Mobile_Number,
                'Address' => $contract->Address,
                'City' => $contract->City
            ];
        }

        return response()->json([
            'data' => array_values($groupedContracts)
        ], 200);
    }

    public function getClientContracts()
    {
        $user = Auth::user();
        $contracts = ContractModel::where('CompanyId', $user->id)->get();
        $groupedContracts = [];

        foreach ($contracts as $contract) {
            if (!isset($groupedContracts[$contract->OrganizationName])) {
                $groupedContracts[$contract->OrganizationName] = [
                    'OrganizationId' => $contract->OrganizationId,
                    'OrganizationName' => $contract->OrganizationName,
                    'Guards' => []
                ];
            }

            $groupedContracts[$contract->OrganizationName]['Guards'][] = [
                'Guards_id' => $contract->Guards_id,
                'Name' => $contract->Name,
                'Email' => $contract->Email,
                'Mobile_Number' => $contract->Mobile_Number,
                'Address' => $contract->Address,
                'City' => $contract->City
            ];
        }

        return response()->json([
            'data' => array_values($groupedContracts)
        ], 200);
    }

    public function getGuardsForAttendance()
    {
        $guardsArray = []; 
        $user = Auth::user();
        $guards = ContractModel::where('CompanyId', $user->id)->get();
        foreach ($guards as $guard) {
            $guarddata = Guards::where('id', $guard->Guards_id)->first();
            if($guarddata){
                $guardsArray[] = [
                    'id' => $guarddata->id,
                    'name' => $guarddata->First_Name . ' ' . $guarddata->Last_Name,
                    'identity' => $guarddata->Identity,
                ];
            }
            
        }

        return response()->json([
            'data' => $guardsArray
        ], 200);
    }


    public function view(String $id)
    {
        $guard = Guards::where('id', $id)->first();
        if ($guard) {
            return response()->json([
                'data' => $guard
            ], 200);
        } else {
            return response()->json([
                'error' => 'Not Found'
            ]);
        }
    }
}
