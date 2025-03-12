<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Country;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function paid(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $country_id = Country::whereTripName($request->card['trip_name'])->get()[0]['id'];
                $cardPay = [
                    'num_pay' => Str::uuid(),
                    'user_id' => $request->header('userid'),
                    'phone' => $request->card['phone'],
                    'email' => $request->card['email'],
                    'full_name' => $request->card['full_name'],
                    'type'  => $request->card['type'],
                    'num_card' => $request->card['num_card'],
                    'fn_mn_card' => $request->card['fn_mn_card'],
                    'trip_name' => $request->card['trip_name'],
                    'amount' => $request->card['amount'],
                    'country_id' => $country_id
                ];
                $data = [
                    'country_id'     => $country_id,
                    'user_id'        => $request->header('userid'),
                    'check_in'       => $request->data['check_in'],
                    'check_out'      => $request->data['check_out'],
                    'active'         => true,
                    'uuid'           => Str::uuid(),
                    'users_iins' => json_encode($request->data['users_iins'])
                ];
                Payment::create($cardPay);
                Booking::create($data); 
            });

            return response()->json(['status' => true, 'message' => 'Successfully request'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
