<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\DescriptionCountry;
use App\Models\ImageCountry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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


    public function all(Request $request)
    {

        try {
            $user = $request->header('userid');
            $user = User::find($user);
            if (isset($user['role'])  && $user['role'] == 'admin') {
                $countries = Country::orderBy('id','asc')->get()->map(function ($country) {
                    $country['image_path'] = "http://localhost:8000" . Storage::url($country['image_path']);
                    $country->descriptionCountry;
                    $country->tags;
                    return $country;
                });

                return $countries;
            } else {
                $countries = Country::where('active', true)->orderBy('id','asc')->get()->map(function ($country) {
                    $country['image_path'] = "http://localhost:8000" . Storage::url($country['image_path']);
                    $country->descriptionCountry;
                    $country->tags;
                    return $country;
                });
                return $countries;
            }
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
            $country->tags;
            $country['image_path'] =  "http://localhost:8000" . Storage::url($country['image_path']);
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
            return Country::select('country_name')->distinct()->get()->map(function ($country) {
                $countries = Country::where('country_name', $country['country_name']);
                $countTrip = $countries->count();

                $countryImage = ImageCountry::whereIn('country_id', $countries->pluck('id'))->first()->image_path;

                return [
                    "country_name" => $country['country_name'],
                    "count_trip" => $countTrip,
                    "image_path" => "http://localhost:8000" . Storage::url($countryImage)
                ];
            });
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function getColumn()
    {
        return Schema::getColumnListing((new Country)->getTable());
    }

    public function data()
    {
        return Country::orderBy('id','asc')->get();
    }

    public function deleteById($id)
    {
        return response()->json([
            'status' => Country::where('id', $id)->delete(),
            'message' => "Success delete"
        ],200);
    }
    public function updateById(Request $request, $id)
    {
        $data = $request->all();
        $image = $request->file('image_path');
        if($image){
            $saveFile = Storage::disk('public')->put('countryImage', $image);
            $data['image_path'] = $saveFile;
        }
        return Country::where('id', $id)->update($data);
    }
}
    