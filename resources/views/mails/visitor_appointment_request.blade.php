<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration Required</title>
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
        <div class="header">Patient Registration Required</div>
        <div class="content">
            <p>Dear <strong>{{ $data['patient_name'] }}</strong>,</p>
            <p>Thank you for submitting an appointment request at <strong>Smart City Hospitals</strong>.</p>
            <p>However, our records show that you are not yet registered as a patient in our system.</p>
            <p>To proceed with your appointment request and get it approved, please visit any of our Smart City Hospital branches for registration.</p>

            <h3>Next Steps:</h3>
            <ul style="text-align: left; display: inline-block;">
                <li>Visit your nearest Smart City Hospital with a valid ID.</li>
                <li>Complete the patient registration process at the reception.</li>
                <li>Once registered, your appointment request will be reviewed and processed.</li>
            </ul>

            <p>If you have any questions or need further assistance, please contact us at:</p>
            <p><strong>📞 Phone:</strong> 051 5579528</p>

        </div>
        <hr>
        <div class="footer">
            &copy; {{ date('Y') }} Smart City Hospitals. All rights reserved.
        </div>
    </div>
</body>
</html>
