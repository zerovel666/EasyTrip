<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\DescriptionCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\Count;

class CountryController extends Controller
{
    public function getBests()
    {
        try {
            $bestRatings = DescriptionCountry::orderByDesc('rating')->limit(6)->get();
            $result = [];
    
            foreach ($bestRatings as $bestRating) {
                $country = Country::find($bestRating['country_id']);
                if ($country) {
                    $result[] = $country;
                }
            }
    
            return collect($result)->map(function ($country) {
                $country->descriptionCountry;
                $country['image_path'] = "http://localhost:8000" . Storage::url((string)$country['image_path']);
                return $country;
            });
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
    


    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $image = $request->file('countryImage');
            $file = Storage::disk('public')->put('countryImage', $image);
            $data['image_path'] = $file;
            unset($data['countryImage']);
            Country::create($data);
            return response()->json([
                'message' => 'Succefully request'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
    //    UPDATE countries SET image_path = 'countryImage/5T0ctVNboOwPr11zLUr4LofqOd1xfCdTS4yXCtmz.jpg';


    public function all()
    {
        try {
            $countries = Country::all()->map(function ($country) {
                $country['image_path'] = "http://localhost:8000" . Storage::url($country['image_path']);
                $country->descriptionCountry;
                $country->tags;
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

    public function countByname(Request $request)
    {
        try {
            return Country::select('country_name')->distinct()->get()->map(function ($country){
                $countTrip = Country::where('country_name',$country['country_name'])->count();
                return [
                    "country_name" => $country['country_name'],
                    "count_trip" => $countTrip
                ];
            });
            
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
