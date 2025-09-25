<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Receipt</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .receipt {
            width: 100%;
            max-width: 500px;
            border: 2px solid #000;
            padding: 15px;
            position: relative;
            margin-bottom: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .logo {
            width: 50px;
            height: 50px;
        }

        .logo-left {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 7px;
        }

        .logo-right{
            margin-bottom: 13px;
        }

        .title {
            text-align: center;
            flex-grow: 1;
            min-width: 200px;
            margin-top: 30px;
        }

        .title h1 {
            font-size: clamp(14px, 4vw, 16px);
            font-weight: bold;
            margin: 5px 0;
        }

        .title h2 {
            font-size: clamp(12px, 3.5vw, 14px);
            margin: 5px 0;
        }

        .receipt-number {
            text-align: right;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .form-container {
            border: 1px solid #000;
            width: 100%;
            overflow-x: auto;
        }

        .info-row {
            display: flex;
            border-bottom: 1px solid #000;
            flex-wrap: wrap;
        }

        .info-cell {
            padding: 8px;
            flex: 1;
            min-width: 120px;
        }

        .name-cell, .category-cell {
            padding: 8px;
            flex: 0.5;
            min-width: 80px;
        }

        .age-cell, .cell-cell {
            flex: 0.3;
            padding: 8px;
            min-width: 60px;
        }

        .mr-cell {
            padding: 8px;
            flex: 0.198;
            min-width: 60px;
        }

        .info-cell:not(:last-child) {
            border-right: 1px solid #000;
        }

        .service-table {
            width: 100%;
            min-width: 400px;
        }

        .service-header {
            display: flex;
            border-bottom: 1px solid #000;
            font-weight: bolder;
            background-color: #fff;
        }

        .service-header div {
            padding: 8px;
        }

        .sr-col {
            width: 88px;
            text-align: center;
            border-right: 1px solid #000;
        }

        .service-col {
            flex: 1;
            text-align: center;
            border-right: 1px solid #000;
            min-width: 150px;
        }

        .amount-col {
            width: 150px;
            text-align: center;
        }

        .service-row {
            display: flex;
            border-bottom: 1px solid #000;
        }

        .service-row:last-child {
            border-bottom: none;
        }

        .service-row div {
            padding: 8px;
        }

        .totals-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .totals {
            width: 100%;
            max-width: 200px;
            border: 1px solid #000;
            padding: 10px;
        }

        .totals p {
            margin: 5px 0;
        }

        .copy-type {
            position: absolute;
            bottom: 15px;
            left: 15px;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            body {
                padding: 10px;
            }

            .receipt {
                margin-bottom: 30px;
            }

            .header {
                justify-content: center;
            }

            .logo-right {
                order: 3;
                width: 100%;
                text-align: center;
            }

            .title {
                order: 2;
            }

            .form-container {
                overflow-x: auto;
            }

            .totals-container {
                justify-content: center;
            }

            .totals {
                max-width: none;
            }
        }

        @media screen and (max-width: 480px) {
            .header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .logo-left, .logo-right {
                margin: 10px 0;
            }

            .info-row {
                flex-direction: column;
            }

            .info-cell {
                border-right: none !important;
                border-bottom: 1px solid #000;
            }

            .info-cell:last-child {
                border-bottom: none;
            }

            .name-cell, .category-cell, .age-cell, .cell-cell, .mr-cell {
                flex: 1;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div class="logo-left">
                <div class="logo"><img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('logo.jpg')))}}" alt="Capital Smart City" class="logo"></div>
            </div>
            <div class="title">
                <h1 style="text-decoration:underline">Smart Institute of Rehabilitation Medicine</h1>
                <h2 style="text-decoration:underline">(SIRM)</h2>

            </div>
            <div class="logo-right">
                <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('samrtcitylogo.png')))}}" alt="Capital Smart City" class="logo">
            </div>
        </div>

        <div class="receipt-number">
            <p style="text-align:center;margin-right:10px;margin-top:14px ;font-weight:bolder">CASH RECEIPT</p>
            Receipt #: {{$obj->receipt_number}}
        </div>

        <div class="form-container">
            <div class="info-row">
                <div class="info-cell name-cell">Name:</div>
                <div class="info-cell">{{ucfirst($patient->name_of_patient)}}</div>
                <div class="info-cell age-cell">Age:</div>
                <div class="info-cell">{{$patient->age}}</div>
            </div>
            <div class="info-row">
                <div class="info-cell category-cell">Category:</div>
                @php $patient_category=str_replace("_"," ",$patient->patient_category); @endphp
                <div class="info-cell">{{ucfirst($patient_category)}}</div>
                <div class="info-cell cell-cell">Cell:</div>
                <div class="info-cell">{{$patient->cell}}</div>
            </div>
            <div class="info-row">
                <div class="info-cell mr-cell">MR NO:</div>
                <div class="info-cell">{{$patient->patient_mr_number}}</div>
            </div>

            <div class="service-table">
                <div class="service-header">
                    <div class="sr-col">Sr.</div>
                    <div class="service-col">Service Category</div>
                    <div class="amount-col">Amount</div>
                </div>
                <div class="service-row">
                    <div class="sr-col">1.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">2.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">3.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">4.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">5.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">6.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">7.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">8.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
            </div>
        </div>

        <div class="totals-container">
            <div class="totals">
                <p>Total Amount: </p>
                <p>Discount: </p>
                <p>Net Amount: </p>
                <p>Amount Received: </p>
            </div>
        </div>

        <div class="copy-type">PATIENT COPY</div>
    </div>
    <!-- Second receipt - Office Copy -->
    <div class="receipt">
        <!-- Same structure as above, just change the copy-type div to "OFFICE COPY" -->
        <!-- ... -->
        <div class="header">
            <div class="logo-left">
                <div class="logo"><img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('logo.jpg')))}}" alt="Capital Smart City" class="logo"></div>
            </div>
            <div class="title">
                <h1 style="text-decoration:underline">Smart Institute of Rehabilitation Medicine</h1>
                <h2 style="text-decoration:underline">(SIRM)</h2>

            </div>
            <div class="logo-right">
                <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('samrtcitylogo.png')))}}" alt="Capital Smart City" class="logo">
            </div>
        </div>

        <div class="receipt-number">
            <p style="text-align:center;margin-right:10px;margin-top:14px ;font-weight:bolder">CASH RECEIPT</p>
            Receipt #:  {{$obj->receipt_number}}
        </div>

        <div class="form-container">
            <div class="info-row">
                <div class="info-cell name-cell">Name:</div>
                <div class="info-cell">{{ucfirst($patient->name_of_patient)}}</div>
                <div class="info-cell age-cell">Age:</div>
                <div class="info-cell">{{$patient->age}}</div>
            </div>
            <div class="info-row">
                <div class="info-cell category-cell">Category:</div>
                @php $patient_category=str_replace("_"," ",$patient->patient_category); @endphp
                <div class="info-cell">{{ucfirst($patient_category)}}</div>
                <div class="info-cell cell-cell">Cell:</div>
                <div class="info-cell">{{$patient->cell}}</div>
            </div>
            <div class="info-row">
                <div class="info-cell mr-cell">MR NO:</div>
                <div class="info-cell">{{$patient->patient_mr_number}}</div>
            </div>

            <div class="service-table">
                <div class="service-header">
                    <div class="sr-col">Sr.</div>
                    <div class="service-col">Service Category</div>
                    <div class="amount-col">Amount</div>
                </div>
                <div class="service-row">
                    <div class="sr-col">1.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">2.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">3.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">4.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">5.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">6.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">7.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
                <div class="service-row">
                    <div class="sr-col">8.</div>
                    <div class="service-col"></div>
                    <div class="amount-col"></div>
                </div>
            </div>
        </div>

        <div class="totals-container">
            <div class="totals">
                <p>Total Amount: </p>
                <p>Discount: </p>
                <p>Net Amount: </p>
                <p>Amount Received: </p>
            </div>
        </div>

        <div class="copy-type">OFFICE COPY</div>
    </div>
</body>
</html>
