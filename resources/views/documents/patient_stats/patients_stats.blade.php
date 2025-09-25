<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patients State - CSC</title>
    {{--
    <link rel="stylesheet" href="{{ public_path('assets/css/patients-state.css') }}"> --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            padding: 0;
            margin: 0;
        }

        @page {
            size: A4;
            margin: 10mm 10mm;
        }

        .reciept {
            page-break-inside: avoid;
        }

        .header {
            margin-top: 40px;
            text-align: center;
            text-decoration: underline;
            font-size: large;
        }

        .ps-container {
            width: 100%;
            max-width: 200mm;
            background-color: #fff;
            padding: 20px;
            height: auto;
            margin: auto;
            box-sizing: border-box;
        }

        .ps-table {
            margin: 30px auto 50px auto;
            border: 1px solid dimgray;
            width: 35rem;
            padding: 0;
            border-collapse: collapse;
            font-size: smaller;
        }

        .ps-table th {
            text-align: center;
            border-top: 1px solid dimgray;
            padding: 7px 20px;
            margin: 0;
            border-collapse: collapse;
        }

        .ps-table td {
            margin: 0;
            padding: 7px 20px;
            text-align: center;
            border-top: 1px solid dimgray;
            border-collapse: collapse;
        }

        .column-left {
            border-left: 1px solid dimgray;
        }

        .label {
            height: 2.5rem;
        }

        @media print {
            .reciept {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="ps-container">
        <div class="reciept">
            <header class="header">
                <div>
                    <h4>Patients State - CSC</h4>
                    <h4>18 Sep - 24 Nov 24</h4>
                </div>
            </header>
            <table class="ps-table">
                <thead>
                    <tr>
                        <th colspan="4">SIRM</th>
                    </tr>
                    <tr>
                        <th rowspan="2">Category</th>
                        <th colspan="3" class="column-left">Number of Patients</th>
                    </tr>
                    <tr>
                        <th class="label column-left">From within CSC</th>
                        <th class="label column-left">From outside CSC</th>
                        <th class="label column-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="label column-left">Rehab Specialist Consultation</th>
                        <td class="column-left">57</td>
                        <td class="column-left">15</td>
                        <td class="column-left">72</td>
                    </tr>
                    <tr>
                        <th class="label column-left">Physiotherapy Sessions</th>
                        <td class="column-left">154</td>
                        <td class="column-left">10</td>
                        <td class="column-left">164</td>
                    </tr>
                    <tr>
                        <th class="label column-left">Total</th>
                        <th class="column-left">211</th>
                        <th class="column-left">25</th>
                        <th class="column-left">236</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="reciept">
            <header class="header">
                <div>
                    <h4>Patients State - CSC</h4>
                    <h4>25 Nov - 6 Dec 24</h4>
                </div>
            </header>
            <table class="ps-table">
                <thead>
                    <tr>
                        <th colspan="4">SIRM</th>
                    </tr>
                    <tr>
                        <th rowspan="2">Category</th>
                        <th colspan="3" class="column-left">Number of Patients</th>
                    </tr>
                    <tr>
                        <th class="label column-left">From within CSC</th>
                        <th class="label column-left">From outside CSC</th>
                        <th class="label column-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="label column-left">Rehab Specialist Consultation</th>
                        <td class="column-left">19</td>
                        <td class="column-left">3</td>
                        <td class="column-left">22</td>
                    </tr>
                    <tr>
                        <th class="label column-left">Physiotherapy Sessions</th>
                        <td class="column-left">54</td>
                        <td class="column-left">7</td>
                        <td class="column-left">61</td>
                    </tr>
                    <tr>
                        <th class="label column-left">Total</th>
                        <th class="column-left">73</th>
                        <th class="column-left">10</th>
                        <th class="column-left">83</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="reciept">
            <header class="header">
                <div>
                    <h4>Summary of Daily Patients State - SIRM</h4>
                </div>
            </header>
            <table class="ps-table">
                <thead>
                    <tr>
                        <th class="label column-left">Duration</th>
                        <th class="label column-left">From within CSC</th>
                        <th class="label column-left">From outside CSC</th>
                        <th class="label column-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="label column-left">18 Sep - 20 Oct 24<br>(Free Rehab Services)</td>
                        <td class="column-left">19</td>
                        <td class="column-left">3</td>
                        <td class="column-left">22</td>
                    </tr>
                    <tr>
                        <td class="label column-left">21 Oct - 24 Nov 24<br>(50% Charges on Rehab Services)</td>
                        <td class="column-left">54</td>
                        <td class="column-left">7</td>
                        <td class="column-left">61</td>
                    </tr>
                    <tr>
                        <th class="label column-left">Total</th>
                        <th class="column-left">73</th>
                        <th class="column-left">10</th>
                        <th class="column-left">83</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
