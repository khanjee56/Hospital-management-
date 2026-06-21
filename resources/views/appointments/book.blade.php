@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <h2 class="mb-4">📅 Book Appointment</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h5>Dr. {{ $doctor->user->name }}</h5>
                <p class="text-muted">{{ $doctor->department->name }} — {{ $doctor->specialization }}</p>
                <h6 class="text-success">Fee: Rs. {{ $doctor->fee }}</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="/doctors/{{ $doctor->id }}/book" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Appointment Date</label>
                        <input type="date" name="appointment_date" class="form-control"
                               min="{{ date('Y-m-d') }}" required>
                        @error('appointment_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Appointment Time</label>
                        <select name="appointment_time" class="form-control" required>
                            <option value="">-- Select Time --</option>
                            <option value="09:00">09:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="14:00">02:00 PM</option>
                            <option value="15:00">03:00 PM</option>
                            <option value="16:00">04:00 PM</option>
                            <option value="17:00">05:00 PM</option>
                        </select>
                        @error('appointment_time')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="3"
                                  placeholder="Describe your symptoms or reason for visit..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/doctors/{{ $doctor->id }}" class="btn btn-outline-dark">← Back</a>
                        <button type="submit" class="btn btn-dark">Confirm Booking</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection