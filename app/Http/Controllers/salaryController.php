<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\PDF;
use App\Models\AttendenceModel;
use Illuminate\Http\Request;
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
}
