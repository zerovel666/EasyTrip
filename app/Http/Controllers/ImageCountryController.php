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
    public function createForAdmin(Request $request)
    {
        try{
            $file = $request->file('image_path');
            $filePath = Storage::disk('public')->put('countryImage',$file);
            $data = $request->all();
            $data['image_path'] = $filePath;
            ImageCountry::create($data);
            return response()->json([
                'message' => 'Succefully created'
            ],200);
        } catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ],$e->getCode() ?? 500);
        }
    }

    public function downloadTableColumnOrThisRelation()
    {
        return response()->json([
            'imageCountry' => Schema::getColumnListing((new ImageCountry)->getTable()),
        ]);
    }
}
