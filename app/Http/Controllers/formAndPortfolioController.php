<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\formAndPortfolio;
use App\Models\registeration;
use Illuminate\Support\Facades\DB;

class formAndPortfolioController extends Controller
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
    public function getPortfolio()
    {
        $user = auth()->user();
        $data = DB::table('forms_and_portfolio')->select(
            'id',
            'portfolio',
            'logo',
            'Banner_image'
        )->where('user_id', '=', $user->id)->get();
        if ($data) {
            return response()->json([
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'error' => 'Not Found'
            ], 401);
        }
    }

    // get the form of the company

    public function getForm()
    {
        $user = auth()->user();
        $data = DB::table('forms_and_portfolio')->select(
            'id',
            'form_content'
        )->where('user_id', '=', $user->id)->get();
        if ($data) {
            foreach ($data as $item) {
                $item->form_content = json_decode($item->form_content);
            }
            return response()->json([
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'error' => 'Not Found'
            ], 401);
        }
    }


    public function storeForm(Request $request)
    {
        $user = auth()->user();
        $validate = Validator::make($request->all(), [
            'form_content' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ], 401);
        }
        $existing = formAndPortfolio::where('user_id', $user->id)->first();
        if ($existing) {
            $existing->form_content = $request->input('form_content');
            $existing->save();
            return response()->json([
                'message' => 'Update the form successfully'
            ], 200);
        } else {
            $newData = new formAndPortfolio();
            $newData->form_content = $request->input('form_content');
            $newData->user_id = $user->id;
            $newData->save();
            return response()->json([
                'message' => 'Created the form successfully'
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePortfolio(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'form_content' => 'nullable',
            'logo' => 'required',
            'Banner_image' => 'required',
            'portfolio' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ]);
        }

        $user = auth()->user();
        $profileUser = registeration::where('id', $user->id)->first();
        $existing = formAndPortfolio::where('user_id', $user->id)->first();
        if ($existing) {
            // method for update logo of the company
            if ($request->file('logo')) {
                $profileImage = $request->file('logo');
                // Delete the old image if it exists
                if ($existing->logo) {
                    $oldImagePath = public_path('images/' . basename($existing->logo));
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $filename = time() . '_' . uniqid() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $existing->logo = $imageUrl;
                $profileUser->profile = $imageUrl;
            }
            // method for update banner image of the company
            if ($request->file('Banner_image')) {
                $profileImage = $request->file('Banner_image');
                // Delete the old image if it exists
                if ($existing->Banner_image) {
                    $oldImagePath = public_path('images/' . basename($existing->Banner_image));
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $filename = time() . '_' . uniqid() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $existing->Banner_image = $imageUrl;
            }
            $existing->portfolio = trim($request->input('portfolio'));
            $existing->save();
            $profileUser->save();
            return response()->json([
                'message' => 'Update the company Portfolio'
            ], 200);
        } else {
            $data = new formAndPortfolio();
            $data->user_id = $user->id;
            // method for logo of the company
            if ($request->file('logo')) {
                $profileImage = $request->file('logo');

                $filename = time() . '_' . uniqid() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $data->logo = $imageUrl;
                $profileUser->profile = $imageUrl;
            }
            //method for banner image of the company
            if ($request->file('Banner_image')) {
                $profileImage = $request->file('Banner_image');

                $filename = time() . '_' . uniqid() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $data->Banner_image = $imageUrl;
            }

            $data->portfolio = trim($request->input('portfolio'));
            $data->save();
            $profileUser->save();
            return response()->json([
                'message' => 'Upload the company Portfolio'
            ], 200);
        }
    }
}
