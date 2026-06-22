<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    // Show Payment Page
    public function showPaymentPage($appointmentId)
    {
        $appointment = Appointment::with('doctor.user', 'doctor.department')
                        ->findOrFail($appointmentId);

        // Check if already paid
        if($appointment->payment && $appointment->payment->status == 'paid') {
            return redirect('/my-appointments')->with('error', 'This appointment is already paid!');
        }

        return view('payments.pay', compact('appointment'));
    }

    // Process Payment
    public function processPayment(Request $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        $request->validate([
            'stripeToken' => 'required',
        ]);

        try {
            // Set Stripe Secret Key
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // Create Charge
            $charge = Charge::create([
                'amount'      => $appointment->fee * 100, // Stripe uses cents
                'currency'    => 'usd',
                'source'      => $request->stripeToken,
                'description' => 'Appointment #' . $appointment->id . ' Payment',
            ]);

            // Save Payment to Database
            Payment::create([
                'appointment_id'    => $appointment->id,
                'patient_id'        => auth()->id(),
                'amount'            => $appointment->fee,
                'stripe_payment_id' => $charge->id,
                'status'            => 'paid',
            ]);

            // Update Appointment Status to Confirmed
            $appointment->update(['status' => 'confirmed']);

            return redirect('/my-appointments')->with('success', 'Payment successful! Appointment confirmed!');

        } catch(\Exception $e) {
            // Save Failed Payment
            Payment::create([
                'appointment_id'    => $appointment->id,
                'patient_id'        => auth()->id(),
                'amount'            => $appointment->fee,
                'stripe_payment_id' => null,
                'status'            => 'failed',
            ]);

            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}