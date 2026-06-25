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
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-warning" href="#" 
           data-bs-toggle="dropdown">
            Admin Panel
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/admin/dashboard">Dashboard</a></li>
            <li><a class="dropdown-item" href="/admin/departments">Departments</a></li>
            <li><a class="dropdown-item" href="/admin/doctors">Doctors</a></li>
            <li><a class="dropdown-item" href="/admin/appointments">Appointments</a></li>
            <li><a class="dropdown-item" href="/admin/payments">Payments</a></li>
            <li><a class="dropdown-item" href="/admin/users">Users</a></li>
        </ul>
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