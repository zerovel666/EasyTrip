<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function getUrl(Request $request, $name_recreation)
    {
        try {
            $data = $request->all();
            $userId = $request->header('userid');

            if (!$userId) {
                throw new \Exception("Bad Request", 400);
            }

            $objectPay = Country::where('name_recreation', $name_recreation)->first();

            if (!$objectPay) {
                throw new \Exception("Recreation not found", 404);
            }

            $daysCount = $data['days_count'] ?? 1;
            $numPay = Str::uuid();

           Payment::create([
                'num_pay' => $numPay,
                'user_id' => $userId,
                'amount' => $objectPay['price_per_day'] * $daysCount,
                'name_recreation' => $objectPay['name_recreation'],
            ]);

            $paymentUrl = route('payment.paid', ['num_pay' => $numPay]);

            return response()->json([
                "message" => "Payment link generated",
                "payment_url" => $paymentUrl
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], is_int($e->getCode()) && $e->getCode() >= 100 && $e->getCode() < 600 ? $e->getCode() : 400);
        }
    }

    public function paid(Request $request, $num_pay)
    {
        $data = $request->all();
        $payment = Payment::where('num_pay', $num_pay)->where('active',true)->first();
        $userId = $request->header('userid');
        if (!$payment) {
            return response()->json(["message" => "Payment not found"], 404);
        }
        if ($payment['user_id'] != $userId){
            return response()->json(["message" => "You dont access, for paid this transaction"], 400);
        }
        if (!isset($data['cvv'],$data['amount'],$data['date'])){
            return response()->json(["message" => "Bad request"], 400);
        }
        if ($data['amount'] <= $payment['amount']){
            return response()->json(["message" => "Insufficient funds"], 400);
        }
        $payment->update(['paid' => true, 'active' => false]);
        return response()->json(['message' => 'Оплата прошла успешно, ожидайте PDF файл на email отправим в течении 10 минут'],200);
    }
}
