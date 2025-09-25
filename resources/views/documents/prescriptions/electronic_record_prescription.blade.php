<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Slip</title>
    <style>
        * {
            margin: 0;
            padding: 0;
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
            padding: 0;
        }

        .prescription-container {
            width: 100%;
            max-width: 200mm;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            height: 100%;
            box-sizing: border-box;
        }

        /* table {
            margin-top: 50px;
        } */

        .header {
            margin-bottom: 20px;
        }

        .tables {
            font-size: 14px;
        }

        .hms-logo {
            height: 70px;
            width: 70px;
            margin-bottom: 40px
        }

        .csc-logo {
            height: 70px;
            width: 75px;
            margin-bottom: 33px
        }

        .title-section {
            width: 60%;
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
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .attributes-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .attributes-table tr {
            padding-bottom: 20px;
        }

        .attributes-table td {
            padding: 12px 5px 3px 5px;
            vertical-align: top;
            line-height: 20px;
            border-bottom: 1px solid dimgray;
        }

        .attributes-table th {
            padding: 12px 5px 3px 5px;
            vertical-align: top;
            line-height: 20px;
            text-align: left;
            width: 15%;
            white-space: nowrap;
        }

        .value-left {
            width: 30%;
        }

        .value-right {
            width: 23%;
        }

        .attributes-table .label-right {
            padding-left: 16px;
        }

        .prescription-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 25px;
            page-break-inside: avoid;

        }

        .prescription-table th {
            width: 22%;
            text-align: left;
            vertical-align: top;
            padding: 10px 5px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .prescription-table td {
            text-align: left;
            vertical-align: top;
            padding: 10px 5px;
            border-bottom: 1px solid #ddd;
            word-wrap: break-word;
            line-height: 20px;
        }

        .investigations td {
            width: 50%;
        }

        .default-table {
            width: 100%;
            border-collapse: collapse;
            /* table-layout: fixed; */
            margin-bottom: 20px;
            border: 1px solid dimgray;
            page-break-inside: avoid;
        }

        .default-table th {
            text-align: center;
            vertical-align: middle;
            padding: 7px 5px;
            border-bottom: 1px solid dimgray;
            /* border-collapse: collapse; */
        }

        .default-table td {
            text-align: left;
            vertical-align: middle;
            padding: 7px 5px;
            border-bottom: 1px solid dimgray;
            /* border-collapse: collapse; */
        }

        .column-left {
            border-left: 1px solid dimgray;
            /* border-right: 1px solid dimgray !important; */
        }

        .next-visit {
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .footer {
            font-size: 12px;
            padding-top: 5px;
            text-align: right;
            page-break-inside: avoid;
        }

        /* .footer .qr {
            height: 6rem;
            width: 6rem;
            margin-right: 50px;
        } */

        @media screen and (max-width: 768px) {

            .attributes-table .label,
            .attributes-table .value {
                display: block;
                width: 100%;
                margin-bottom: 10px;
            }
        }


        /*investigations styles start from here*/
        .investigations-table {
            width: 100%;
            margin-bottom: 20px;
            padding: 0;
            border-top: 1px solid dimgray;
            border-left: 1px solid dimgray;
            border-right: 1px solid dimgray;
            border-collapse: collapse;
        }

        .investigations-table td {
            width: 30%;
            margin: 0;
            padding: 0;
        }

        .investigation-types {
            width: 100%;
            border-top: 1px solid dimgray;
            border-right: 1px solid dimgray;
            /* border-bottom: 1px solid dimgray; */
            border-collapse: collapse;
        }


        .investigation-types td {
            padding: 7px 5px;
        }

        .investigation-types th {
            padding: 7px 5px;
        }

        .investigation-types-3 {
            width: 100%;
            border-top: 1px solid dimgray;
            /* border-bottom: 1px solid dimgray; */
            border-collapse: collapse;
        }

        .investigation-types-3 td {
            padding: 7px 5px;
        }

        .investigation-types-3 th {
            padding: 7px 5px;
        }

        .row-bottom {
            border-bottom: 1px solid dimgray;
        }

        /*ends here*/

        /*gpe starts here*/
        .gpe-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid dimgray;
            page-break-inside: avoid;
        }

        .gpe-table td {
            text-align: left;
            vertical-align: middle;
            padding: 7px 5px;
            border-bottom: 1px solid dimgray;
        }

        .gpe-table th {
            width: 50%;
            text-align: center;
            vertical-align: middle;
            padding: 7px 5px;
            border-bottom: 1px solid dimgray;
        }

        /*gpe ends here*/

        /*spe starts here*/
        .spe-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid dimgray;
            page-break-inside: avoid;
        }

        .spe-table td {
            text-align: left;
            vertical-align: middle;
            padding: 7px 5px;
            border-bottom: 1px solid dimgray;
        }

        .spe-table th {
            width: 50%;
            text-align: center;
            vertical-align: middle;
            padding: 7px 5px;
            border-bottom: 1px solid dimgray;
        }

        /*spe ends here*/

        /* diagnosis starts here */
        .diagnosis-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid dimgray;
            page-break-inside: avoid;
        }

        .diagnosis-table td {
            text-align: left;
            vertical-align: middle;
            padding: 7px 5px;
            border-bottom: 1px solid dimgray;
        }

        .diagnosis-table th {
            width: 50%;
            text-align: center;
            vertical-align: middle;
            padding: 7px 5px;
            border-bottom: 1px solid dimgray;
        }

        /* diagnosis ends here */

        /*complaints-table starts here*/
        .complaints-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid dimgray;
            page-break-inside: avoid;
        }

        .complaints-table td {
            text-align: left;
            vertical-align: middle;
            padding: 7px 5px;
            border-bottom: 1px solid dimgray;
        }

        .complaints-table th {
            width: 50%;
            text-align: center;
            vertical-align: middle;
            padding: 7px 5px;
            border-bottom: 1px solid dimgray;
        }

        /*complaints table ends here*/
    </style>
</head>

<body>
    <div class="prescription-container">
        <header class="header">
            <table style="width: 100%; table-layout: fixed; height: 10%;">
                <tr>
                    <td style="width: 20%; text-align: left;">
                        <img class="hms-logo"
                            src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path($hospital->logo)))}}"
                            alt="Logo">
                    </td>
                    <td class="title-section">
                        <div style="margin-top: 20px">
                            <h2>{{$hospital->name}}</h2>
                            <h2>({{$hospital->hospital_abbreviation}})</h2>
                            <h5><strong>Health Directorate</strong></h5>
                        </div>
                    </td>
                    <td style="width: 20%; text-align: right;">
                        <img class="csc-logo"
                            src="{{ file_exists(public_path($hospital->project_logo)) ?
                                            'data:image/png;base64,' . base64_encode(file_get_contents(public_path($hospital->project_logo))) :
                                            'data:image/png;base64,' . base64_encode(file_get_contents(public_path('samrtcitylogo.png'))) }}"
                            alt="Smart City Logo">
                    </td>
                </tr>
            </table>
        </header>

        <div style="font-size : 14px !important;">
        {{$snap_history_unique_identifier}}
        </div>

        <div class="tables">
            <section class="details">
                <table class="attributes-table">
                    <tbody>
                        <tr>
                            <th class="label-left">Consultant:</th>
                            <td class="value-left" colspan="3">
                                @isset($doctor_data)
                                {{ $doctor_data->doctor_name }}
                                @endisset
                            </td>
                            <th class="label-right">Department:</th>
                            <td class="value-right">
                                @isset($doctor_data)
                                {{ $department_data->name }}
                                @endisset
                            </td>

                        </tr>

                        <tr>
                            <th class="label-left">Patient Name:</th>
                            <td class="value-left" colspan="3">@isset($patient)
                                {{ucfirst($patient->name_of_patient)}}
                                @endisset</td>
                            <th class="label-right">Category:</th>
                            <td class="value-right">@isset($patient)
                                {{titleFilter($patient->patient_category)}}
                                @endisset
                            </td>

                        </tr>
                        <tr>
                            <th class="label-left">Gender:</th>
                            <td class="value-left">@isset($patient)
                                {{ucfirst($patient->gender)}}
                                @endisset</td>
                            <th style="width: 8%; padding-left: 18px;">Age:</th>
                            <td style="width: 15%">@isset($patient)
                                {{$patient->age}}
                                @endisset years</td>
                            <th class="label-right">Date:</th>
                            <td class="value-right">{{ getBasicDateFormat($obj->created_at, 'd-m-Y') ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="label-left">CNIC No:</th>
                            <td class="value-left" colspan="3">@isset($patient)
                                {{$patient->cnic_number}}
                                @endisset</td>
                            <th class="label-right">MR No:</th>
                            <td class="value-right">@isset($patient)
                                {{$patient->patient_mr_number}}
                                @endisset</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="content">
                <table class="prescription-table">
                    <tbody>

                        @if(in_array('brief_history', $module_values))
                        <tr>
                            <th>Brief History:</th>
                            <td>@isset($cdCdBriefHistory){{$cdCdBriefHistory->value}}@endisset</td>
                        </tr>
                        @endif

                        {{-- <tr>
                            <th>Diagnosis:</th>
                            <td>

                            </td>
                        </tr> --}}
                    </tbody>
                </table>


                @if(in_array('complaints', $module_values))
                <table class="complaints-table">
                    <thead>
                        <tr>
                            <th colspan="2"> Complaints Section </th>
                        </tr>
                        <tr>
                            <th>Complaints</th>
                            <th class="column-left">Additional Complaints</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($cdComplaintData)
                        @foreach ($cdComplaintData as $complaint_data)
                        <tr>
                            <td>{{ $complaint_data->complaint_name }} {{'from '.$complaint_data->complaint_duration.'
                                days'}}</td>
                            <td class="column-left">
                                @foreach ($complaint_data->child_data as $cd)
                                {{$cd->complaint_name}}<br>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>&nbsp;</td>
                            <td class="column-left">
                                &nbsp;
                            </td>
                        </tr>
                        @endisset
                    </tbody>
                </table>
                @endif

                {{--cdDiagnosisData--}}
                @if(in_array('diagnosis', $module_values))
                <table class="diagnosis-table">
                    <thead>
                        <tr>
                            <th colspan="1" class="column-left"> Diagnosis </th>
                        </tr>
                        {{-- <tr>
                            <th>Diagnosis</th>
                            <th class="column-left">Additional Diagnosis</th>
                        </tr> --}}
                    </thead>
                    <tbody>
                        @isset($cdDiagnosisData)
                        @foreach ($cdDiagnosisData as $diagnosis_data)
                        <tr>
                            <td>{{ $diagnosis_data->diagnosis_name }}</td>
                            {{-- <td class="column-left">
                                @foreach ($diagnosis_data->child_data as $cd)
                                {{$cd->diagnosis_name}}<br>
                                @endforeach
                            </td> --}}
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="column-left">
                                &nbsp;
                            </td>
                        </tr>
                        @endisset
                    </tbody>
                </table>
                @endif

                {{--cdGPEData--}}
                @if(in_array('gpe', $module_values))
                <table class="gpe-table">
                    <thead>
                        <tr>
                            <th colspan="2">General Physical Examinations</th>
                        </tr>
                        <tr>
                            <th>GPE</th>
                            <th class="column-left">Additional GPE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($cdGPEData)
                        @foreach ($cdGPEData as $gpe_data)
                        <tr>
                            <td>{{ $gpe_data->gpe_name }}</td>
                            <td class="column-left">
                                @foreach ($gpe_data->child_data as $cd)
                                {{$cd->gpe_name}}<br>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>&nbsp;</td>
                            <td class="column-left">
                                &nbsp;
                            </td>
                        </tr>
                        @endisset
                    </tbody>
                </table>
                @endif

                {{-- cdSPEData --}}
                @if(in_array('spe', $module_values))
                <table class="spe-table">
                    <thead>
                        <tr>
                            <th colspan="2">Systemic Physical Examinations</th>
                        </tr>
                        <tr>
                            <th>SPE</th>
                            <th class="column-left">Additional SPE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($cdSPEData)
                        @foreach ($cdSPEData as $spe_data)
                        <tr>
                            <td>{{ $spe_data->spe_name }}</td>
                            <td class="column-left">
                                @foreach ($spe_data->child_data as $cd)
                                {{$cd->spe_name}}<br>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>&nbsp;</td>
                            <td class="column-left">
                                &nbsp;
                            </td>
                        </tr>
                        @endisset
                    </tbody>
                </table>
                @endif

                @if(in_array('investigations', $module_values))
                <table class="investigations-table" style="width: 100%">
                    <thead>
                        <th colspan="3" style="padding: 7px 5px;">
                            Investigations
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 30%">
                                <table class="investigation-types">
                                    <thead>
                                        <th class="row-bottom">Radiology</th>
                                    </thead>
                                    <tbody>

                                        @isset($investigationsRadiologyData)
                                        @foreach ($investigationsRadiologyData as $data)
                                        <tr>
                                            <td class="row-bottom">{{$data->investigation_name}}</td>
                                        </tr>
                                        @endforeach
                                        @endisset

                                        @isset($fillableRadiologyInvestigations )
                                        @for($i = 0; $i < $fillableRadiologyInvestigations; $i++) <tr>
                                            <td class="row-bottom">&nbsp;</td>
                        </tr>
                        @endfor
                        @endisset

                    </tbody>
                </table>
                </td>
                <td style="width: 30%">
                    <table class="investigation-types">
                        <thead>
                            <th class="row-bottom">Pathology</th>
                        </thead>
                        <tbody>

                            @isset($investigationsPathologyData)
                            @foreach ($investigationsPathologyData as $data)
                            <tr>
                                <td class="row-bottom">{{$data->investigation_name}}</td>
                            </tr>
                            @endforeach
                            @endisset

                            @isset($fillablePathologyInvestigations )
                            @for($i = 0; $i < $fillablePathologyInvestigations; $i++) <tr>
                                <td class="row-bottom">&nbsp;</td>
                                </tr>
                                @endfor
                                @endisset

                        </tbody>
                    </table>

                </td>
                <td style="width: 30%">
                    <table class="investigation-types-3">
                        <thead>
                            <th class="row-bottom">Rehabilitation</th>
                        </thead>
                        <tbody>
                            @isset($investigationsRehablitationData)
                            @foreach ($investigationsRehablitationData as $data)
                            <tr>
                                <td class="row-bottom">{{$data->investigation_name}}</td>
                            </tr>
                            @endforeach
                            @endisset

                            @isset($fillableRehablitationInvestigations )
                            @for($i = 0; $i < $fillableRehablitationInvestigations; $i++) <tr>
                                <td class="row-bottom">&nbsp;</td>
                                </tr>
                                @endfor
                                @endisset
                        </tbody>
                    </table>

                </td>
                </tr>
                </tbody>

                </table>

                {{-- <table class="default-table investigations">
                    <thead>
                        <tr>
                            <th colspan="3">Investigations</th>
                        </tr>
                        <tr>
                            <th class="column-left">Radiology</th>
                            <th class="column-left">Pathology</th>
                            <th class="column-left">Rehabilitation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                        </tr>
                    </tbody>
                </table> --}}
                @endif

                @if(in_array('vitals', $module_values))
                @isset($updatedVitalData)
                <table class="default-table">
                    <thead>
                        <tr>
                            <th colspan="8">Vitals</th>
                        </tr>
                        <tr>
                            @isset($vitals)
                            @foreach ($vitals as $item)
                            <th class="column-left">{{$item->name}}/{{$item->unit}} </th>
                            @endforeach
                            @endisset
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($updatedVitalData as $updateitem)
                            @isset($updateitem->value)
                            <td class="column-left">
                                {{$updateitem->value}}
                            </td>
                            @endisset
                            @endforeach
                        </tr>
                    </tbody>
                </table>
                @else
                <table class="default-table">
                    <thead>
                        <tr>
                            <th colspan="8" class="column-left">Vitals</th>
                        </tr>
                        <tr>

                            @isset($vitals)
                            @foreach ($vitals as $item)
                            <th class="column-left">{{$item->name}}/{{$item->unit}} </th>
                            @endforeach
                            @endisset

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                @endif
                @endif





                {{-- Diagnosis --}}
                {{-- <table class="default-table">
                    <thead>
                        <tr>
                            <th colspan="8">Vitals</th>
                        </tr>
                        <tr>
                            <th>Pulse/min</th>
                            <th class="column-left">B.P (mmHg)</th>
                            <th class="column-left">Temperature (F)</th>
                            <th class="column-left">Respiratory Rate/min</th>
                            <th class="column-left">Height (cm)</th>
                            <th class="column-left">Weight (cm)</th>
                            <th class="column-left" style="width: 8%;">BMI</th>
                            <th class="column-left">OFC (cm)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                            <td class="column-left">&nbsp;</td>
                        </tr>
                    </tbody>
                </table> --}}

                {{-- @if(in_array('brief_history', $module_values))
                @endif --}}

                @if(in_array('treatment',$module_values))
                @isset($treatment_data)
                <table class="default-table">
                    <thead>
                        <tr>
                            <th colspan="5" class="column-left">Medication</th>
                        </tr>
                        <tr>
                            <th style="width: 25%;">Medicine</th>
                            <th class="column-left" style="width: 15%;">Dosage</th>
                            <th class="column-left" style="width: 15%;">Interval</th>
                            <th class="column-left" style="width: 15%;">Duration</th>
                            <th class="column-left" style="width: 30%;">Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($treatment_data as $td)
                        <tr>
                            <td>{{$td->medicine_name}} &nbsp;</td>
                            <td class="column-left">{{$td->treatment_dosage_name}} &nbsp;</td>
                            <td class="column-left">{{$td->treatment_dose_interval}} &nbsp;</td>
                            <td class="column-left">{{$td->treatment_duration}} &nbsp;</td>
                            <td class="column-left">{{$td->remarks}} &nbsp;</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <table class="default-table">
                    <thead>
                        <tr>
                            <th colspan="5" class="column-left">Medication</th>
                        </tr>
                        <tr>
                            <th style="width: 25%;">Medicine</th>
                            <th class="column-left" style="width: 15%;">Dosage</th>
                            <th class="column-left" style="width: 15%;">Interval</th>
                            <th class="column-left" style="width: 15%;">Duration</th>
                            <th class="column-left" style="width: 30%;">Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> &nbsp;</td>
                            <td> &nbsp;</td>
                            <td> &nbsp;</td>
                            <td> &nbsp;</td>
                            <td> &nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                @endisset
                @endif

            {{-- </section> --}}
        </div>


        <section class="next-visit">
            <p><strong>Next Visit:</strong> ____________________</p>
        </section>

        <div class="footer">
            <footer>
                {{-- <img class="qr"
                    src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('QR_code.png')))}}"
                    alt="QR Code"> --}}
                <p>(NOT VALID FOR COURT OF LAW)</p>
            </footer>
        </div>
    </div>
</body>

</html>
