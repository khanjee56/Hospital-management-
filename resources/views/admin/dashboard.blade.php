@extends('layouts.app')

@section('content')
<h2 class="mb-4">📊 Admin Dashboard</h2>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h3>{{ $totalDoctors }}</h3>
                <p class="mb-0">Total Doctors</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h3>{{ $totalDepartments }}</h3>
                <p class="mb-0">Departments</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6 mb-3">
        <a href="/admin/departments" class="btn btn-dark w-100 py-3">🏢 Manage Departments</a>
    </div>
    <div class="col-md-6 mb-3">
        <a href="/admin/doctors" class="btn btn-dark w-100 py-3">👨‍⚕️ Manage Doctors</a>
    </div>
</div>
@endsection