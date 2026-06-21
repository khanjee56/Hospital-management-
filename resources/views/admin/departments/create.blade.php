@extends('layouts.app')

@section('content')
<h2 class="mb-4">➕ Add Department</h2>

<div class="card">
    <div class="card-body">
        <form action="/admin/departments" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Department Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Cardiology" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="d-flex justify-content-between">
                <a href="/admin/departments" class="btn btn-outline-dark">← Back</a>
                <button type="submit" class="btn btn-dark">Add Department</button>
            </div>
        </form>
    </div>
</div>
@endsection