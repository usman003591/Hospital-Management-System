<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patient's Daily Record</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4 landscape;
            margin-top: 10mm 10mm;
        }

        .pr-container {
            width: 100%;
            max-width: 297mm;
            background-color: #fff;
            height: auto;
            margin: 60px auto auto auto;
            box-sizing: border-box;
        }

        header {
            margin: auto;
            height: auto;
            text-align: center;
            text-decoration: underline;
            margin-bottom: 15px;
        }

        .pr-table {
            width: 93%;
            max-width: 95%;
            border: 1px solid dimgray;
            font-size: x-small;
            margin: auto;
            height: auto;
            border-collapse: collapse;
        }

        thead {
            display: table-header-group;
            margin-bottom: 5mm;
        }

        tbody {
            display: table-row-group;
        }

        .pr-table tr {
            border-bottom: 1px solid dimgray;
            text-align: center;
            page-break-inside: avoid;
        }

        .pr-table th {
            padding: 5px 5px;
        }

        .pr-table td {
            padding: 7px 5px;
        }

        .column-left {
            border-left: 1px solid dimgray;
        }

        .hms-logo {
            margin-top: -40px;
            height: 50px;
            width: 50px;
        }

    </style>
</head>

<body>
    <div class="pr-container">
        <header class="header">
            <img class="hms-logo"
                src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($hospital->logo))) }}"
                alt="Logo">
            <h5>PATIENT'S DAILY RECORD SHEET</h5>
            <h5>{{ $hospital->name }} ({{ $hospital->hospital_abbreviation }})</h5>
        </header>
        <section>
            <table class="pr-table">

                @if(!$patientsData->isEmpty())
                @php
                 $i = 0;
                @endphp

                    <thead>
                        <tr>
                            <th style="width: 20px" rowspan="2">S/No</th>
                            <th class="column-left" rowspan="2" style="width: 15%;">Patient Name</th>
                            <th class="column-left" rowspan="2" style="width: 4%;">Age</th>
                            <th class="column-left" rowspan="2" style="width: 10%;">Phone Number</th>
                            <th class="column-left" rowspan="2" style="width: 15%;">Consultant/Doctor</th>
                            <th class="column-left" rowspan="2">Session Date Time</th>
                            <th class="column-left" rowspan="2" style="width: 10%;">Session / Procedure
                                By
                                Doctor</th>
                            <th class="column-left" colspan="3">Status</th>
                            <th class="column-left" rowspan="2">Remarks</th>
                            <th class="column-left" rowspan="2">Signature</th>

                        </tr>
                        <tr>
                            <th class="column-left">Resident</th>
                            <th class="column-left">Employee</th>
                            <th class="column-left">Private</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                         $i = 0;
                        @endphp
                        @foreach ($patientsData as $item)
                        {{-- @for ($i = 1; $i<=15; $i++) <tr> --}}
                             <tr>
                            <td>{{ $i++.'.' }}</td>
                            <td class="column-left">{{ $item->name_of_patient}}&nbsp;</td>
                            <td class="column-left">{{ $item->age}}&nbsp;</td>
                            <td class="column-left">{{ $item->phone}}&nbsp;</td>
                            <td class="column-left">{{ $item->doctor_name}}&nbsp;</td>
                            <td class="column-left">{{ getBasicDateTimeFormat($item->created_at) }} &nbsp;</td>
                            <td class="column-left"> &nbsp;</td>
                            <td class="column-left">@if ($item->patient_category == 'resident')
                                Yes
                             @else
                             No
                            @endif&nbsp;</td>
                            <td class="column-left">@if ($item->patient_category == 'employee')
                                Yes
                             @else
                             No
                            @endif&nbsp;</td>
                            <td class="column-left">@if ($item->patient_category == 'non_resident')
                                Yes
                             @else
                             No
                            @endif&nbsp;</td>
                            <td class="column-left">...&nbsp;</td>
                            <td class="column-left">...&nbsp;</td>
                            </tr>
                        @endforeach
                        {{-- <tr>
                            <td>{{ $i++.'.' }}</td>
                            <td class="column-left">{{ fake()->name() }}&nbsp;</td>
                            <td class="column-left">{{ fake()->numberBetween(0, 100) }}&nbsp;</td>
                            <td class="column-left">{{ fake()->e164phoneNumber() }}&nbsp;</td>
                            <td class="column-left">{{ 'Dr. '.fake()->name() }}&nbsp;</td>
                            <td class="column-left">{{ fake()->time('H:i', '24:00') }}&nbsp;</td>
                            <td class="column-left">{{ fake()->sentence(2) }}&nbsp;</td>
                            <td class="column-left">{{ fake()->randomElement(['Yes', 'No']) }}&nbsp;</td>
                            <td class="column-left">{{ fake()->randomElement(['Yes', 'No']) }}&nbsp;</td>
                            <td class="column-left">{{ fake()->randomElement(['Yes', 'No']) }}&nbsp;</td>
                            <td class="column-left">{{ fake()->word() }}&nbsp;</td>
                            <td class="column-left">{{ fake()->word() }}&nbsp;</td>
                            </tr> --}}
                            {{-- @endforeach --}}
                    </tbody>
                @else
                <thead>
                    <tr>
                        <th style="width: 20px" rowspan="2">S/No</th>
                        <th class="column-left" rowspan="2" style="width: 15%;">Patient Name</th>
                        <th class="column-left" rowspan="2" style="width: 4%;">Age</th>
                        <th class="column-left" rowspan="2" style="width: 10%;">Phone Number</th>
                        <th class="column-left" rowspan="2" style="width: 15%;">Consultant/Doctor</th>
                        <th class="column-left" rowspan="2">Session Time</th>
                        <th class="column-left" rowspan="2" style="width: 10%;">Session / Procedure
                            By
                            Doctor</th>
                        <th class="column-left" colspan="3">Status</th>
                        <th class="column-left" rowspan="2">Remarks</th>
                        <th class="column-left" rowspan="2">Signature</th>

                    </tr>
                    <tr>
                        <th class="column-left">Resident</th>
                        <th class="column-left">Employee</th>
                        <th class="column-left">Private</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i<=15; $i++) <tr>
                        <td>{{ $i.'.' }}</td>
                        <td class="column-left">{{ fake()->name() }}&nbsp;</td>
                        <td class="column-left">{{ fake()->numberBetween(0, 100) }}&nbsp;</td>
                        <td class="column-left">{{ fake()->e164phoneNumber() }}&nbsp;</td>
                        <td class="column-left">{{ 'Dr. '.fake()->name() }}&nbsp;</td>
                        <td class="column-left">{{ fake()->time('H:i', '24:00') }}&nbsp;</td>
                        <td class="column-left">{{ fake()->sentence(2) }}&nbsp;</td>
                        <td class="column-left">{{ fake()->randomElement(['Yes', 'No']) }}&nbsp;</td>
                        <td class="column-left">{{ fake()->randomElement(['Yes', 'No']) }}&nbsp;</td>
                        <td class="column-left">{{ fake()->randomElement(['Yes', 'No']) }}&nbsp;</td>
                        <td class="column-left">{{ fake()->word() }}&nbsp;</td>
                        <td class="column-left">{{ fake()->word() }}&nbsp;</td>
                        </tr>
                        @endfor
                </tbody>
                @endif
            </table>

        </section>
    </div>
</body>

</html>
