@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <h2 class="mb-4">💳 Payment</h2>

        <!-- Appointment Summary -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Appointment Summary</h5>
            </div>
            <div class="card-body">
                <p><strong>Doctor:</strong> Dr. {{ $appointment->doctor->user->name }}</p>
                <p><strong>Department:</strong> {{ $appointment->doctor->department->name }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</p>
                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                <h5 class="text-success">Amount to Pay: Rs. {{ $appointment->fee }}</h5>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Card Details</h5>
            </div>
            <div class="card-body">

                <form action="/payment/{{ $appointment->id }}" method="POST" id="payment-form">
                    @csrf

                    <!-- Stripe Card Element -->
                    <div class="mb-3">
                        <label class="form-label">Card Information</label>
                        <div id="card-element" class="form-control" style="padding: 10px; height: 45px;">
                        </div>
                        <div id="card-errors" class="text-danger mt-2"></div>
                    </div>

                    <!-- Test Card Info -->
                    <div class="alert alert-info">
                        <strong>Test Card Details:</strong><br>
                        Card Number: <strong>4242 4242 4242 4242</strong><br>
                        Expiry: <strong>Any future date</strong><br>
                        CVC: <strong>Any 3 digits</strong>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/my-appointments" class="btn btn-outline-dark">← Back</a>
                        <button type="submit" id="pay-btn" class="btn btn-success btn-lg">
                            💳 Pay Rs. {{ $appointment->fee }}
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();

    // Create card element
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#424770',
            }
        }
    });

    cardElement.mount('#card-element');

    // Handle errors
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        const payBtn = document.getElementById('pay-btn');
        payBtn.disabled = true;
        payBtn.textContent = 'Processing...';

        const {token, error} = await stripe.createToken(cardElement);

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
            payBtn.disabled = false;
            payBtn.textContent = '💳 Pay Rs. {{ $appointment->fee }}';
        } else {
            // Add token to form and submit
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    });
</script>

@endsection