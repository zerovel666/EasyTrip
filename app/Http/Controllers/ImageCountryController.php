<?php

namespace App\Http\Controllers;

use App\Models\ImageCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ImageCountryController extends Controller
{
    public function getColumn()
    {
        return Schema::getColumnListing((new ImageCountry())->getTable());
    }
    public function data()
    {
        return ImageCountry::all();
    }
    public function deleteById($id)
    {
        try {
            return ImageCountry::destroy($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?? 500);
        }
    }
    public function updateBy(Request $request, $id)
    {
        try {
            $image = ImageCountry::find($id);
            $image->update($request->all());
            return $image;
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?? 500);
        }
    }
}
