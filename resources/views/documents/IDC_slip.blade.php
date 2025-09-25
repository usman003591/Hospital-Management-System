<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab Report</title>
   
    <style>
        *{
            padding: 0px;
            margin: 0px;

        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
            padding: 4px;
        }

        .logo {
            width: 80px;
        }

        .title-main {
            font-size: 22px;
            font-weight: bold;
          
        }

        .title-sub {
            /* background: #2dce27; */
            background: #d69e25;
            color: black;
            padding: 7px;;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            width: 410px;
            text-align: center;

        }
    
        .title-sub_two {
            background: #8ea8a3;
            color: #fff;
            padding: 3px 6px; 
            font-size: 12px;
            width: 412px;
            line-height: 1.2; 
        }
        .urdu {
            font-size: 11px;
        }

        .patient-info {
            text-align: left;
            font-size: 12px;
            line-height: 1.8;
        }

        .divider {
            border-bottom: 1px solid #000;
            /* margin: 5px 0; */
        }

        .report-info {
            width: 100%;
            font-size: 12px;
            /* font-weight: bold; */
            /* margin-top: 4px; */
        }

        .report-info td {
            padding: 3px 0;
        }
        .results-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        }
        .results-table th, 
        .results-table td {
            border-bottom: 1px solid #e7d3d3;
            /* border-bottom: 1px solid black; */
            padding: 4px;
            text-align: center;
        }
        .results-table th:first-child,
        .results-table td:first-child {
            text-align: left; /* test names on left */
        }

        .test-header {
            /* margin-top: 10px; */
            border-bottom: 1px solid #000;
            font-weight: bold;
            font-size: 12px;
        }
        .test-header_two {
     
            border-bottom: 1px solid #000;
            font-size: 12px;
            background-color: grey;
            margin-top: 2px;
        }

        .test-row {
        border-bottom: 1px solid #000;
        }
        .test-row td {
            padding: 4px;
            font-size: 11px;
        }
        .val {
            padding-left: 40px; /* current result */
        }
        .prev {
            padding-left: 10px;
        text-align: center;
        word-spacing: 20px; 
        white-space: nowrap;
        }
        .ref {
            padding-left: 20px; /* reference range */
        }

        .section-title {
            font-weight: bold;
            margin-top: 8px;
            margin-bottom: 4px;
        }

        .comments {
            margin-top: 12px;
            font-size: 11px;
            line-height: 1.5;
        }

   
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            width: 100%;
            font-size: 12px;
            /* border: 1px solid #000; */
            padding-top: 5px;
            
        }

        .footer table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer td {
            vertical-align: middle;
            padding: 2px 20px;
        }

        .footer-left {
            text-align: left;
            font-size: 10px;

        }

        .footer-right {
            text-align: right;
            white-space: nowrap;
            /* border: 2px solid black; */
            padding-bottom: -130px;

        }

        .footer-right img {
            /* vertical-align: middle; */
            vertical-align: bottom;
            margin-right: 5px;
        }

        .arrow-down {
        color: red;
        font-weight: bold;
        font-size: 14px;
        }

        .value-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

        @php
            $logo = base64_encode(file_get_contents(public_path('assets/media/logos/logo_without_background_1.png')));
            $qrCode = base64_encode(file_get_contents('https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=DummyQR'));
            $redArrowDown = base64_encode(file_get_contents(public_path('red_arrow_down.png')));
            $redArrowUp = base64_encode(file_get_contents(public_path('red_arrow_Up.png')));
        @endphp
    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <!-- Logo -->
            <td class="logo">
                <img src="data:image/png;base64,{{ $logo }}" alt="IDC Logo" width="80">
            </td>

            <!-- Title -->
            <td>
                <div class="title-main">Smart City Hospital</div>
                {{-- <div class="urdu">اسمارٹ سٹی ہسپتال</div> --}}
                <div class="title-sub">IMAGING & LAB SERVICES</div><br>
                <div class="title-sub_two"></div>
                <div style="font-size: 10px; margin-top: 40px;">
                     Health Directorate, Lake View Heights, Overseas East Sector-C, Capital Smart City, Islamabad
                </div>
            </td>

            <!-- Patient Info + QR -->
            <td class="patient-info">
                <div>MR No: NR-2025-1615</div>
                <div>Age: 30 Years</div>
                <div>CNIC: 34415-4997721-9</div>
                <div>Ref.By:<strong> Dr. Kashif Bangash</strong></div>
            </td>
            <div style="margin-top:5px;">
                <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code" width="50">
            </div>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- Report Info -->
    <table class="report-info">
        <tr>
            <td>Visit Date: 07-Sep-2025 8:29PM</td>
            <td align="center" style="font-weight: bold;">Final Report - Page 1 of 1</td>
            <td align="right">Report Date: 08-Sep-2025 1:30AM</td>
        </tr>
    </table>
    <div class="divider"></div>
    
    <table class="test-header" width="100%">
        <tr>
            <td width="25%">Test Name</td>
            <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Results</td>
            <td width="40%">Last Results</td>
            <td width="20%">Reference Ranges</td>
        </tr>
    </table>

       <div class="section-title" style="font-size: 19px;">Hematology</div>
    <!-- Test Table Header -->
   <table class="results-table">
    <thead>
        <tr style="background: #ccc; font-weight: bold;">
            <th>Complete Blood Picture</th>
            <th>8-Sep-25</th>
            <th>3-Jan-25</th>
            <th>24-Feb-25</th>
            <th>11-Aug-25</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>WBC Count</td>
            {{-- <td>5,740</td> --}}
            <td style="text-align: left; white-space: nowrap;">
                &nbsp;&nbsp;&nbsp;&nbsp;<img src="data:image/png;base64,{{ $redArrowDown }}" 
                    width="14" height="14" 
                    style="vertical-align: middle;">
              
                <strong>5,740</strong>
            </td>
            <td>7510</td>

            
            <td>6470</td>
            <td>8870</td>
            <td>4000 - 10,000 /mm3</td>
        </tr>
        <tr>
            <td>RBC Count</td>
            <td>3.97</td>
            <td>3.26</td>
            <td>4.04</td>
            <td>4.03</td>
            <td>4.50 - 5.50 mil/mm3</td>
        </tr>
        <tr>
            <td>Haemoglobin</td>
            {{-- <td>11.6</td> --}}
            <td style="text-align: left; white-space: nowrap;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="data:image/png;base64,{{ $redArrowDown }}" 
                    width="14" height="14" 
                    style="vertical-align: middle;">
              
                <strong>11.6</strong>
            </td>
            <td>9.0</td>
            <td>9.9</td>
            <td>9.5</td>
            <td>13 - 17 g/dL</td>
        </tr>
        <tr>
            <td>Hematocrit</td>
            <td>34</td>
            <td>30</td>
            <td>32</td>
            <td>32</td>
            <td>40 - 50 %</td>
        </tr>
        <tr>
            <td>MCV</td>
            {{-- <td>85</td> --}}
             <td style="text-align: left; white-space: nowrap;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="data:image/png;base64,{{ $redArrowUp }}" 
                    width="11" height="11" 
                    style="vertical-align: middle;">
              
                <strong>85</strong>
            </td>
            <td>92</td>
            <td>80</td>
            <td>80</td>
            <td>83 - 101 fl</td>
        </tr>
        <tr>
            <td>MCH</td>
            <td>29</td>
            <td>28</td>
            <td>25</td>
            <td>25</td>
            <td>27 - 32 pg</td>
        </tr>
        <tr>
            <td>MCHC</td>
            <td>34</td>
            <td>35</td>
            <td>31</td>
            <td>31</td>
            <td>32 - 35 g/dL</td>
        </tr>
        <tr>
            <td>RDW-CV</td>
            {{-- <td>21</td> --}}
            <td style="text-align: left; white-space: nowrap;">
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="data:image/png;base64,{{ $redArrowUp }}" 
                    width="11" height="11" 
                    style="vertical-align: middle;">
              
                <strong>21</strong>
            </td>
            <td>22</td>
            <td>21</td>
            <td>19</td>
            <td>11.6 - 15.0 %</td>
        </tr>
        <tr>
            <td>Platelet Count</td>
            <td>264,000</td>
            <td>381000</td>
            <td>341000</td>
            <td>357000</td>
            <td>150,000 - 425,000 /mm3</td>
        </tr>
    </tbody>
    
     <tr style="background:#eee; font-weight:bold;">
            <td colspan="6" class="section-title">Differential Count</td>
        </tr>
    <tbody>
        <tr class="test-row">
            <td>Neutrophils</td>
            <td>50</td>
            <td>60</td>
            <td>56</td>
            <td>77</td>
            <td>40 - 80 %</td>
        </tr>
        <tr class="test-row">
            <td>Lymphocytes</td>
            <td>34</td>
            <td>22</td>
            <td>26</td>
            <td>14</td>
            <td>20 - 40 %</td>
        </tr>
        <tr class="test-row">
            <td>Monocytes</td>
            <td>07</td>
            <td>11</td>
            <td>9</td>
            <td>8</td>
            <td>2 - 10 %</td>
        </tr>
        <tr class="test-row">
            <td>Eosinophils</td>
            <td>09</td>
            <td>7</td>
            <td>9</td>
            <td>1</td>
            <td>1 - 6 %</td>
        </tr>
    </tbody>
    <tr style="background:#eee; font-weight:bold;">
            <td colspan="6" class="section-title">Absolute Count</td>
        </tr>
    <body>
      <tr class="test-row">
            <td>Absolute Neutrophil Count</td>
            <td>2,830</td>
            <td>4510</td>
            <td>3540</td>
            <td>6770</td>
            <td>2000 - 7000 /mm3</td>
        </tr>
        <tr class="test-row">
            <td>Absolute Lymphocyte Count</td>
            <td>1,970</td>
            <td>1670 </td>
            <td>1710</td>
            <td> 1230</td>
            <td>1000 - 3000 /mm3</td>
        </tr>
        <tr class="test-row">
            <td>Absolute Monocyte Count</td>
            <td>420</td>
            <td>800</td>
            <td>560</td>
            <td>730</td>
            <td>200 - 1000 /mm3</td>
        </tr>
        <tr class="test-row">
            <td>Absolute Eosinophil Count</td>
            <td>500</td>
            <td >500 </td>
            <td >610</td>
            <td >100</td>
            <td>20 - 500 /mm3</td>
        </tr>
    </body>
</table>

    <!-- Comments -->
    <div class="comments">
        <strong>Comments:</strong><br>
        Peripheral smear reveals Anisocytosis. Normocytic, normochromic Anaemia. Platelets are adequate on smear. Clinical correlation is suggested. <br>
        <em>Disclaimer:</em> Every diagnostic test has scientific acceptable technology or technique based limitations of uncertainty of measurement, false positive or false negative and so do not fall under the domain of negligence. In case of any such scenario, we offer free repeat of test within 24-48 hours.
    </div>

    <div class="footer">
    <table>
        <tr>
            <td class="footer-left">
                Printed by: SYSTEM @ 08-Sep-2025 02:32:58 PM
            </td>
            <td class="footer-right">
                <img src="data:image/png;base64,{{ $logo }}" alt="IDC Logo" width="40">
                <strong>System Verified Report</strong>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
