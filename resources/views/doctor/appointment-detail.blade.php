@extends('layouts.app')

@section('content')

<h2 class="mb-4">📄 Appointment Detail</h2>

<div class="card">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Appointment #{{ $appointment->id }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Patient Information</h6>
                <p><strong>Name:</strong> {{ $appointment->patient->name }}</p>
                <p><strong>Email:</strong> {{ $appointment->patient->email }}</p>
            </div>
            <div class="col-md-6">
                <h6>Appointment Information</h6>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</p>
                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                <p><strong>Fee:</strong> Rs. {{ $appointment->fee }}</p>
                <p><strong>Status:</strong>
                    @if($appointment->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($appointment->status == 'confirmed')
                        <span class="badge bg-info">Confirmed</span>
                    @elseif($appointment->status == 'completed')
                        <span class="badge bg-success">Completed</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </p>
            </div>
        </div>

        <hr>

        <h6>Patient Notes</h6>
        <p>{{ $appointment->notes ?? 'No notes provided' }}</p>

        <a href="/doctor/appointments" class="btn btn-outline-dark">← Back</a>
    </div>
</div>

@endsection