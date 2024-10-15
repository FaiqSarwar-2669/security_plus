<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Guards;
use App\Models\ContractModel;

class DashboardController extends Controller
{

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
        return response()->json([
            'total' => $totalGuards,
            'duty' => $remainingGuards,
            'remaining' => $availableGuards,
            'totalcontract' =>  $contractedComapiese
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
}
