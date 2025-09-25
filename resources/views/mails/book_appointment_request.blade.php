<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Request Submitted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            font-size: 16pt;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            text-align: left;
            font-size: small;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #777;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Appointment Request Submitted</div>
        <div class="content">
            <p>Dear <strong>{{ $data['patient_name'] }}</strong>,</p>
            <p>We are pleased to inform you that your appointment request has been successfully submitted to <strong>Smart City Hospitals</strong>.</p>
            <p>Our team will review your request, and you will receive a confirmation shortly regarding your appointment details.</p>

            <h3>Appointment Details:</h3>
            <p><strong>Preferred Date:</strong> {{ $data['preferred_date'] }}</p>
            <p><strong>Preferred Time:</strong> {{ $data['preferred_time'] }}</p>
            <p><strong>Doctor:</strong> {{ $data['doctor_name'] }}</p>
            <p><strong>Hospital:</strong> {{ $data['hospital_name'] }}</p>

            <p>If you have any questions or need to reschedule, please contact us:</p>
            <p><strong>📞 Phone:</strong> 051 5579528</p>

        </div>
        <hr>
        <div class="footer">
            &copy; Smart City Hospitals. All rights reserved.
        </div>
    </div>
</body>
</html>
