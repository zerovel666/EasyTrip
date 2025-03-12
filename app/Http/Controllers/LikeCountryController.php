<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\LikeCountry;
use Illuminate\Http\Request;

class LikeCountryController extends Controller
{
    public function like(Request $request)
    {
        try {
            $data = $request->all();
            $userid = $request->header('userid');
            $data['user_id'] = $userid;

            $country = Country::where('trip_name', $data['trip_name'])->first();
            if (!$country) {
                return response()->json(['message' => 'Country not found'], 404);
            }

            $data['country_id'] = $country->id;
            unset($data['trip_name']);

            LikeCountry::updateOrCreate(
                ["user_id" => $userid, "country_id" => $country->id],
                $data
            );

            return response()->json(['message' => 'Successfully request'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
}
