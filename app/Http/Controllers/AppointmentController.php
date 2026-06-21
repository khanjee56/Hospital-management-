<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Show all doctors (browse page)
    public function index(Request $request)
    {
        $departments = Department::all();

        $doctors = Doctor::with('user', 'department')
            ->when($request->department, function($query) use ($request) {
                return $query->where('department_id', $request->department);
            })
            ->when($request->search, function($query) use ($request) {
                return $query->whereHas('user', function($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->get();

        return view('doctors.index', compact('doctors', 'departments'));
    }

    // Show single doctor profile
    public function show($id)
    {
        $doctor = Doctor::with('user', 'department')->findOrFail($id);
        return view('doctors.show', compact('doctor'));
    }

    // Show booking form
    public function bookForm($id)
    {
        $doctor = Doctor::with('user', 'department')->findOrFail($id);
        return view('appointments.book', compact('doctor'));
    }

    // Save appointment
    public function bookAppointment(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable',
        ]);

        // Check if slot is already booked
        $exists = Appointment::where('doctor_id', $id)
                    ->where('appointment_date', $request->appointment_date)
                    ->where('appointment_time', $request->appointment_time)
                    ->where('status', '!=', 'cancelled')
                    ->exists();

        if($exists) {
            return back()->with('error', 'This time slot is already booked! Please choose another time.');
        }

        Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'notes' => $request->notes,
            'status' => 'pending',
            'fee' => $doctor->fee,
        ]);

        return redirect('/my-appointments')->with('success', 'Appointment booked successfully!');
    }

    // Patient's own appointments
    public function myAppointments()
    {
        $appointments = Appointment::with('doctor.user', 'doctor.department')
            ->where('patient_id', auth()->id())
            ->latest()
            ->get();

        return view('appointments.my-appointments', compact('appointments'));
    }
}