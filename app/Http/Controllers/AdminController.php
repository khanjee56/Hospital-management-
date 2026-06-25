<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Admin Dashboard
  // Update Dashboard function
public function dashboard()
{
    $totalDoctors       = Doctor::count();
    $totalDepartments   = Department::count();
    $totalAppointments  = Appointment::count();
    $totalRevenue       = Payment::where('status', 'paid')->sum('amount');
    $pendingAppointments = Appointment::where('status', 'pending')->count();

    return view('admin.dashboard', compact(
        'totalDoctors',
        'totalDepartments',
        'totalAppointments',
        'totalRevenue',
        'pendingAppointments'
    ));
}
// View All Users
public function users()
{
    $users = User::latest()->get();
    return view('admin.users', compact('users'));
}
public function appointments()
{
    $appointments = Appointment::with('patient', 'doctor.user', 'doctor.department')
                    ->latest()
                    ->get();

    return view('admin.appointments', compact('appointments'));
}

// View All Payments
public function payments()
{
    $payments = Payment::with('patient', 'appointment.doctor.user')
                ->latest()
                ->get();

    $totalRevenue = Payment::where('status', 'paid')->sum('amount');

    return view('admin.payments', compact('payments', 'totalRevenue'));
}


    // ===== DEPARTMENTS =====

    public function departments()
    {
        $departments = Department::withCount('doctors')->latest()->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function createDepartment()
    {
        return view('admin.departments.create');
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments|max:255',
            'description' => 'nullable',
        ]);

        Department::create($request->only('name', 'description'));

        return redirect('/admin/departments')->with('success', 'Department added successfully!');
    }

    public function editDepartment($id)
    {
        $department = Department::findOrFail($id);
        return view('admin.departments.edit', compact('department'));
    }

    public function updateDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255|unique:departments,name,' . $id,
            'description' => 'nullable',
        ]);

        $department->update($request->only('name', 'description'));

        return redirect('/admin/departments')->with('success', 'Department updated successfully!');
    }

    public function destroyDepartment($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect('/admin/departments')->with('success', 'Department deleted successfully!');
    }

    // ===== DOCTORS =====

    public function doctors()
    {
        $doctors = Doctor::with('user', 'department')->latest()->get();
        return view('admin.doctors.index', compact('doctors'));
    }

    public function createDoctor()
    {
        $departments = Department::all();
        return view('admin.doctors.create', compact('departments'));
    }

    public function storeDoctor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'department_id' => 'required',
            'specialization' => 'required',
            'fee' => 'required|numeric',
            'bio' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Step 1: Create User account for doctor
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'doctor',
        ]);

        // Step 2: Handle image upload
        $imagePath = null;
        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('doctors', 'public');
        }

        // Step 3: Create Doctor profile linked to that user
        Doctor::create([
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'specialization' => $request->specialization,
            'fee' => $request->fee,
            'bio' => $request->bio,
            'image' => $imagePath,
        ]);

        return redirect('/admin/doctors')->with('success', 'Doctor added successfully!');
    }

    public function editDoctor($id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);
        $departments = Department::all();
        return view('admin.doctors.edit', compact('doctor', 'departments'));
    }

    public function updateDoctor(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required',
            'specialization' => 'required',
            'fee' => 'required|numeric',
            'bio' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update user name
        $doctor->user->update(['name' => $request->name]);

        // Handle image
        $imagePath = $doctor->image;
        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('doctors', 'public');
        }

        $doctor->update([
            'department_id' => $request->department_id,
            'specialization' => $request->specialization,
            'fee' => $request->fee,
            'bio' => $request->bio,
            'image' => $imagePath,
        ]);

        return redirect('/admin/doctors')->with('success', 'Doctor updated successfully!');
    }

    public function destroyDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->user->delete(); // deletes user too (cascade deletes doctor)
        return redirect('/admin/doctors')->with('success', 'Doctor removed successfully!');
    }
}