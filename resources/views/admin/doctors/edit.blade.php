@extends('layouts.app')

@section('content')
<h2 class="mb-4">✏️ Edit Doctor</h2>

<div class="card">
    <div class="card-body">
        <form action="/admin/doctors/{{ $doctor->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Doctor Name</label>
                <input type="text" name="name" class="form-control" value="{{ $doctor->user->name }}" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-control" required>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ $doctor->department_id == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Specialization</label>
                    <input type="text" name="specialization" class="form-control" value="{{ $doctor->specialization }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Consultation Fee (Rs.)</label>
                    <input type="number" name="fee" class="form-control" value="{{ $doctor->fee }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control" rows="3">{{ $doctor->bio }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Photo</label><br>
                @if($doctor->image)
                    <img src="{{ asset('storage/' . $doctor->image) }}" width="100" class="rounded mb-2">
                @else
                    <p class="text-muted">No photo uploaded</p>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Change Photo (optional)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <a href="/admin/doctors" class="btn btn-outline-dark">← Back</a>
                <button type="submit" class="btn btn-dark">Update Doctor</button>
            </div>
        </form>
    </div>
</div>
@endsection