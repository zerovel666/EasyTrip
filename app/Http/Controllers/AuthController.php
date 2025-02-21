<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $secret;
    public function __construct()
    {
        $this->secret = config('app.secret_key');
    }



public function register(Request $request)
{
    try {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        if ($data['role'] === 'admin') {
            if ($data['key'] !== $this->secret) {
                throw new \Exception("Bad Secret key", 400);
            }
            unset($data['key']); 
        }

        User::create($data);

        return response()->json([
            "message" => "Successfully registered"
        ], 200);

    } catch (QueryException $e) {
        if ($e->errorInfo[0] == "23505") { 
            return response()->json([
                "message" => "Email или ИИН уже заняты"
            ], 409);
        }
        return response()->json([
            "message" => "Database error"
        ], 500);
    } catch (\Exception $e) {
        return response()->json([
            "message" => $e->getMessage()
        ], $e->getCode() ?: 400);
    }
}

    public function auth(Request $request)
    {
        try {
            $data = $request->only('email', 'password');
            if (Auth::attempt($data)) {
                $user = Auth::user();
                return response()->json([
                    'message' => 'Succefully request',
                    'user_id' => $user->id,
                    'role' => $user->role
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
