<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Electronic Generated Prescription Slip</title>
  <style>
    /* Base reset */
    * {
      margin: 0;
      padding: 0;
    }
    /* Body styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      margin: 0;
      padding: 0;
    }
    /* Page settings */
    @page {
      size: A4;
      margin: 10mm;
    }
    /* Container */
    .prescription-container {
      width: 100%;
      max-width: 200mm;
      margin: auto;
      background-color: #fff;
      padding: 20px;
      box-sizing: border-box;
    }
    /* Header styles */
    .header {
      margin-bottom: 20px;
    }
    .hms-logo {
      height: 70px;
      width: 70px;
      margin-bottom: 40px;
    }
    .csc-logo {
      height: 70px;
      width: 75px;
      margin-bottom: 33px;
    }
    /* Title section */
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
    /* Details section */
    .details {
      margin-bottom: 10px;
      page-break-inside: avoid;
    }
    /* Attributes table */
    .attributes-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      page-break-inside: avoid;
    }
    .attributes-table td {
      padding: 12px 5px 3px 5px;
      vertical-align: top;
      font-size: 11px;
      line-height: 20px;
      border-bottom: 1px solid dimgray;
    }
    .attributes-table th {
      padding: 12px 5px 3px 5px;
      vertical-align: top;
      line-height: 20px;
      font-size: 13px;
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
    /* Layout using table for content section */
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
    /* Set font sizes for inner tables */
    .vitals-table,
    .investigations-table,
    .brief-history-table,
    .diagnosis-table,
    .complaints-table,
    .disposal_table,
    .medications-table {
      font-size: 10px;
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      border: 1px solid dimgray;
    }
    .vitals-table th,
    .investigations-table th,
    .brief-history-table th,
    .diagnosis-table th,
    .complaints-table th,
    .disposal_table th,
    .medications-table th {
      font-size: 10px;
      padding: 7px 5px;
      border: 1px solid dimgray;
    }
    .vitals-table td,
    .investigations-table td,
    .complaints-table td,
    .brief-history-table td,
    .diagnosis-table td,
    .medications-table td {
      font-size: 10px;
      padding: 7px 5px;
      border: 1px solid dimgray;
    }
    /* Force fixed table layout on all inner tables */
    .attributes-table,
    .vitals-table,
    .investigations-table,
    .brief-history-table,
    .diagnosis-table,
    .complaints-table,
    .disposal_table,
    .medications-table {
      table-layout: fixed;
    }
    /* Apply text wrapping to table cells */
    .attributes-table td,
    .vitals-table td,
    .investigations-table td,
    .brief-history-table td,
    .diagnosis-table td,
    .complaints-table td,
    .disposal_table td,
    .medications-table td {
      white-space: normal !important;
      word-wrap: break-word !important;
      overflow-wrap: break-word !important;
      word-break: break-all !important;
    }
    /* For the investigations table, force two equal-width columns */
    .investigations-table th,
    .investigations-table td {
      width: 50%;
    }
    /* Medications table: explicit column widths for wrapping */
    .medications-table th:nth-child(1) { width: 40%; }
    .medications-table th:nth-child(2) { width: 15%; }
    .medications-table th:nth-child(3) { width: 15%; }
    .medications-table th:nth-child(4) { width: 15%; }
    .medications-table th:nth-child(5) { width: 15%; }
    .medications-table th {
      text-align: left;
    }
    /* Next visit section */
    .next-visit {
      margin-top: 20px;
      page-break-inside: avoid;
    }
    /* Footer */
    .footer {

    }
    /* Media queries */
    @media screen and (max-width: 768px) {
      .attributes-table .label,
      .attributes-table .value {
        display: block;
        width: 100%;
        margin-bottom: 10px;
      }
      .layout-table, .medications-table {
        display: block;
      }
      .left-section,
      .right-section {
        width: 100%;
        display: block;
      }
    }
    /* Print styles */
    @media print {
      .prescription-container {
        padding: 0;
        margin: 0;
      }
      body {
        margin: 0;
        padding: 0;
      }
    }

    table {
        border: none !important;
        border-collapse: collapse !important;
    }

    /* .footer {
      position: fixed;
      left: 0;
      bottom: 10px;
      width: 100%;
      font-size: 12px;
      padding-top: 5px;
      text-align: right;
      page-break-inside: avoid;
    } */

    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
    }
    .footer .right-content {
        text-align: right;
        flex: 1;
        display: flex;
        align-items: center;
        font-size: 9px;
        margin-bottom: -30px;
    }
    .footer .right-content img {
        width: 80px;
        height: 80px;
        margin-right: 60px;
    }
    .footer .left-content {
        text-align: left;
        flex: 1;
        font-size: 10px;
        margin-bottom: 30px;
        margin-right: 80px;
    }

  </style>
</head>

<body>
  <div class="prescription-container">
    <header class="header">
      <table style="width: 100%; table-layout: fixed;">
        <tr>
          <td style="width: 20%; text-align: left;">
            <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path($hospital->logo)))}}" alt="Logo" class="hms-logo">
          </td>
          <td class="title-section">
            <div style="margin-top: 20px">
              <h2>{{$hospital->name}}</h2>
              <h2>({{$hospital->hospital_abbreviation}})</h2>
              <h5><strong>Health Directorate</strong></h5>
            </div>
          </td>
          <td style="width: 20%; text-align: right;">
            <img src="{{ file_exists(public_path($hospital->project_logo)) ?
                                            'data:image/png;base64,' . base64_encode(file_get_contents(public_path($hospital->project_logo))) :
                                            'data:image/png;base64,' . base64_encode(file_get_contents(public_path('samrtcitylogo.png'))) }}" alt="Capital Smart City Logo" class="csc-logo">
          </td>
        </tr>
      </table>
    </header>
    <!-- Details Section -->
    <div class="tables">


        <section class="details">
            <table class="attributes-table">
                <tbody>

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
                        <th class="label-left">CNIC No:</th>
                        <td class="value-left" colspan="3">@isset($patient)
                            {{$patient->cnic_number}}
                            @endisset</td>
                        <th class="label-right">MR No:</th>
                        <td class="value-right">@isset($patient)
                            {{$patient->patient_mr_number}}
                            @endisset</td>
                    </tr>

                    <tr>
                        <th class="label-left">Gender:</th>
                        <td class="value-left">@isset($patient)
                            {{ucfirst(string: $patient->gender)}}
                            @endisset</td>
                        <th style="width: 8%; padding-left: 18px;">Age:</th>
                        <td style="width: 15%">@isset($patient)
                            {{$patient->age}}
                            @endisset years</td>
                        <th class="label-right">Date:</th>
                        <td class="value-right">{{ getBasicDateFormat($obj->created_at, 'd-m-Y H:i') ?? '' }}</td>
                    </tr>

                    <tr>
                        <th class="label-left">Consultant:</th>
                        <td class="value-left" colspan="3">
                            @if(!is_null($referredData['referred_from']) && !is_null($referredData['name']))
                              @isset($referredData) Referred from {{$referredData['referred_from']}} to {{$referredData['name']}}  @endisset
                            @else
                            @isset($doctor_data)
                            @if (!is_null($doctor_data->doctor_name))
                            {{ $doctor_data->doctor_name }}
                            @endif
                            @endisset
                            @endif
                        </td>
                        <th class="label-right">Department:</th>
                        <td class="value-right">
                            @isset($doctor_data)
                            {{ $department_data->name }}
                            @endisset
                        </td>
                    </tr>

                    <tr>
                        {{-- @isset($referredData['remarks'])
                        <th class="label-left">Remarks:</th>
                        <td class="value-left" colspan="3">
                         @isset($referredData) {{$referredData['remarks']}} @endisset
                        </td>
                        @else --}}
                        <th class="label-left" style="d-none"></th>
                        <td class="value-left" colspan="3" style="d-none !important; border: none"></td>
                        {{-- @endif --}}
                        @isset($patient->designation)
                        <th class="label-right">Designation:</th>
                        <td class="value-right">
                         @isset($patient->designation) {{$patient->designation}} @endisset
                        </td>
                        @else
                       <th class="label-right" style="d-none !important; border: none"></th>
                        <td class="value-right" style="d-none !important; border: none"></td>
                        @endif
                    </tr>

                    {{-- @isset($patient->designation)
                    <tr>
                               <th class="label-left"></th>
                        <td class="value-left" colspan="3" style="display: none"></td>
                           <th class="label-right">Designation:</th>
                        <td class="value-right" >
                        {{$patient->designation}}
                        </td> --}}
                        {{-- @isset($referredData)
                        <th class="label-left">Remarks:</th>
                        <td class="value-left" colspan="3" style="padding-left: 6px;" >@isset($referredData) {{$referredData['remarks']}} @endisset</td>
                        @else
                        <th class="label-left"></th>
                        <td class="value-left" colspan="3" style="display: none"></td>
                        @endisset
                        <th class="label-right">Designation:</th>
                        <td class="value-right" >
                        {{$patient->designation}}
                        </td> --}}
                    {{-- </tr>
                    @endisset --}}

                </tbody>
            </table>
        </section>

      @if(in_array('vitals', $module_values))
      @isset($updatedVitalData)
      <table class="layout-table">
        <tr>
          <!-- Left section (35% width): Vitals, Investigations, and Complaints -->
          <td class="left-section">
            <!-- Vitals Table -->
            <table class="vitals-table" style="border: none; border-collapse: collapse;">
              <thead>
                <tr>
                  <th colspan="2" style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">Vitals</th>
                </tr>
              </thead>
              <tbody>
            @foreach ($updatedVitalData as $updateitem)
                @isset($updateitem->value)
                    <tr>
                        <th style="border: none; text-align: left;">{{$updateitem->name}}</th>
                        <td style="border: none; text-align: left;">{{$updateitem->value}}</td>
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
        <table class="layout-table">
        <tr>
          <!-- Left section (35% width): Vitals, Investigations, and Complaints -->
          <td class="left-section">
            <!-- Vitals Table -->
            <table class="vitals-table" style="border: none; border-collapse: collapse;">
              <thead>
                <tr>
                  <th colspan="2" style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">Vitals</th>
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
            @else
            @endif

           @if(in_array('complaints', $module_values))
           @isset($cdComplaintData)
           <table class="complaints-table" style="border: none; border-collapse: collapse;">
            <thead>
              <tr>
                <th colspan="2" style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">Complaints</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($cdComplaintData as $complaint_data)
                <tr>
                    <th style="border: none; text-align: left;">{{ $complaint_data->complaint_name }} {{'from '.$complaint_data->complaint_duration.' days'}}</th>
                    <td style="border: none; text-align: left;">@foreach ($complaint_data->child_data as $cd)
                        {{$cd->complaint_name. ','}} &nbsp;
                        @endforeach
                    </td>
                  </tr>
                @endforeach

            </tbody>
          </table>
          @else
          <table class="complaints-table" style="border: none; border-collapse: collapse;">
            <thead>
              <tr>
                <th colspan="2" style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">Complaints</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th style="border: none; text-align: left;">&nbsp;</th>
                <th style="border: none; text-align: left;">&nbsp;</th>
              </tr>
              <tr>
                <th style="border: none; text-align: left;">&nbsp;</th>
                <th style="border: none; text-align: left;">&nbsp;</th>
              </tr>
              <tr>
                <th style="border: none; text-align: left;" >&nbsp;</th>
                <th style="border: none; text-align: left;" >&nbsp;</th>
              </tr>
            </tbody>
          </table>
          @endisset
          @endif



          @if(in_array('investigations', $module_values))
          <table class="investigations-table" style="border: none; border-collapse: collapse;">
            <thead>
              <tr>
                <th colspan="2" style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">Investigations</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th style="border: none; text-align: left;">Radiology</th>
                <td style="border: none; text-align: left;">
                @isset($investigationsRadiologyData)
                @foreach ($investigationsRadiologyData as $data)
                {{$data->investigation_name}}&nbsp;
                @endforeach
                @endisset
                </td>
              </tr>
              <tr>
                <th style="border: none; text-align: left;">Pathology</th>
                <td style="border: none; text-align: left;">
                @isset($investigationsPathologyData)
                @foreach ($investigationsPathologyData as $data)
                {{$data->investigation_name}}&nbsp;
                @endforeach
                @endisset
              </td>
              </tr>
              <tr>
                <th style="border: none; text-align: left;">Rehabilitation</th>
                <td style="border: none; text-align: left;">
                @isset($investigationsRehablitationData)
                @foreach ($investigationsRehablitationData as $data)
                 {{$data->investigation_name}}&nbsp;
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
                <th colspan="2" style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">Investigations</th>
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
                <th colspan="2" style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">Disposal</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th style="border: none; text-align: left;">Disposal Type</th>
                <td style="border: none; text-align: left; padding-top: 5px !important;">  @isset($referredData){{$referredData['disposal_type']}}@endisset</td>
              </tr>
              <tr>
                <th style="border: none; text-align: left;">Remarks</th>
                <td style="border: none; text-align: left; padding-top: 5px !important;">  @isset($referredData){{$referredData['remarks']}}@endisset</td>
              </tr>
            </tbody>
          </table>
          @endif
         @endisset
            <!-- Investigations Table (two columns: type and value) -->
            <!-- Complaints Table -->

          </td>
          <!-- Right section (65% width): Medications -->
          <td class="right-section">
            <!-- Medications Table with fixed layout and explicit column widths -->
            @if(in_array('brief_history', $module_values))
            <table class="brief-history-table"  style="border: none; border-collapse: collapse;">
              <thead>
                <tr>
                  <th colspan="1" style="border: none; text-align: left; text-decoration: underline; font-size : 13px">Brief History</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th style="border: none; text-align: left;">@isset($cdCdBriefHistory){{$cdCdBriefHistory->value}} @else &nbsp; @endisset</th>
                </tr>
              </tbody>
            </table>
            @endif

            @if(in_array('diagnosis', $module_values))
            <table class="diagnosis-table" style="border: none; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th colspan="1" style="border: none; text-align: left; text-decoration: underline; font-size : 13px"> Diagnosis </th>
                    </tr>
                </thead>
                <tbody>
                    @isset($cdDiagnosisData)
                    @foreach ($cdDiagnosisData as $diagnosis_data)
                    <tr>
                        <td style="border: none; text-align: left;">{{ $diagnosis_data->diagnosis_name }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td style="border: none; text-align: left;">
                            &nbsp;
                        </td>
                    </tr>
                    @endisset
                </tbody>
            </table>
            @endif

            @if(in_array('treatment',$module_values))
            @isset($treatment_data)
            <table class="medications-table" style="table-layout: fixed;">
                <thead>
                  <tr>
                    <th colspan="5" style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">Medications</th>
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
                    <td style="border: none; text-align: left;">{{$td->medicine_name}} &nbsp; <br> {{$td->remarks}} &nbsp; </td>
                    <td style="border: none; text-align: left;">{{$td->treatment_dosage_name}} &nbsp; <br> {{$td->treatment_dose_interval}} </td>
                    <td style="border: none; text-align: left;">{{$td->route_name}} &nbsp;</td>
                    <td style="border: none; text-align: left;">{{$td->treatment_duration}} &nbsp;</td>
                </tr>
                @endforeach
                </tbody>
              </table>
            @else
            <table class="medications-table" style="table-layout: fixed;">
                <thead>
                  <tr>
                    <th colspan="5" style="font-size: 13px; text-align: left; text-decoration: underline; border: none; border-collapse: collapse;">Medications</th>
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
    <!-- Next visit section -->

    <footer class="footer">
        <div class="right-content">
            <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code" style="">
            <div style="margin-right : 65px; margin-top: 5px">{{$snap_history_unique_identifier}}</div>
        </div>
        <div class="left-content">
            <p><strong>Next Visit:</strong> ____________________</p>
            <p>(NOT VALID FOR COURT OF LAW)</p>
        </div>
    </footer>

    <!-- Footer -->
    {{-- <div class="footer">
         <!-- QR Code Section: Positioned on the left, but shifted upward (negative margin) -->
         <section style="float:left;">
            <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code" style="margin :20px; marggin-top : -30px; width:75px; height:75px;">
            <div style="margin :20px; font-size : 8px; text-align : center">{{$snap_history_unique_identifier}}</div>
        </section>

      <footer class="margin-left: -50px !important;">
        <p><strong>Next Visit:</strong> ____________________</p><br>
        <p>(NOT VALID FOR COURT OF LAW)</p>
      </footer>
    </div> --}}
  </div>
</body>
</html>
