@extends('layouts.app')

@section('content')

<h2 class="mb-4">👨‍⚕️ Find a Doctor</h2>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="/doctors" method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control"
                       placeholder="Search doctor by name..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="department" class="form-control">
                    <option value="">All Departments</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">Search</button>
            </div>
        </form>
    </div>
</div>

<!-- Doctors Grid -->
<div class="row">
    @forelse($doctors as $doctor)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($doctor->image)
                    <img src="{{ asset('storage/' . $doctor->image) }}"
                         class="card-img-top" style="height:250px; object-fit:cover;">
                @else
                    <img src="https://via.placeholder.com/300x250" class="card-img-top">
                @endif
                <div class="card-body">
                    <h5 class="card-title">Dr. {{ $doctor->user->name }}</h5>
                    <span class="badge bg-dark mb-2">{{ $doctor->department->name }}</span>
                    <p class="text-muted">{{ $doctor->specialization }}</p>
                    <h6 class="text-success">Fee: Rs. {{ $doctor->fee }}</h6>
                </div>
                <div class="card-footer">
                    <a href="/doctors/{{ $doctor->id }}" class="btn btn-dark w-100">View Profile</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <h4>No doctors found!</h4>
        </div>
    @endforelse
</div>

@endsection