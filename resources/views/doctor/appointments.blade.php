@extends('layouts.app')

@section('content')

<h2 class="mb-4">📋 My Appointments</h2>

<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Patient</th>
            <th>Date</th>
            <th>Time</th>
            <th>Fee</th>
            <th>Notes</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($appointments as $appointment)
            <tr>
                <td>{{ $appointment->patient->name }}</td>
                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                <td>Rs. {{ $appointment->fee }}</td>
                <td>{{ $appointment->notes ?? 'No notes' }}</td>
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
                <td>
                    <form action="/doctor/appointments/{{ $appointment->id }}" method="POST" class="d-flex gap-2">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-select form-select-sm">
                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-dark">Update</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No appointments yet!</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection