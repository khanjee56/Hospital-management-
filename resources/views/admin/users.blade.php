@extends('layouts.app')

@section('content')

<h2 class="mb-4">👥 All Users</h2>

<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Joined</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role == 'admin')
                        <span class="badge bg-danger">Admin</span>
                    @elseif($user->role == 'doctor')
                        <span class="badge bg-primary">Doctor</span>
                    @else
                        <span class="badge bg-success">Patient</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No users found!</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection