<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getAllTableName()
    {
        $data = ['Booking','Country','Users','DescriptionCountry','ImageCountry','Tags'];
        return response()->json(['status' => true, 'data' => $data],200);
    }
}
