<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function getColumn()
    {
        return Schema::getColumnListing((new User())->getTable());
    }
    public function data()
    {
        return User::all();
    }
    public function deleteById($id)
    {
        try {
            return User::destroy($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?? 500);
        }
    }
    public function updateById(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $user->update($request->all());
            return $user;
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?? 500);
        }
    }
    public function getUser($id)
    {
        try {
            return User::find($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?? 500);
        }
    }
    
}
