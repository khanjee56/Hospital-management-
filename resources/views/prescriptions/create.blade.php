@extends('layouts.app')

@section('content')

<h2 class="mb-4">📝 Write Prescription</h2>

<!-- Patient Info -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Patient Information</h5>
    </div>
    <div class="card-body">
        <p><strong>Name:</strong> {{ $appointment->patient->name }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</p>
        <p class="mb-0"><strong>Fee:</strong> Rs. {{ $appointment->fee }}</p>
    </div>
</div>

<!-- Prescription Form -->
<div class="card">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Prescription Details</h5>
    </div>
    <div class="card-body">
        <form action="/doctor/appointments/{{ $appointment->id }}/prescription" method="POST">
            @csrf

            <!-- Medicines Section -->
            <h6 class="mb-3">💊 Medicines</h6>
            <div id="medicines-container">
                <div class="row mb-3 medicine-row">
                    <div class="col-md-4">
                        <input type="text" name="medicines[0][name]"
                               class="form-control" placeholder="Medicine Name" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="medicines[0][dosage]"
                               class="form-control" placeholder="Dosage (e.g. 500mg)" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="medicines[0][duration]"
                               class="form-control" placeholder="Duration (e.g. 5 days)" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger" onclick="removeRow(this)">✕</button>
                    </div>
                </div>
            </div>

            <!-- Add More Medicine Button -->
            <button type="button" class="btn btn-outline-dark mb-4" onclick="addMedicine()">
                + Add Another Medicine
            </button>

            <!-- Notes -->
            <div class="mb-3">
                <label class="form-label">Doctor Notes</label>
                <textarea name="notes" class="form-control" rows="3"
                          placeholder="Any special instructions..."></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/doctor/appointments" class="btn btn-outline-dark">← Back</a>
                <button type="submit" class="btn btn-dark">Save Prescription</button>
            </div>

        </form>
    </div>
</div>

<script>
    let medicineCount = 1;

    function addMedicine() {
        const container = document.getElementById('medicines-container');
        const newRow = `
            <div class="row mb-3 medicine-row">
                <div class="col-md-4">
                    <input type="text" name="medicines[${medicineCount}][name]"
                           class="form-control" placeholder="Medicine Name" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="medicines[${medicineCount}][dosage]"
                           class="form-control" placeholder="Dosage (e.g. 500mg)" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="medicines[${medicineCount}][duration]"
                           class="form-control" placeholder="Duration (e.g. 5 days)" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger" onclick="removeRow(this)">✕</button>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', newRow);
        medicineCount++;
    }

    function removeRow(btn) {
        btn.closest('.medicine-row').remove();
    }
</script>

@endsection