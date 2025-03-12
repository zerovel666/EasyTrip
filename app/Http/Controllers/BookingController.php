<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Country;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function createBooking(Request $request)
    {
        try {
            $validate = $request->validate([
                'trip_name' => 'required',
                'check_in' => 'required|date',
                'check_out' => 'required|date',
                'users_iins' => 'required|array',
            ]);
            if (!$validate) {
                throw new \Exception("Validation error", 400);
            }
            DB::transaction(function () use ($request) {
                $country = Country::where('trip_name', $request->trip_name)->firstOrFail();

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
                    'users_iins'          => json_encode($request->users_iins)
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Бронь создана пожалуйста оплатите для ее активации',
                ], 200);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?? 500);;
        }
    }

    public function allByTripName(Request $request)
    {
        if ($request->header('userid') != null) {
            $user = User::where('id', $request->header('userid'))->first();
        }
        if (isset($user) && $user->role == 'admin') {
            $country = Country::whereTripName($request->trip_name)->get()[0];
            return Booking::whereCountryId($country->id)->get();
        } else {
            $country = Country::whereTripName($request->trip_name)->get()[0];
            return Booking::whereCountryId($country->id)->whereActive(true)->get();
        }
    }

    public function cancelBooking(Request $request)
    {
        return Booking::where('uuid', $request->uuid)->update(['active', false]);
    }

    public function getColumn()
    {
        return Schema::getColumnListing((new Booking)->getTable());
    }
    public function updateById(Request $request, $id)
    {
        try {
            $data = $request->all();
            Booking::where('id', $id)->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Success update'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?? 500);;
        }
    }
    public function deleteById($id)
    {
        try {
            return response()->json([
                'status' => Booking::where('id', $id)->delete(),
                'message' => "Success delete"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?? 500);;
        }
    }
    public function downloadTableColumnOrThisRelation()
    {
        return response()->json([
            'booking' => Schema::getColumnListing((new Booking)->getTable()),
        ]);
    }

    public function getByUserId(Request $request,$userid)
    {
        $bookings = Booking::where('user_id', $userid)->get();
        $collection = collect($bookings)->map(function ($booking) use($userid){
            $country_id = $booking->country_id;
            $amount = Payment::where('user_id',$userid)->where('country_id',$country_id)->first();
            $booking['tripInfo'] = Country::find($country_id);
            $booking['tripInfo']['image_path'] = 'http://localhost:8000'.Storage::url($booking['tripInfo']['image_path']);
            $booking['users_iins'] = json_decode($booking['users_iins']);
            $booking['amount'] = $amount['amount'];
            return $booking;
        });
        return $collection;
    }
}
