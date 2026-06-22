<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PaymentController;

Auth::routes();

// Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, ''])
Route::get('/', [AppointmentController::class, 'index']);
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // Departments
    Route::get('/departments', [AdminController::class, 'departments']);
    Route::get('/departments/create', [AdminController::class, 'createDepartment']);
    Route::post('/departments', [AdminController::class, 'storeDepartment']);
    Route::get('/departments/{id}/edit', [AdminController::class, 'editDepartment']);
    Route::put('/departments/{id}', [AdminController::class, 'updateDepartment']);
    Route::delete('/departments/{id}', [AdminController::class, 'destroyDepartment']);

    // Doctors
    Route::get('/doctors', [AdminController::class, 'doctors']);
    Route::get('/doctors/create', [AdminController::class, 'createDoctor']);
    Route::post('/doctors', [AdminController::class, 'storeDoctor']);
    Route::get('/doctors/{id}/edit', [AdminController::class, 'editDoctor']);
    Route::put('/doctors/{id}', [AdminController::class, 'updateDoctor']);
    Route::delete('/doctors/{id}', [AdminController::class, 'destroyDoctor']);
});
Route::get('/doctors', [AppointmentController::class, 'index']);
Route::get('/doctors/{id}', [AppointmentController::class, 'show']);

Route::middleware('auth')->group(function() {
    Route::get('/doctors/{id}/book', [AppointmentController::class, 'bookForm']);
    Route::post('/doctors/{id}/book', [AppointmentController::class, 'bookAppointment']);
    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments']);
});

Route::middleware(['auth', 'doctor'])->prefix('doctor')->group(function() {
    Route::get('/dashboard', [DoctorController::class, 'dashboard']);
    Route::get('/appointments', [DoctorController::class, 'appointments']);
    Route::put('/appointments/{id}', [DoctorController::class, 'updateStatus']);
    Route::get('/appointments/{id}', [DoctorController::class, 'appointmentDetail']);
});


Route::middleware('auth')->group(function() {
    // existing routes...
    Route::get('/payment/{appointmentId}', [PaymentController::class, 'showPaymentPage']);
    Route::post('/payment/{appointmentId}', [PaymentController::class, 'processPayment']);
});