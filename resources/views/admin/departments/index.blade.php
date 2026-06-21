@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>🏢 Manage Departments</h2>
    <a href="/admin/departments/create" class="btn btn-dark">+ Add Department</a>
</div>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Doctors</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($departments as $department)
            <tr>
                <td>{{ $department->name }}</td>
                <td>{{ $department->description }}</td>
                <td>{{ $department->doctors_count }}</td>
                <td>
                    <a href="/admin/departments/{{ $department->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                    <form action="/admin/departments/{{ $department->id }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">No departments found!</td></tr>
        @endforelse
    </tbody>
</table>
@endsection