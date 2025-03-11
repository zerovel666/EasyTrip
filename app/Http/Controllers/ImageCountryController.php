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
        return ImageCountry::destroy($id);
    }
    public function updateBy(Request $request, $id)
    {
        $description = ImageCountry::find($id);
        $file = Storage::disk('public')->put('countryImage', $request->file('image_path'));
        $description->update(['image_path' => $file]);
        return $description;
    }
}
