<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\formAndPortfolio;
use App\Models\registeration;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\PDF;

class Organizations extends Controller
{
    public function getAllPortfolios()
    {
        $portfolios = DB::table('registrations')
            ->join('forms_and_portfolio', 'registrations.id', '=', 'forms_and_portfolio.user_id')
            ->select('registrations.id', 'registrations.bussiness_owner', 'forms_and_portfolio.logo', 'forms_and_portfolio.Banner_image', 'forms_and_portfolio.portfolio')
            ->get();

        return response()->json([
            'data' => $portfolios
        ], 200);
    }

    public function getSpecificForm(string $id)
    {
        $form = DB::table('forms_and_portfolio')
            ->select('form_content')
            ->where('user_id', '=', $id)
            ->get();
        return response()->json([
            'data' => $form
        ], 200);
    }

    public function uploadApplications(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required',
            'Form' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ]);
        }

        $application = new JobApplication();
        $application->user_id = $request->input('id');
        $application->Form = $request->input('Form');
        $application->Status = 'pending';
        $application->save();
        return response()->json([
            'message' => 'Your Application Submitted Successfully'
        ], 200);
    }

    public function getJobApplications()
    {
        $user = auth()->user();
        $application = JobApplication::where('user_id', $user->id)
            ->select('id', 'Status', 'created_at')
            ->get();
        $application = $application->map(function ($application) {
            $createdAt = Carbon::parse($application->created_at);
            return [
                'id' => $application->id,
                'status' => $application->Status,
                'date' => $createdAt->toDateString(),
                'time' => $createdAt->toTimeString(),
            ];
        });
        return response()->json([
            'status' => 'success',
            'data' => $application
        ], 200);
    }
    public function ActiveJobApplications(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ]);
        }
        $application = JobApplication::where('id', $request->input('id'))->first();
        if (!$application) {
            return response()->json([
                'status' => 'error',
                'message' => 'Application not found'
            ], 404);
        }
        $application->Status = 'active';
        $application->save();
        return response()->json([
            'message' => 'This Application Activated'
        ], 200);
    }
    public function RejectedJobApplications(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ]);
        }
        $application = JobApplication::where('id', $request->input('id'))->first();
        if (!$application) {
            return response()->json([
                'status' => 'error',
                'message' => 'Application not found'
            ], 404);
        }
        $application->Status = 'reject';
        $application->save();
        return response()->json([
            'message' => 'This Application De-Activated'
        ], 200);
    }

    public function viewJobApplication(String $id)
    {

        $data = DB::table('job_applications')->select(
            'Form'
        )->where('id', '=', $id)->get();
        foreach ($data as $item) {
            $item->Form = json_decode($item->Form);
        }
        $logo = asset('/assets/images/logo.png');
        // return response()->json([
        //     'logo' => $logo,
        //     'data' => $data
        // ]);
        // dd($data[0]->Form);
        // return view('viewJobApplications',['data' => $data[0]->Form,'logo' => $logo]);
        $pdf = PDF::loadView('viewJobApplications', ['data' => $data[0]->Form, 'logo' => $logo]);
        return $pdf->download($id . '.pdf');
    }
    // public function viewJobApplication(String $id)
    // {
    //     return view('viewJobApplications');
    // }


    public function getClientSidebar(){
        $user = auth()->user();
        return response()->json([
            'pic' => $user->profile,
            'name' => $user->bussiness_owner
        ],200);
    }
}
