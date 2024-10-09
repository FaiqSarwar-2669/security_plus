<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendenceModel;
use Carbon\Carbon;
use App\Models\ContractModel;

class AttendenceController extends Controller
{
    public function saveAttendence(Request $request)
    {

        $array = [];
        $today = Carbon::now()->toDateString();
        $dbDate = AttendenceModel::whereDate('created_at', $today)->first();
        $array = $request->input('users');
        // foreach ($request->input('users') as $user) {

        //     $array[] = $user;
        // }

        if ($dbDate) {

            if ($request->input('beep') == '2') {
                foreach ($array as $user) {
                    $markAttendence = AttendenceModel::whereDate('created_at', $today)
                        ->where('Guard_id', $user)->first();
                    $markAttendence->Alert2 = "present";
                    $markAttendence->Percentage = (int)$markAttendence->Percentage + 20;
                    $markAttendence->save();
                }
                return response()->json([
                    'message' => "Attendence Updated beep 2"
                ]);
            }
            if ($request->input('beep') == '3') {
                foreach ($array as $user) {
                    $markAttendence = AttendenceModel::whereDate('created_at', $today)
                        ->where('Guard_id', $user)->first();
                    $markAttendence->Alert3 = "present";
                    $markAttendence->Percentage = (int)$markAttendence->Percentage + 20;
                    $markAttendence->save();
                }
                return response()->json([
                    'message' => "Attendence Updated beep 3"
                ]);
            }

            if ($request->input('beep') == '4') {
                foreach ($array as $user) {
                    $markAttendence = AttendenceModel::whereDate('created_at', $today)
                        ->where('Guard_id', $user)->first();
                    $markAttendence->Alert4 = "present";
                    $markAttendence->Percentage = (int)$markAttendence->Percentage + 20;
                    $markAttendence->save();
                }
                return response()->json([
                    'message' => "Attendence Updated beep 4"
                ]);
            }

            if ($request->input('beep') == '5') {
                foreach ($array as $user) {
                    $markAttendence = AttendenceModel::whereDate('created_at', $today)
                        ->where('Guard_id', $user)->first();
                    $markAttendence->Alert5 = "present";
                    $markAttendence->Percentage = (int)$markAttendence->Percentage + 20;
                    $markAttendence->save();
                }
                return response()->json([
                    'message' => "Attendence Updated beep 5"
                ]);
            }

            if ($request->input('beep') > 5) {
                return response()->json([
                    'message' => "Only five beep allowed"
                ]);
            }
        } else {
            $ClientGuards = ContractModel::where('CompanyId', $request->input('id'))->get();
            foreach ($ClientGuards as $user) {
                $newAttendence = new AttendenceModel();
                $newAttendence->Guard_id = $user->Guards_id;
                $newAttendence->Name = $user->Name;
                $newAttendence->Alert1 = 'apsent';
                $newAttendence->Alert2 = 'apsent';
                $newAttendence->Alert3 = 'apsent';
                $newAttendence->Alert4 = 'apsent';
                $newAttendence->Alert5 = 'apsent';
                $newAttendence->Percentage = '';
                $newAttendence->save();
            }
            if ($request->input('beep') == '1') {
                foreach ($array as $user) {
                    $markAttendence = AttendenceModel::whereDate('created_at', $today)
                        ->where('Guard_id', $user)->first();
                    $markAttendence->Alert1 = "present";
                    $markAttendence->Percentage = '20';
                    $markAttendence->save();
                }
            }
            return response()->json([
                'message' => "Attendence Updated"
            ]);
        }
    }
    public function getAttendence(String $id)
    {
        $array = [];
        $outputData = [];
        $today = Carbon::now()->toDateString();
        $dbDate = AttendenceModel::whereDate('created_at', $today)->first();
        if ($dbDate) {
            $ClientGuards = ContractModel::where('CompanyId', $id)->get();
            foreach ($ClientGuards as $guard) {
                $array[] = $guard->Guards_id;
            }

            foreach ($array as $guard) {
                $user = AttendenceModel::whereDate('created_at', $today)
                    ->where('Guard_id', $guard)->first();
                $outputData[] =  $user;
            }
            return response()->json([
                'data' => $outputData
            ], 200);
        }
    }
}
