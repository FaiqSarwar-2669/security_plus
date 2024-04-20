<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\formAndPortfolio;
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
        } else {
            $form = formAndPortfolio::where('user_id', $user->id)->first();
            $form->form_content = json_encode(trim($request->input('form_content')));
            $form->save();
            return response()->json([
                'message' => 'Update the form successfully'
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePortfolio(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'portfolio' => 'required',
            'form_content' => 'nullable',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'Banner_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors()
            ], 401);
        }
        $user = auth()->user();

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

                $filename = time() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $existing->logo = $imageUrl;
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

                $filename = time() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $existing->Banner_image = $imageUrl;
            }
            $existing->portfolio = trim($request->input('portfolio'));
            $existing->save();
            return response()->json([
                'message' => 'Update the company Portfolio'
            ], 200);
        } else {
            $data = new formAndPortfolio();
            $data->user_id = $user->id;
            // method for logo of the company
            if ($request->file('logo')) {
                $profileImage = $request->file('logo');

                $filename = time() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $data->logo = $imageUrl;
            }
            //method for banner image of the company
            if ($request->file('Banner_image')) {
                $profileImage = $request->file('Banner_image');

                $filename = time() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('images'), $filename);
                $imageUrl = asset('images/' . $filename);
                $data->Banner_image = $imageUrl;
            }

            $data->portfolio = trim($request->input('portfolio'));
            $data->save();
            return response()->json([
                'message' => 'Upload the company Portfolio'
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
