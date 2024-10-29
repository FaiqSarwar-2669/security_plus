<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\PDF;
use App\Models\AttendenceModel;
use Illuminate\Http\Request;
use App\Models\CompanyPayment;
use App\Models\ContractModel;
use App\Models\GuardPaymentsModel;
use App\Models\Guards;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class salaryController extends Controller
{
    public function DownloadAttendenceRecord(Request $request)
    {
        $user = auth()->user();
        if ($request->input('type') == 'old') {
            $startOfMonth = $request->input('start-date');
            $endOfMonth = $request->input('end-date');
        } else if ($request->input('type') == 'current') {
            $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
            $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        }
        $today = Carbon::now()->toDateString();
        $record = AttendenceModel::where('Guard_id', $user->id)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        $pdf = pdf::loadView("Guards.Reports", [
            'id' => '1',
            'image' => 'https://i.postimg.cc/W1dFq9H1/logo.png',
            'Day' => $today,
            'data' => $record
        ]);
        return $pdf->download('progress.pdf');
    }

    public function getOldrecord()
    {
        $user = auth()->user();
        $months = AttendenceModel::where('Guard_id', $user->id)
            ->select(DB::raw('DISTINCT DATE_FORMAT(created_at, "%Y-%m") as month'))
            ->orderBy('month', 'desc')
            ->get();
        return response()->json([
            'months' => $months
        ], 200);
    }

    public function getOldcompany()
    {
        $user = auth()->user();
        $months = CompanyPayment::where('user_id', $user->id)
            ->select(DB::raw('DISTINCT DATE_FORMAT(created_at, "%Y") as year'))
            ->orderBy('year', 'desc')
            ->get();
        return response()->json([
            'months' => $months
        ], 200);
    }

    public function filterRecord(Request $request)
    {
        $user = auth()->user();
        $startOfMonth = $request->input('start-date');
        $endOfMonth = $request->input('end-date');
        $record = CompanyPayment::where('user_id', $user->id)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        return response()->json([
            'data' => $record
        ], 200);
    }


    public function calculateCurrentMonthSallries()
    {
        $user = auth()->user();
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        $existing = GuardPaymentsModel::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        if ($existing->isEmpty()) {
            $guards = Guards::where('user_id', '2')->get();
            foreach ($guards as $guard) {
                $newRecord = new GuardPaymentsModel();
                $newRecord->guard_id = $guard->id;
                $newRecord->company_id = '2';
                $baseSalary = $guard->Salary;
                $newRecord->total = $baseSalary;
                $newRecord->status = '0';

                $contracts = ContractModel::where('Guards_id', $guard->id)->get();
                if ($contracts) {
                    $Attendence = AttendenceModel::where('Guard_id', $guard->id)
                        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
                    $totalPercentage = 0;
                    $days = $Attendence->count();

                    foreach ($Attendence as $attendance) {
                        $totalPercentage += $attendance->Percentage;
                    }
                    $averageAttendance = $days > 0 ? $totalPercentage / $days : 0;

                    $salary = ($averageAttendance / 100) * $baseSalary;
                    $newRecord->deduction = $baseSalary - $salary;
                    $newRecord->payablbe = $salary;
                    $newRecord->save();
                }
            }
            return response()->json([
                'message' => 'Generated salaries successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Already Loaded'
            ], 403);
        }
    }

    public function filterGuardRecord(Request $request)
    {
        $user = auth()->user();
        $startOfMonth = $request->input('start-date');
        $endOfMonth = $request->input('end-date');
        $record = GuardPaymentsModel::where('company_id', $user->id)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        return response()->json([
            'data' => $record
        ], 200);
    }

    public function markAsPaid(string $id)
    {
        $user = auth()->user();
        $record = GuardPaymentsModel::where('guard_id', $id)
            ->where('company_id', $user->id)->first();
        if ($record) {
            $record->status = '1';
            $record->save();

            return response()->json([
                'message' => 'Status updated to Paid successfully'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Record not found'
            ], 403);
        }
    }
}
