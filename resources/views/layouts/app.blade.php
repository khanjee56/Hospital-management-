<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">🏥 MediCare</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
 @auth
    {{-- Admin Links --}}
    @if(auth()->user()->role == 'admin')
        <li class="nav-item">
            <a class="nav-link text-warning" href="/admin/dashboard">Admin Panel</a>
        </li>

    {{-- Doctor Links --}}
    @elseif(auth()->user()->role == 'doctor')
        <li class="nav-item">
            <a class="nav-link" href="/doctor/dashboard">My Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/doctor/appointments">My Appointments</a>
        </li>

    {{-- Patient Links --}}
    @else
        <li class="nav-item">
            <a class="nav-link" href="/doctors">Find Doctors</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/my-appointments">My Appointments</a>
        </li>
    @endif

    {{-- Logout (shows for everyone) --}}
    <li class="nav-item">
        <form action="/logout" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn nav-link text-white">Logout</button>
        </form>
    </li>
@else
    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
    <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
@endauth


       
         </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>