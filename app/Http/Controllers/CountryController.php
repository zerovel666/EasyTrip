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
            return Country::all();
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function show($name_recreation)
    {
        try {
            return Country::where('name_recreation', $name_recreation)->get();
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function update(Request $request, $name_recreation)
    {
        try {
            return Country::where('name_recreation', $name_recreation)->update($request->all());
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
