@extends('layouts.app')

@section('content')

<h2 class="mb-4">📋 All Appointments</h2>

<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Department</th>
            <th>Date</th>
            <th>Time</th>
            <th>Fee</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($appointments as $appointment)
            <tr>
                <td>{{ $appointment->id }}</td>
                <td>{{ $appointment->patient->name }}</td>
                <td>Dr. {{ $appointment->doctor->user->name }}</td>
                <td>{{ $appointment->doctor->department->name }}</td>
                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                <td>Rs. {{ $appointment->fee }}</td>
                <td>
                    @if($appointment->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($appointment->status == 'confirmed')
                        <span class="badge bg-info">Confirmed</span>
                    @elseif($appointment->status == 'completed')
                        <span class="badge bg-success">Completed</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No appointments found!</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection