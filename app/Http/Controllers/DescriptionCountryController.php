<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\DescriptionCountry;
use Illuminate\Http\Request;

class DescriptionCountryController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $data = collect($data)->map(function ($description) {
           $country = Country::where('trip_name',$description['trip_name'])->get()->toArray()[0];
           $description['country_id'] = $country['id'];
           $description = collect($description)->except('trip_name');
           return $description->toArray();
        });
        foreach ($data as $description){
            DescriptionCountry::updateOrCreate(['country_id' => $description['country_id']],$description);
        }
        return response()->json(['message' => 'Succefully request']);
    }
}
