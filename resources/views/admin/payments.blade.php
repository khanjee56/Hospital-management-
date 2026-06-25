@extends('layouts.app')

@section('content')

<h2 class="mb-4">💳 Payment Reports</h2>

<!-- Total Revenue Card -->
<div class="card mb-4 bg-dark text-white">
    <div class="card-body text-center">
        <h3>Rs. {{ number_format($totalRevenue, 2) }}</h3>
        <p class="mb-0">Total Revenue Collected</p>
    </div>
</div>

<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Amount</th>
            <th>Stripe ID</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->patient->name }}</td>
                <td>Dr. {{ $payment->appointment->doctor->user->name }}</td>
                <td>Rs. {{ $payment->amount }}</td>
                <td>
                    <small class="text-muted">
                        {{ $payment->stripe_payment_id ?? 'N/A' }}
                    </small>
                </td>
                <td>
                    @if($payment->status == 'paid')
                        <span class="badge bg-success">Paid</span>
                    @elseif($payment->status == 'failed')
                        <span class="badge bg-danger">Failed</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </td>
                <td>{{ $payment->created_at->format('d M Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No payments found!</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection