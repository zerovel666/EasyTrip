<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function createBooking(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $country = Country::where('trip_name', $request->trip_name)->firstOrFail();

            if ($country->occupied + $request->occupied_place > $country->count_place) {
                throw new \Exception("Недостаточно свободных мест", 400);
            }

            $overlappingBookings = Booking::where('country_id', $country->id)
                ->where('active', true)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                        ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('check_in', '<', $request->check_in)
                                ->where('check_out', '>', $request->check_out);
                        });
                })
                ->exists();

            if ($overlappingBookings) {
                throw new \Exception("Выбранные даты уже забронированы", 400);
            }

            Booking::create([
                'country_id'     => $country->id,
                'user_id'        => $request->header('userid'),
                'check_in'       => $request->check_in,
                'check_out'      => $request->check_out,
                'active'         => true,
                'uuid'           => Str::uuid(),
                'users_iins'          => json_encode($request->users_iins),
                'occupied_place' => $request->occupied_place
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Бронь создана пожалуйста оплатите для ее активации',
            ], 200);
        });
    }

    public function allByTripName(Request $request)
    {
        $country = Country::whereTripName($request->trip_name)->get()[0];
        return Booking::whereCountryId($country->id)->whereActive(true)->get();
    }

    public function cancelBooking(Request $request)
    {
        return Booking::where('uuid', $request->uuid)->update(['active', false]);
    }
}
