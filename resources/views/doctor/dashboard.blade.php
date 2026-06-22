@extends('layouts.app')

@section('content')

<h2 class="mb-4">👨‍⚕️ Doctor Dashboard</h2>
<p class="text-muted">Welcome, Dr. {{ auth()->user()->name }}!</p>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-center bg-primary text-white">
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
                <p class="mb-0">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h3>{{ $completedAppointments }}</h3>
                <p class="mb-0">Completed</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-center bg-info text-white">
            <div class="card-body">
                <h3>{{ $todayAppointments }}</h3>
                <p class="mb-0">Today</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <a href="/doctor/appointments" class="btn btn-dark w-100 py-3">
            📋 View All Appointments
        </a>
    </div>
</div>

@endsection