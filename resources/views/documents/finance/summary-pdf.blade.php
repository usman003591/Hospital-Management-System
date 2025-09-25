<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Yearly Summary PDF</title>
    <style>
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ddd; padding:6px; text-align: right; }
        th { background:#f2f2f2; }
        td:first-child, th:first-child { text-align: left; }
            .header {
            margin-bottom: 20px;
        }
           .hms-logo,
        .csc-logo {
            height: 70px;
            width: 70px;
        }

        .title-section {
            text-align: center;
        }

        .title-section h2 {
            font-size: 25px;
            margin-bottom: 5px;
        }

        .title-section h5 {
            font-size: 16px;
            margin-top: 5px;
            text-decoration: underline;
        }
    </style>
        <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            background: #2c3e50;
            color: #fff;
            text-align: center;
        }
        td {
            text-align: right;
        }
        td:first-child {
            text-align: left;
            font-weight: bold;
            background: #f8f9fa;
        }
        tr:nth-child(even) td {
            background: #fdfdfd;
        }
        .receivable { color: #e74c3c; font-weight: bold; }
        .discount   { color: #f39c12; }
        .net        { color: #2980b9; font-weight: bold; }
        .received   { color: #27ae60; font-weight: bold; }
    </style>
</head>
<body>


            <header class="header">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 20%; text-align: left;">
                            <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path($hospital->logo)))}}"
                                alt="Logo" class="hms-logo">
                        </td>
                        <td class="title-section">
                            <h2>{{$hospital->name}}</h2>
                            <h2>({{$hospital->hospital_abbreviation}})</h2>
                            <h5><strong>Health Directorate</strong></h5>
                        </td>
                        <td style="width: 20%; text-align: right;">
                            <img src="{{ file_exists(public_path($hospital->project_logo)) ?
              'data:image/png;base64,' . base64_encode(file_get_contents(public_path($hospital->project_logo))) :
              'data:image/png;base64,' . base64_encode(file_get_contents(public_path('samrtcitylogo.png'))) }}"
                                alt="CSC Logo" class="csc-logo">
                        </td>
                    </tr>
                </table>
            </header>

   <h2>Yearly Summary ({{ $summary_year }})</h2>
   <h2>Invoice Type: {{ ucfirst($invoice_type) }}</h2>

    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Total Amount</th>
                <th>Discount</th>
                <th>Net Amount</th>
                <th>Received</th>
            </tr>
        </thead>
        <tbody>
            @php
                $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            @endphp
            @foreach($months as $i => $month)
                <tr>
                    <td>{{ $month }}</td>
                    <td class="receivable">{{ $summaryData['receivable'][$i] ?? 0 }}</td>
                    <td class="discount">{{ $summaryData['discount'][$i] ?? 0 }}</td>
                    <td class="net">{{ $summaryData['net'][$i] ?? 0 }}</td>
                    <td class="received">{{ $summaryData['received'][$i] ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
