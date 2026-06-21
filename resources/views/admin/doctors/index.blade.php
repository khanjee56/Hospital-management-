@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>👨‍⚕️ Manage Doctors</h2>
    <a href="/admin/doctors/create" class="btn btn-dark">+ Add Doctor</a>
</div>

<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Department</th>
            <th>Specialization</th>
            <th>Fee</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($doctors as $doctor)
            <tr>
                <td>
                    @if($doctor->image)
                        <img src="{{ asset('storage/' . $doctor->image) }}" width="50" style="border-radius:50%; height:50px; object-fit:cover;">
                    @else
                        <img src="https://via.placeholder.com/50" width="50" style="border-radius:50%;">
                    @endif
                </td>
                <td>{{ $doctor->user->name }}</td>
                <td>{{ $doctor->department->name }}</td>
                <td>{{ $doctor->specialization }}</td>
                <td>Rs. {{ $doctor->fee }}</td>
                <td>
                    <a href="/admin/doctors/{{ $doctor->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                    <form action="/admin/doctors/{{ $doctor->id }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">No doctors found!</td></tr>
        @endforelse
    </tbody>
</table>
@endsection