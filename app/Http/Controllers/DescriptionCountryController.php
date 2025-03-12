<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\DescriptionCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DescriptionCountryController extends Controller
{
    public function getColumn()
    {
        return Schema::getColumnListing((new DescriptionCountry())->getTable());
    }
    public function data()
    {
        return DescriptionCountry::all();
    }
    public function deleteById($id)
    {
        try {
            return DescriptionCountry::destroy($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?? 500);
        }
    }
    public function updateBy(Request $request, $id)
    {
        try {
            $description = DescriptionCountry::find($id);
            $description->update($request->all());
            return $description;
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?? 500);
        }
    }
}
