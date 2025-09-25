<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Receipt</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .page {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 10px;
            flex-wrap: wrap;
        }

        .container {
            width: 100%;
            padding: 15px;
            margin-left: -20px !important;
            border: 1px solid black;
            box-sizing: border-box;
            position: relative;
           
        }

/* .system-note {
    text-align: center;
    font-size: 10px;
    color: #555;
    margin: 4px 0 12px 0;  
    page-break-before: avoid;
    page-break-after: avoid;
} */
 .system-note {
    text-align: center;
    font-size: 12px;
    color: #555;
    margin-top: 3px;
    padding-top: 3px;
    /* border-top: 1px dashed #999; */
    border-top: 1px solid #999;
}



/* Centered Report Title */
.report-title {
    text-align: center;
    width: 100%;
    margin-top: -15px;
}

        .reciept-info {
            width: 100%;
            overflow: auto;
            font-size: 14px;
            padding-bottom: 15px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10pt;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            text-align: center;
        }

        .invoice-table-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10pt;
        }

        .invoice-table-details th,
        .invoice-table-details td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            text-align: left;
        }

      
.footer-section {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    gap: 20px;
}

.comments-box {
    width: 50%;
    /* border: 1px solid black; */
    /* padding: 8px; */
    font-size: 15px;
    /* min-height: 60px;  */
}

        .totals {
            /* width: 45%;
            text-align: left;
            margin-top: -10px;
            font-size: 10pt;
            margin-left: auto;
            margin-right: 0;*/
               width: 45%;
            text-align: left;
            margin-top: -45px;
            font-size: 10pt;
            margin-left: auto;
            margin-right: 0;
        }

        .totals td {
            margin: 3px;
        }

        .right-item {
            width: 45%;
            text-align: right;
        }

        .copy-type {
            /* margin-top: -10px !important; */
            bottom: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        #underline-gap {
            text-decoration: underline;
            text-underline-position: under;
        }

        /* Print specific styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 10pt;
            }

            .page {
                display: flex;
                flex-direction: row;
                gap: 10px;
                justify-content: space-between;
                page-break-inside: avoid;
            }

            .container {
                width: 49%;
                padding: 10px;
                margin: 0;
                box-sizing: border-box;
            }

            table,
            th,
            td {
                font-size: 9pt;
                page-break-inside: avoid;
            }
          

            @page {
                size: A4 landscape;
                margin: 10mm;
            }
        }
    </style>
</head>

<body>

    <div class="page" style="width:100%;">
        <!-- Receipt 1 -->
        <div class="container">
            <!-- Header Section -->
            
            @php
                $logo = base64_encode(file_get_contents(public_path('assets/media/logos/logo_without_background_1.png')));
                $qrCode = base64_encode(file_get_contents('https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=DummyQR'));
            @endphp

           
            <header class="header">
                    <table style="width: 100%; table-layout: fixed; border-collapse: collapse;">
                        <tr>
                            <!-- Left: Hospital Logo -->
                            <td style="width: 20%; text-align: left; vertical-align: middle;">
                                <img src="data:image/png;base64,{{ $logo }}" width="90" height="90" alt="Logo">
                            </td>

                            <!-- Center: Hospital Name -->
                            <td class="title-section" style="text-align: center; vertical-align: middle;">
                                <div style="margin-top: 5px;">
                                    <h2 style="margin: 0; font-size: 25px;"><strong>Smart City Hospital</strong></h2>
                                    <h4 style="margin: 0; font-size: 16px;"><strong>(SCH)</strong></h4>
                                    
                                </div>
                            </td>

                            <td style="width: 20%; text-align: right; vertical-align: middle;">
                                <div style="display: inline-block; text-align: center;">
                                    <img src="data:image/png;base64,{{ $qrCode }}" width="90" height="90" alt="QR Code">
                                    <span style="font-size: 9px; display: inline-block; margin-top: 2px; min-width: 40px;">
                                        123456789112
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </header>
            <hr>
            <!-- Report Title (stays in center below header row) -->
            <div class="report-title">
                <h5><strong>REPORT COLLECTION FORM</strong></h5>
            </div>
            <div class="reciept-info">
                <p style="float: left; margin: 0;">Receipt #: RCF-00123</p>
            </div>
            
            <!-- Patient Info Table -->
           
            <table class="invoice-table">    
                <tr>
                    <td>Name</td>
                    <td colspan="3">John Doe</td>
                
                </tr>
                <tr>
                    <td>MR No</td>
                    <td>MR-45678</td>
                    <td>Age</td>
                    <td>35</td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>Non Resident</td>
                    <td>Cell</td>
                    <td>0301-500000</td>
                </tr>
                {{-- <tr>
                    <td>Doctor Name</td>
                    <td colspan="3">Dr. Smith</td>
                </tr> --}}
            </table>

            <!-- Services Table -->
            <table class="invoice-table-details">
                <tr>
                    <th width="20%">Sr.</th>
                    <th width="60%">Service Category</th>
                    <th width="20%">Amount</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Blood Test</td>
                    <td>200</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>X-Ray</td>
                    <td>500</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>ECG</td>
                    <td>300</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Blood Test</td>
                    <td>200</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>X-Ray</td>
                    <td>500</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>ECG</td>
                    <td>300</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Blood Test</td>
                    <td>200</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>X-Ray</td>
                    <td>500</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>ECG</td>
                    <td>300</td>
                </tr>

            </table>

           
            <div class="footer-section">
            <!-- Left side: Comments -->
            <div class="comments-box">
                <strong>Comments:</strong>
            
            </div>

                <!-- Right side: Totals -->
                <table class="totals">
                    <tr>
                        <td>Total Amount:</td>
                        <td>1000</td>
                    </tr>
                    <tr>
                        <td>Discount:</td>
                        <td>100</td>
                    </tr>
                    <tr>
                        <td>Net Amount:</td>
                        <td>900</td>
                    </tr>
                    <tr>
                        <td>Balance:</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Amount Received:</td>
                        <td>900</td>
                    </tr>
                </table>
            </div>

            <div class="reciept-info">
                   
                    <p style="float: left; margin-top: -20px;"><strong> Date:</strong> 4/10/2024 8:33 AM</p>
                </div>
           
            <div class="copy-type">PATIENT COPY</div>
            
            
            <div class="system-note">
                This is a system generated slip, doesn't require any signature & stamp
            </div>
        </div>

    </div>
</body>

</html>
