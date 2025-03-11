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
        return User::destroy($id);
    }
    public function updateById(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }
}
