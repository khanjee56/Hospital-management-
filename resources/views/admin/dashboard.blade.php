@extends('layouts.app')

@section('content')

<h2 class="mb-4">📊 Admin Dashboard</h2>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h3>{{ $totalDoctors }}</h3>
                <p class="mb-0">Total Doctors</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h3>{{ $totalDepartments }}</h3>
                <p class="mb-0">Departments</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-center bg-info text-white">
            <div class="card-body">
                <h3>{{ $totalAppointments }}</h3>
                <p class="mb-0">Total Appointments</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-center bg-warning text-white">
            <div class="card-body">
                <h3>{{ $pendingAppointments }}</h3>
                <p class="mb-0">Pending Appointments</p>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Card -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center bg-dark text-white">
            <div class="card-body">
                <h3>Rs. {{ number_format($totalRevenue, 2) }}</h3>
                <p class="mb-0">Total Revenue</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row mt-3">
    <div class="col-md-4 mb-3">
        <a href="/admin/departments" class="btn btn-dark w-100 py-3">🏢 Manage Departments</a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="/admin/doctors" class="btn btn-dark w-100 py-3">👨‍⚕️ Manage Doctors</a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="/admin/appointments" class="btn btn-dark w-100 py-3">📋 All Appointments</a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="/admin/payments" class="btn btn-dark w-100 py-3">💳 Payment Reports</a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="/admin/users" class="btn btn-dark w-100 py-3">👥 Manage Users</a>
    </div>
</div>

@endsection