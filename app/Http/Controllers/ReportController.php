<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\review;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'issue' => 'required|string'
        ]);
        Report::create($validatedData);
        return response()->json(['message' => 'Issue reported successfully!'], 200);
    }

    public function GetReportIsuues()
    {
        $data = Report::get();
        return response()->json([
            'data' => $data
        ], 200);
        
    }
}
