<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class CountryController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            foreach ($data['countries'] as $country) {
                Country::create($country);
            }
            return response()->json([
                'message' => 'Succefully request'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function all()
    {
        try {
            $countries = Country::all()->map(function ($country) {
                $country->descriptionCountry;
                return $country;
            });
            
            return $countries;
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function show($trip_name)
    {
        try {
            $country = Country::where('trip_name', $trip_name)->first();
            $country->descriptionCountry;
            return $country;
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function update(Request $request, $trip_name)
    {
        try {
            return Country::where('trip_name', $trip_name)->update($request->all());
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
