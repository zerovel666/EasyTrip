<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\LikeCountry;
use Illuminate\Http\Request;

class LikeCountryController extends Controller
{
    public function like(Request $request)
    {
        $data = $request->all();
        $userid = $request->header('userid');
        $data['user_id'] = $userid;
    
        $country = Country::where('trip_name', $data['trip_name'])->first();
        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }
    
        $data['country_id'] = $country->id;
        unset($data['trip_name']); // Убираем ненужный ключ
    
        LikeCountry::updateOrCreate(
            ["user_id" => $userid, "country_id" => $country->id], 
            $data // Передаём только обновляемые данные
        );
    
        return response()->json(['message' => 'Successfully request'], 200);
    }
    
}
