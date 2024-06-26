<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexPayments()
    {
        $payments = Payment::all();

        return response()->json(
            $payments, 200
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function storePayments(Request $request)
    {
        $validator = Validator::make($request->only('order_id', 'amount'),[
            'order_id' => ['required', 'exists:orders,id'],
            'amount' => ['required', 'numeric'],
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        $payment = Payment::create([
            'order_id' => $request->input('order_id'),
            'amount' => $request->input('amount'),
        ]);

        return response()->json([
            'message' => 'Payment created successfully',
            'payment' => $payment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showPayment($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'message' => 'Payment not found'
            ], 404);
        }

        return response()->json(
            $payment
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePayment(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'message' => 'Payment not found'
            ], 404);
        }

        $validator = Validator::make($request->all(),[
            'order_id' => ['exists:orders,id'],
            'amount' => ['numeric'],
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        $payment->update($request->all());
        $payment->save();

        return response()->json([
            'message' => 'Payment updated successfully',
            'payment' => $payment
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyPayment($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'message' => 'Payment not found'
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'message' => 'Payment deleted successfully'
        ], 200);
    }
}
