<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Guards;
use App\Models\AttendenceModel;
use App\Models\ContractModel;
use App\Models\review;
use Carbon\Carbon;
use App\Models\registeration;
use App\Mail\Updates;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{


    public function getAttendense(string $id)
    {
        $today = Carbon::now()->toDateString();
        $total = 0;
        $counting = 0;

        $getAttendenseForGuard = ContractModel::where('OrganizationId', $id)->get();

        foreach ($getAttendenseForGuard as $item) {
            $dbDate = AttendenceModel::whereDate('created_at', $today)
                ->where('Guard_id', $item->Guards_id)->first();
            if ($dbDate) {
                $total += $dbDate->Percentage;
                $counting++;
            }
        }

        $averaAttencence = $counting > 0 ? ($total / $counting) : 0;

        return $averaAttencence;
    }


    public function ServiceProvider()
    {
        $totalGuards = 0;
        $contractedComapiese = 0;
        $remainingGuards = 0;
        $availableGuards = 0;
        $user = Auth::user();

        $guards = Guards::where('user_id', $user->id)->get();
        foreach ($guards as $guard) {
            if ($guard->Status == '0') {
                $availableGuards = $availableGuards + 1;
            } else if ($guard->Status != '0') {
                $remainingGuards = $remainingGuards + 1;
            }
            $totalGuards = $totalGuards + 1;
        }
        $contractedComapiese = ContractModel::where('OrganizationId', $user->id)->distinct('CompanyId')
            ->groupBy('OrganizationId')
            ->count('CompanyId');

        $reviews = review::where('user_id', $user->id)->get();
        $total_reviews = $reviews->count();
        $maxScore = 5;
        $totalRating = $reviews->sum('rating');
        $averageRatingPercentage = $total_reviews > 0 ? ($totalRating / ($maxScore * $total_reviews)) * 100 : 0;

        $todayAtttendence = $this->getAttendense($user->id);

        return response()->json([
            'total' => $totalGuards,
            'duty' => $remainingGuards,
            'remaining' => $availableGuards,
            'totalcontract' =>  $contractedComapiese,
            'rating' => $averageRatingPercentage,
            'attendence' => $todayAtttendence,
        ], 200);
    }

    public function ServiceTaker()
    {
        $user = Auth::user();
        $guards = Guards::where('Status', $user->id)->count();
        $contracts = ContractModel::where('CompanyId', $user->id)->distinct('CompanyId')
            ->groupBy('CompanyId')
            ->count('CompanyId');
        return response()->json([
            'total' => $guards,
            'contracts' => $contracts
        ], 200);
    }


    public function AdminDashboards()
    {
        $guards = Guards::count();
        $contracts = ContractModel::count();
        $clients = registeration::where('bussiness_type', 'Taker')->count();
        $totalProviders = registeration::where('bussiness_type', 'Provider')->count();

        // Application Satisfaction
        $appReviews = review::where('user_id', '1')->select('rating')->get();
        $totalAppRating = $appReviews->sum('rating');
        $appCount = $appReviews->count();
        $appRating = $appCount > 0 ? $totalAppRating / $appCount : 0;

        // Company Satisfaction
        $companyReviews = review::where('user_id', '!=', '1')->select('rating')->get();
        $totalCompanyRating = $companyReviews->sum('rating');
        $totalCompanyCount = $companyReviews->count();
        $companyRating = $totalCompanyCount > 0 ? $totalCompanyRating / $totalCompanyCount : 0;

        return response()->json([
            'guards' => $guards,
            'contracts' => $contracts,
            'clients' => $clients,
            'total_providers' => $totalProviders,
            'app_rating' => $appRating,
            'company_rating' => $companyRating,
        ], 200);
    }


    public function updateMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'message' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        if ($request->input('type') == "provider") {
            $user = registeration::where('bussiness_type', 'Provider')->get();
            foreach ($user as $item) {
                Mail::to($item->email)->queue(new Updates($request->input('message')));
            }
            return response()->json([
                'message' => 'Send Successfully'
            ], 200);
        } else if ($request->input('type') == "client") {
            $user = registeration::where('bussiness_type', 'Taker')->get();
            foreach ($user as $item) {
                Mail::to($item->email)->queue(new Updates($request->input('message')));
            }
            return response()->json([
                'message' => 'Send Successfully'
            ], 200);
        } else if ($request->input('type') == "guards") {
            $user = Guards::get();
            foreach ($user as $item) {
                Mail::to($item->Email)->queue(new Updates($request->input('message')));
            }
            return response()->json([
                'message' => 'Send Successfully'
            ], 200);
        } else if ($request->input('type') == "all") {
            $guards = Guards::get();
            $user = registeration::get();
            foreach ($user as $item) {
                Mail::to($item->email)->queue(new Updates($request->input('message')));
            }
            foreach ($guards as $item) {
                Mail::to($item->Email)->queue(new Updates($request->input('message')));
            }
            return response()->json([
                'message' => 'Send Successfully'
            ], 200);
        }
    }
}
