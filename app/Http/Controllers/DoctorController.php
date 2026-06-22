<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // Doctor Dashboard
    public function dashboard()
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        $totalAppointments = Appointment::where('doctor_id', $doctor->id)->count();
        $pendingAppointments = Appointment::where('doctor_id', $doctor->id)
                                ->where('status', 'pending')->count();
        $completedAppointments = Appointment::where('doctor_id', $doctor->id)
                                ->where('status', 'completed')->count();
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
                                ->where('appointment_date', today())
                                ->count();

        return view('doctor.dashboard', compact(
            'doctor',
            'totalAppointments',
            'pendingAppointments',
            'completedAppointments',
            'todayAppointments'
        ));
    }

    // View All Appointments
    public function appointments()
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        $appointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->latest()
            ->get();

        return view('doctor.appointments', compact('appointments'));
    }

    // Update Appointment Status
    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $appointment->update(['status' => $request->status]);

        return redirect('/doctor/appointments')->with('success', 'Appointment status updated!');
    }

    // View Single Appointment Detail
    public function appointmentDetail($id)
    {
        $appointment = Appointment::with('patient')->findOrFail($id);
        return view('doctor.appointment-detail', compact('appointment'));
    }
}