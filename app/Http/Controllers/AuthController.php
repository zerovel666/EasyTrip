<?php

namespace App\Http\Controllers;

use App\Models\RefreshPassword;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            \Log::info('error',[$e->getMessage()]);
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
            } else {
                throw new \Exception("Bad password",400);
            }
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function refresh(Request $request)
    {
        try {
            $data = $request->only('email', 'iin');
            $user = User::where('email', $data['email'])->where('iin', $data['iin'])->first();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $token = Str::uuid();
            RefreshPassword::updateOrCreate(
                ['user_id' => $user->id],
                ['url' => $token]
            );

            return response()->json([
                'message' => 'Password reset link created',
                'url' => route('password.reset'),
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $data = $request->only('token', 'new_password');
            $reset = RefreshPassword::where('url', $data['token'])->first();

            if (!$reset) {
                return response()->json(['message' => 'Invalid reset link'], 400);
            }

            $user = User::find($reset->user_id);
            $user->password = Hash::make($data['new_password']);
            $user->save();

            $reset->delete();

            return response()->json(['message' => 'Password successfully reset']);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
