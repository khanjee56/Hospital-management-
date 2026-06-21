@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-4">
        @if($doctor->image)
            <img src="{{ asset('storage/' . $doctor->image) }}" class="img-fluid rounded">
        @else
            <img src="https://via.placeholder.com/400" class="img-fluid rounded">
        @endif
    </div>
    <div class="col-md-8">
        <h2>Dr. {{ $doctor->user->name }}</h2>
        <span class="badge bg-dark mb-2">{{ $doctor->department->name }}</span>
        <h5 class="text-muted">{{ $doctor->specialization }}</h5>
        <hr>
        <p>{{ $doctor->bio ?? 'No bio available.' }}</p>
        <h4 class="text-success">Consultation Fee: Rs. {{ $doctor->fee }}</h4>

        @auth
            <a href="/doctors/{{ $doctor->id }}/book" class="btn btn-dark btn-lg mt-3">
                📅 Book Appointment
            </a>
        @else
            <a href="/login" class="btn btn-dark btn-lg mt-3">
                Login to Book Appointment
            </a>
        @endauth

        <a href="/doctors" class="btn btn-outline-dark btn-lg mt-3">← Back</a>
    </div>
</div>

@endsection