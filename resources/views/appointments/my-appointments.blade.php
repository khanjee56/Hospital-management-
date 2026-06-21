@extends('layouts.app')

@section('content')

<h2 class="mb-4">📋 My Appointments</h2>

@forelse($appointments as $appointment)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5>Dr. {{ $appointment->doctor->user->name }}</h5>
                    <p class="text-muted mb-1">{{ $appointment->doctor->department->name }}</p>
                    <p class="mb-1">
                        📅 {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                        ⏰ {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                    </p>
                    <p class="mb-0">Fee: Rs. {{ $appointment->fee }}</p>
                </div>
                <div>
                    @if($appointment->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($appointment->status == 'confirmed')
                        <span class="badge bg-info">Confirmed</span>
                    @elseif($appointment->status == 'completed')
                        <span class="badge bg-success">Completed</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="text-center mt-5">
        <h4>No appointments yet!</h4>
        <a href="/doctors" class="btn btn-dark mt-3">Find a Doctor</a>
    </div>
@endforelse

@endsection