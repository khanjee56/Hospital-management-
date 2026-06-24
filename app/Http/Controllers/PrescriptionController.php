<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use PDF;

class PrescriptionController extends Controller
{
    // Show prescription form (Doctor)
    public function create($appointmentId)
    {
        $appointment = Appointment::with('patient')->findOrFail($appointmentId);
        return view('prescriptions.create', compact('appointment'));
    }

    // Save prescription (Doctor)
    public function store(Request $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'medicines'   => 'required|array',
            'medicines.*.name'     => 'required|string',
            'medicines.*.dosage'   => 'required|string',
            'medicines.*.duration' => 'required|string',
            'notes'       => 'nullable|string',
        ]);

        Prescription::create([
            'appointment_id' => $appointment->id,
            'doctor_id'      => $doctor->id,
            'patient_id'     => $appointment->patient_id,
            'medicines'      => $request->medicines,
            'notes'          => $request->notes,
        ]);

        return redirect('/doctor/appointments')->with('success', 'Prescription written successfully!');
    }

    // View prescription (Patient)
    public function show($id)
    {
        $prescription = Prescription::with('doctor.user', 'patient', 'appointment')->findOrFail($id);
        return view('prescriptions.show', compact('prescription'));
    }

    // Download prescription as PDF
    public function download($id)
    {
        $prescription = Prescription::with('doctor.user', 'patient', 'appointment')->findOrFail($id);
        $pdf = PDF::loadView('prescriptions.pdf', compact('prescription'));
        return $pdf->download('prescription-' . $id . '.pdf');
    }

    // Download payment receipt as PDF
    public function downloadReceipt($appointmentId)
    {
        $appointment = Appointment::with('doctor.user', 'patient', 'payment')->findOrFail($appointmentId);
        $pdf = PDF::loadView('prescriptions.receipt', compact('appointment'));
        return $pdf->download('receipt-' . $appointmentId . '.pdf');
    }
}