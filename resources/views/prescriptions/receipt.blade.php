<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { color: #333; text-align: center; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #333; color: white; padding: 8px; text-align: left; }
        td { padding: 8px; border: 1px solid #ddd; }
        .total { text-align: right; margin-top: 20px; font-size: 18px; font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
        .paid { color: green; font-size: 24px; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>🏥 MediCare Hospital</h1>
        <p>Payment Receipt</p>
    </div>

    <table>
        <tr>
            <th>Receipt #</th>
            <td>{{ $appointment->id }}</td>
        </tr>
        <tr>
            <th>Patient Name</th>
            <td>{{ $appointment->patient->name }}</td>
        </tr>
        <tr>
            <th>Doctor</th>
            <td>Dr. {{ $appointment->doctor->user->name }}</td>
        </tr>
        <tr>
            <th>Department</th>
            <td>{{ $appointment->doctor->department->name }}</td>
        </tr>
        <tr>
            <th>Appointment Date</th>
            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Appointment Time</th>
            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
        </tr>
        <tr>
            <th>Payment Status</th>
            <td>Paid ✅</td>
        </tr>
    </table>

    <div class="total">
        Amount Paid: Rs. {{ $appointment->fee }}
    </div>

    <div class="paid">✅ PAID</div>

    <div class="footer">
        <p>Thank you for choosing MediCare Hospital</p>
        <p>Generated on {{ now()->format('d M Y h:i A') }}</p>
    </div>

</body>
</html>