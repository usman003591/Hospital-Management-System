<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Electronic Generated Prescription Slip</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
        }

        @page {
            size: A4;
            margin: 20mm;
        }

        /* @page {
            size: A4;
            margin: 20mm;
        } */

        /* @page {
            size: A4;
            margin-left: 50mm;
            margin-top: 20mm;
            margin-right: 20mm;
            margin-bottom: 20mm;
        } */

        @media print {
            body {
                margin-bottom: 100px;
                /* Reserve space for fixed footer */
            }
        }

        .prescription-container {
            width: 100%;
            max-width: 200mm;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            box-sizing: border-box;
        }

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

        .details {
            margin-bottom: 10px;
        }

        .attributes-table,
        .vitals-table,
        .investigations-table,
        .brief-history-table,
        .diagnosis-table,
        .complaints-table,
        .disposal_table,
        .medications-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
            font-size: 10px;
        }

        .attributes-table th,
        .attributes-table td,
        .vitals-table th,
        .vitals-table td,
        .investigations-table th,
        .investigations-table td,
        .brief-history-table th,
        .brief-history-table td,
        .diagnosis-table th,
        .diagnosis-table td,
        .complaints-table th,
        .complaints-table td,
        .disposal_table th,
        .disposal_table td,
        .medications-table th,
        .medications-table td {
            padding: 7px 5px;
            border: 1px solid dimgray;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-all;
            text-align: left;
        }

        .layout-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .layout-table td {
            vertical-align: top;
            padding: 0 10px;
        }

        .left-section {
            width: 35%;
        }

        .right-section {
            width: 65%;
        }

        .medications-table th:nth-child(1) {
            width: 40%;
        }

        .medications-table th:nth-child(2) {
            width: 15%;
        }

        .medications-table th:nth-child(3) {
            width: 15%;
        }

        .medications-table th:nth-child(4) {
            width: 15%;
        }

        .footer {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            font-size: 10px;
            margin-top: 30px;
        }

        .footer .right-content {
            display: flex;
            align-items: center;
            font-size: 9px;
        }

        .footer .right-content img {
            width: 80px;
            height: 80px;
            margin-right: 60px;
        }

        .footer .left-content {
            font-size: 10px;
            margin-right: 80px;
        }

        @media print {

            body,
            .prescription-container {
                margin: 0 !important;
                padding: 0 !important;
            }

            .footer {
                position: static !important;
                page-break-inside: avoid;
            }

            table,
            section {
                page-break-inside: auto !important;
                page-break-after: auto !important;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div style="width: 100%; box-sizing: border-box; page-break-after: always;">
        <div style="padding: 10px 20px; page-break-inside: avoid; max-height: 900px;">
            <!-- Header -->
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


            <div class="tables">
                <section class="details">
                    <table class="attributes-table"
                        style="border-collapse: collapse; width: 100%; table-layout: fixed; font-size: 14px;">
                        <tbody>

                            <tr>
                                <th style="border: none; text-align: left; padding: 6px;">Patient Name:</th>
                                <td colspan="3"
                                    style="border: none; border-bottom: 1px solid #000; text-align: left; padding: 6px;">
                                    @isset($patient) {{ ucfirst($patient->name_of_patient) }} @endisset
                                </td>
                                <th style="border: none; text-align: left; padding: 6px;">Category:</th>
                                <td
                                    style="border: none; border-bottom: 1px solid #000; text-align: left; padding: 6px;">
                                    @isset($patient) {{ titleFilter($patient->patient_category) }} @endisset
                                </td>
                            </tr>

                            <tr>
                                <th style="border: none; text-align: left; padding: 6px;">CNIC No:</th>
                                <td colspan="3"
                                    style="border: none; border-bottom: 1px solid #000; text-align: left; padding: 6px;">
                                    @isset($patient) {{ $patient->cnic_number }} @endisset
                                </td>
                                <th style="border: none; text-align: left; padding: 6px;">MR No:</th>
                                <td
                                    style="border: none; border-bottom: 1px solid #000; text-align: left; padding: 6px;">
                                    @isset($patient) {{ $patient->patient_mr_number }} @endisset
                                </td>
                            </tr>

                            <tr>
                                <th style="border: none; text-align: left; padding: 6px;">Gender:</th>
                                <td
                                    style="border: none; border-bottom: 1px solid #000; text-align: left; padding: 6px;">
                                    @isset($patient) {{ ucfirst($patient->gender) }} @endisset
                                </td>
                                <th style="border: none; text-align: left; padding: 6px; width: 8%;">Age:</th>
                                <td
                                    style="border: none; border-bottom: 1px solid #000; text-align: left; padding: 6px; width: 15%;">
                                    @isset($patient) {{ $patient->age }} years @endisset
                                </td>
                                <th style="border: none; text-align: left; padding: 6px;">Date:</th>
                                <td
                                    style="border: none; border-bottom: 1px solid #000; text-align: left; padding: 6px;">
                                    {{ getBasicDateFormat($obj->created_at, 'd-m-Y H:i') ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <th style="border: none; text-align: left; padding: 6px;">Consultant:</th>
                                <td colspan="3"
                                    style="border: none; border-bottom: 1px solid #000; text-align: left; padding: 6px;">
                                    @if(!empty($referredData['referred_from']) && !empty($referredData['name']))
                                    Referred from {{ $referredData['referred_from'] }} to {{ $referredData['name'] }}
                                    @elseif(!empty($doctor_data->doctor_name))
                                    {{ $doctor_data->doctor_name }}
                                    @endif
                                </td>
                                <th style="border: none; text-align: left; padding: 6px;">Department:</th>
                                <td
                                    style="border: none; border-bottom: 1px solid #000; text-align: left; padding: 6px;">
                                     @if(!is_null($department_data) && isset($department_data ))
                                     {{ $department_data->name }}
                                     @endif
                                </td>
                            </tr>

                            @if (!empty($patient->designation))
                            <tr>
                                <th style="border: none; text-align: left; padding: 6px;">Designation:</th>
                                <td colspan="5"
                                    style="border: none; border-bottom: 1px solid #000; text-align: left; padding: 6px;">
                                    {{ $patient->designation }}
                                </td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                </section>

                <table class="layout-table">
                    <tr>
                        <!-- Left section (35% width): Vitals, Investigations, and Complaints -->
                        <td class="left-section">
                            <!-- Vitals Table -->
                            @if(in_array('vitals', $module_values))
                            @isset($updatedVitalData)
                            <table class="vitals-table" style="border: none; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th colspan="2"
                                            style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">
                                            Vitals</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($updatedVitalData as $updateitem)
                                    @isset($updateitem->value)
                                    <tr>
                                        <th style="border: none; text-align: left;">{{$updateitem->name}}</th>
                                        <td style="border: none; text-align: left;">{{$updateitem->value}} {{
                                            $updateitem->unit ?? '' }}</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <th style="border: none; text-align: left;">{{$updateitem->name}}</th>
                                        <td style="border: none; text-align: left;"></td>
                                    </tr>
                                    @endisset
                                    @endforeach

                                </tbody>
                            </table>
                            @else
                            <!-- Left section (35% width): Vitals, Investigations, and Complaints -->
                            <!-- Vitals Table -->
                            <table class="vitals-table" style="border: none; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th colspan="2"
                                            style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">
                                            Vitals</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="border: none; text-align: left;">Pulse/min</th>
                                        <td style="border: none; text-align: left;"></td>
                                    </tr>
                                    <tr>
                                        <th style="border: none; text-align: left;">BP (mmHg)</th>
                                        <td style="border: none; text-align: left;"></td>
                                    </tr>
                                    <tr>
                                        <th style="border: none; text-align: left;">Temp (°F)</th>
                                        <td style="border: none; text-align: left;"></td>
                                    </tr>
                                    <tr>
                                        <th style="border: none; text-align: left;">RR/min</th>
                                        <td style="border: none; text-align: left;"></td>
                                    </tr>
                                </tbody>
                            </table>
                            @endisset
                            @endif

                            @if(in_array('complaints', $module_values))
                            <table class="complaints-table" style="border: none; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th colspan="2"
                                            style="font-size: 13px; text-align: left; text-decoration: underline; border: none;">
                                            Complaints
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!is_null($cdComplaintData) && !empty($cdComplaintData) && $cdComplaintData->count() < 4)
                                    {{-- @isset($cdComplaintData) --}}
                                    @foreach ($cdComplaintData as $complaint_data)
                                    <tr>
                                        <th style="border: none; text-align: left; vertical-align: top;">
                                            {{ $complaint_data->complaint_name }}
                                            {{ !empty($complaint_data->complaint_duration) ? 'from ' .
                                            $complaint_data->complaint_duration . ' days' : '' }}
                                            <br>
                                            <br>
                                            <small>Remarks: {{ $complaint_data->complaint_remarks }}</small>
                                        </th>
                                        <td style="border: none; text-align: left;">
                                            @foreach ($complaint_data->child_data as $cd)
                                            {{ $cd->complaint_name }}@if(!$loop->last), @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                    {{-- @endisset --}}
                                    @else
                                    @for ($i = 0; $i < 3; $i++) <tr>
                                        <th style="border: none; text-align: left;">&nbsp;</th>
                                        <td style="border: none; text-align: left;">&nbsp;</td>
                    </tr>
                    @endfor
                    @endisset
                    </tbody>
                </table>
                @endif

                @if(in_array('investigations', $module_values))
                <table class="investigations-table" style="border: none; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="2"
                                style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">
                                Investigations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th style="border: none; text-align: left; vertical-align: top;">Radiology</th>
                            <td style="border: none; text-align: left;">
                                @isset($investigationsRadiologyData)
                                @foreach ($investigationsRadiologyData as $data)
                                {{ $data->investigation_name }}@if (!$loop->last), @endif
                                @endforeach
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th style="border: none; text-align: left; vertical-align: top;">Pathology</th>
                            <td style="border: none; text-align: left;">
                                @isset($investigationsPathologyData)
                                @foreach ($investigationsPathologyData as $data)
                                {{ $data->investigation_name }}@if (!$loop->last), @endif
                                @endforeach
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th style="border: none; text-align: left; vertical-align: top;">Rehabilitation
                            </th>
                            <td style="border: none; text-align: left;">
                                @isset($investigationsRehablitationData)
                                @foreach ($investigationsRehablitationData as $data)
                                {{ $data->investigation_name }}@if (!$loop->last), @endif
                                @endforeach
                                @endisset
                            </td>
                        </tr>

                    </tbody>
                </table>
                @else
                <table class="investigations-table" style="border: none; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="2"
                                style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">
                                Investigations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th style="border: none; text-align: left;">Radiology</th>
                            <td style="border: none; text-align: left;">&nbsp;</td>
                        </tr>
                        <tr>
                            <th style="border: none; text-align: left;">Pathology</th>
                            <td style="border: none; text-align: left;">&nbsp;</td>
                        </tr>
                        <tr>
                            <th style="border: none; text-align: left;">Rehabilitation</th>
                            <td style="border: none; text-align: left;">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                @endif

                @isset($referredData)
                @if($referredData['disposal_type'] && $referredData['remarks'])
                <table class="disposal_table" style="border: none; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="2"
                                style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">
                                Disposal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th style="border: none; text-align: left;">Disposal</th>
                            <td style="border: none; text-align: left; padding-top: 5px !important;">
                                @isset($referredData){{titleFilter($referredData['disposal_type'])}}@endisset
                                <br>
                                @isset($referredData){{$referredData['disposal_value']}}@endisset
                            </td>
                        </tr>
                        <tr>
                            <th style="border: none; text-align: left;">Remarks</th>
                            <td style="border: none; text-align: left; padding-top: 5px !important;">
                                @isset($referredData){{$referredData['remarks']}}@endisset</td>
                        </tr>
                    </tbody>
                </table>
                @endif
                @else
                <table class="disposal_table" style="border: none; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="2"
                                style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">
                                Disposal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th style="border: none; text-align: left;">Disposal</th>
                            <td style="border: none; text-align: left; padding-top: 5px !important;"></td>
                        </tr>
                        <tr>
                            <th style="border: none; text-align: left;">Remarks</th>
                            <td style="border: none; text-align: left; padding-top: 5px !important;"></td>
                        </tr>
                    </tbody>
                </table>
                @endif


                @php
                $leftCount =
                count($updatedVitalData ?? []) +
                count($cdComplaintData ?? []) +
                (isset($investigationsRadiologyData) ? 1 : 0) +
                (isset($investigationsPathologyData) ? 1 : 0) +
                (isset($investigationsRehablitationData) ? 1 : 0) +
                (isset($referredData['disposal_type']) && isset($referredData['remarks']) ? 2 : 0);

                $rightCount = count($treatment_data ?? []);

                $fillerCount = max(0, $rightCount - $leftCount);

                if (!is_null($treatment_data) && !empty($treatment_data)) {
                    if($treatment_data->count() < 15) { $fillerCount=4; }
                    if($treatment_data->count() == 0) { $fillerCount=8; }
                } @endphp
                <table
                    style="border: none; border-collapse: collapse; width: 100%;">
                    <tbody>
                        @for ($i = 0; $i < $fillerCount; $i++) <tr>
                            <th style="border: none;">&nbsp;</th>
                            <td style="border: none;">&nbsp;</td>
                            </tr>
                            @endfor
                    </tbody>
                    </table>

                    </td>
                    <td class="right-section">
                        {{-- --}}
                        @if(in_array('brief_history', $module_values))
                        @if(!is_null($treatment_data) && !empty($treatment_data) && count($treatment_data) < 15)
                        <table
                            class="brief-history-table" style="border: none; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th colspan="1"
                                        style="border: none; text-align: left; text-decoration: underline; font-size : 13px">
                                        Brief History</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th style="border: none; text-align: left;">
                                        @isset($cdCdBriefHistory){{$cdCdBriefHistory->value}} @else &nbsp; @endisset
                                    </th>
                                </tr>
                            </tbody>
                            </table>
                            @endif



                            @if(in_array('diagnosis', $module_values))
                            <table class="diagnosis-table" style="border: none; border-collapse: collapse;">
                                <thead>

                                    <tr>
                                        <th colspan="2"
                                            style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">
                                            Diagnosis</th>
                                    </tr>
                                    <tr>
                                        <th style="width:63%; border: none;">Diagnosis & Remarks</th>
                                        <th style="width:37%; border: none;">Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($cdDiagnosisData)
                                    @foreach ($cdDiagnosisData as $diagnosis_data)
                                    <tr>
                                        <td style="border: none; text-align: left;">
                                            {{$diagnosis_data->diagnosis_name}}&nbsp; <br> {{$diagnosis_data->remarks}}
                                            &nbsp; </td>
                                        <td style="border: none; text-align: left;">
                                            {{$diagnosis_data->diagnosis_category_name}}&nbsp; </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="2" style="border: none; text-align: left;">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    @endisset
                                </tbody>
                            </table>
                            @endif
                            @endif

                            {{-- --}}

                            @if(in_array('treatment',$module_values))
                            @isset($treatment_data)
                            <table class="medications-table" style="table-layout: fixed;">
                                <thead>
                                    <tr>
                                        <th colspan="5"
                                            style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">
                                            Medications</th>
                                    </tr>
                                    <tr>
                                        <th style="width:45%; border: none;">Medicine & Instructions</th>
                                        <th style="width:20%; border: none;">Dosage</th>
                                        <th style="width:20%; border: none;">Route</th>
                                        <th style="width:15%; border: none;">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($treatment_data as $td)
                                    <tr>
                                        <td style="border: none; text-align: left;">{{$td->medicine_name}} &nbsp; <br>
                                            {{$td->remarks}} &nbsp; </td>
                                        <td style="border: none; text-align: left;">{{$td->treatment_dosage_name}}
                                            &nbsp; <br> {{$td->treatment_dose_interval}} </td>
                                        <td style="border: none; text-align: left;">{{$td->route_name}} &nbsp;</td>
                                        <td style="border: none; text-align: left;">{{$td->treatment_duration}} &nbsp;
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <table class="medications-table" style="table-layout: fixed;">
                                <thead>
                                    <tr>
                                        <th colspan="5"
                                            style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">
                                            Medications</th>
                                    </tr>
                                    <tr>
                                        <th style="width:45%; border: none;">Medicine & Instructions</th>
                                        <th style="width:20%; border: none;">Dosage</th>
                                        <th style="width:20%; border: none;">Route</th>
                                        <th style="width:15%; border: none;">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border: none; text-align: left;">&nbsp;</td>
                                        <td style="border: none; text-align: left;">&nbsp;</td>
                                        <td style="border: none; text-align: left;">&nbsp;</td>
                                        <td style="border: none; text-align: left;">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            @endisset
                            @endif


                    </td>
                    </tr>
                    </table>
            </div>

            @if(in_array('complaints', $module_values))
            @if(!is_null($cdComplaintData) && !empty($cdComplaintData) && $cdComplaintData->count() > 4)
                 <table class="complaints-table" style="border: none; border-collapse: collapse;">
                <thead>

                    <tr>
                        <th colspan="2"
                            style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">
                            Complaints</th>
                    </tr>
                    <tr>
                        <th style="width:63%; border: none;">Complaints</th>
                        <th style="width:63%; border: none;">Additional</th>
                        <th style="width:37%; border: none;">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($cdComplaintData)
                    @foreach ($cdComplaintData as $complaint_data)
                    <tr>
                        <td style="border: none; text-align: left;"> {{ $complaint_data->complaint_name }} {{ !empty($complaint_data->complaint_duration) ? 'from ' . $complaint_data->complaint_duration . ' days' : '' }}</td>
                        <td style="border: none; text-align: left;"> @foreach ($complaint_data->child_data as $cd)   {{ $cd->complaint_name }}@if(!$loop->last), @endif @endforeach </td>
                        <td style="border: none; text-align: left;">  {{ $complaint_data->complaint_remarks }} </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="3" style="border: none; text-align: left;">
                            &nbsp;
                        </td>
                    </tr>
                    @endisset
                </tbody>
            </table>
            @endif
            @endif


            @if(!is_null($treatment_data) && !empty($treatment_data) && count($treatment_data) > 15)
            @if(in_array('brief_history', $module_values))
            <table class="brief-history-table" style="border: none; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th colspan="1"
                            style="border: none; text-align: center; text-decoration: underline; font-size : 13px">
                            Brief History</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="border: none; text-align: left;">
                            @isset($cdCdBriefHistory){{$cdCdBriefHistory->value}} @else &nbsp; @endisset
                        </th>
                    </tr>
                </tbody>
            </table>
            @endif



            @if(in_array('diagnosis', $module_values))
            <table class="diagnosis-table" style="border: none; border-collapse: collapse;">
                <thead>

                    <tr>
                        <th colspan="2"
                            style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">
                            Diagnosis</th>
                    </tr>
                    <tr>
                        <th style="width:63%; border: none;">Diagnosis & Remarks</th>
                        <th style="width:37%; border: none;">Type</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($cdDiagnosisData)
                    @foreach ($cdDiagnosisData as $diagnosis_data)
                    <tr>
                        <td style="border: none; text-align: left;">{{$diagnosis_data->diagnosis_name}}&nbsp; <br>
                            {{$diagnosis_data->remarks}} &nbsp; </td>
                        <td style="border: none; text-align: left;">{{$diagnosis_data->diagnosis_category_name}}&nbsp;
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="2" style="border: none; text-align: left;">
                            &nbsp;
                        </td>
                    </tr>
                    @endisset
                </tbody>
            </table>
            @endif
            @endif





            <!-- Footer -->
            <!-- Footer -->
            <div style="
        display: grid;
        grid-template-columns: 1fr 1fr;
        width: 100%;
        padding: 10px 20px;
        box-sizing: border-box;
        border-top: 1px solid #ccc;
        font-size: 12px;
        align-items: start;
        page-break-inside: avoid;
    ">
                <!-- Left side -->
                <div style="text-align: left;">
                    <p style="margin: 0;"><strong>Next Visit / Follow Up:</strong> @isset($disposalData->disposal_type_value)<span style="border-bottom: 1px solid black; padding-bottom: 2px;">{{ \Carbon\Carbon::parse($disposalData->disposal_type_value)->format('d-m-Y h:i A') }}</span>@endisset</p>
                    <p style="margin: 10px 0 0 0;">(NOT VALID FOR COURT OF LAW)</p>
                </div>

                <!-- Right side -->
                <div style="text-align: right; padding-right: 30px; word-break: break-word;">
                    @if (!empty($qrCode))
                    <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" width="80" alt="QR Code"
                        style="margin-bottom: 5px;" />
                    @endif
                    <div style="font-size: 9px; font-weight: bold;">
                        {{ $snap_history_unique_identifier ?? '' }}
                    </div>

                </div>
            </div>
        </div>
        <!-- Overflow Content (Page 2) -->
        {{-- <div style="page-break-before: always;">
            <div style="padding: 10px 20px;">
                <h4>Additional Notes</h4>
                <p>Longer content here continues on a new page...</p>
            </div>
        </div> --}}

</body>

</html>
