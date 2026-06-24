@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>📋 Prescription</h2>
            <a href="/prescriptions/{{ $prescription->id }}/download"
               class="btn btn-dark">
                📥 Download PDF
            </a>
        </div>

        <div class="card">
            <div class="card-header bg-dark text-white">
                <div class="d-flex justify-content-between">
                    <span>Prescription #{{ $prescription->id }}</span>
                    <span>{{ $prescription->created_at->format('d M Y') }}</span>
                </div>
            </div>
            <div class="card-body">

                <!-- Doctor & Patient Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Doctor</h6>
                        <p>Dr. {{ $prescription->doctor->user->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Patient</h6>
                        <p>{{ $prescription->patient->name }}</p>
                    </div>
                </div>

                <hr>

                <!-- Medicines -->
                <h6 class="mb-3">💊 Medicines</h6>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescription->medicines as $medicine)
                            <tr>
                                <td>{{ $medicine['name'] }}</td>
                                <td>{{ $medicine['dosage'] }}</td>
                                <td>{{ $medicine['duration'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Notes -->
                @if($prescription->notes)
                    <hr>
                    <h6>Doctor Notes</h6>
                    <p>{{ $prescription->notes }}</p>
                @endif

            </div>
        </div>

        <a href="/my-appointments" class="btn btn-outline-dark mt-3">← Back</a>

    </div>
</div>

@endsection