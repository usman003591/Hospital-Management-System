@extends('layouts.master', ['activeMenu' => 'clinical_diagnosis_management', 'activeSubMenu' => 'clinical_diagnosis',
'activeThirdMenu'
=> 'clinical_diagnosis'])
@section('styles')
@endsection
@php
$page = "clinical_diagnosis";
@endphp
@section('breadcrumbs')
@include('include.global_search')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <!--begin::Page title-->
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <!--begin::Title-->
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Preview </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <a href="{{ route('clinical_diagnosis.index') }}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary"> Clinical Diagnosis</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{ route('clinical_diagnosis.detail_form', $obj->id) }}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Detail</li>
                </a>

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="#">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Preview</li>
                </a>

            </ul>
            <!--end::Breadcrumb-->
        </div>
        <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
        </div>
    </div>
    <!--end::Toolbar container-->
</div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-5 card mb-xxl-8">
                <div class="pb-0 card-body pt-9">
                    <!--begin::Details-->
                    <div class="flex-wrap d-flex flex-sm-nowrap">
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="flex-wrap mb-2 d-flex justify-content-between align-items-start">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="mb-2 d-flex align-items-center">
                                        <a href="#"
                                            class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">@isset($patient->name_of_patient)
                                            {{$patient->name_of_patient}}
                                            @endisset</a>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Info-->
                                    <div class="flex-wrap mb-4 d-flex fw-semibold fs-6 pe-2">
                                        @isset($patient->patient_category)
                                        <a href="#"
                                            class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                            <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            {{titleFilter($patient->patient_category)}}
                                        </a>
                                        @endisset
                                        @isset($patient->address)
                                        <a href="#"
                                            class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                            <i class="ki-duotone ki-geolocation fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            {{ucfirst($patient->address)}}
                                        </a>
                                        @endisset
                                        @isset($patient->email)
                                        <a href="#"
                                            class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary">
                                            <i class="ki-duotone ki-sms fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            {{$patient->email}}
                                        </a>
                                        @endisset
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->
                                <!--begin::Actions-->
                                <div class="my-4 d-flex">

                                    @if(checkPersonPermission('history_all_49'))
                                    <button type="button" class="btn btn-sm btn-info me-3 history-details"
                                        data-bs-toggle="modal" data-id="{{$obj->id}}" data-bs-target="#historyModal">
                                        <i class="text-white ki-outline ki-information-3"></i>
                                        Patient History
                                    </button>
                                    @endif


                                    @if(checkPersonPermission('snapshot_all_49'))
                                    <button type="button" class="btn btn-sm btn-dark me-3 snapshot-details"
                                        data-bs-toggle="modal" data-id="{{$obj->id}}" data-bs-target="#snapshotModal">
                                        <i class="text-white ki-outline ki-printer"></i>
                                        Snapshot
                                    </button>
                                    @endif

                                    @if(checkPersonPermission('detail_all_49'))
                                    <a class="btn btn-sm btn-success me-3" id="previewButton"
                                        href="{{ route('clinical_diagnosis.detail_form', $obj->id) }}"><i
                                            class="text-white ki-outline ki-syringe"></i>Go to Clinical Diagnosis</a>
                                    @endif

                                    @php
                                    $doctorPanelValue = checkDoctorPanelVal();
                                    @endphp
                                    @if ($doctorPanelValue)
                                    <a class="btn btn-sm btn-primary me-3" id="backButtonButton"
                                        href="{{ route('clinical_diagnosis.myDailyListingRecord') }}"> <i
                                            class="text-white ki-outline ki-to-left"></i>Back</a>
                                    @else
                                    <a class="btn btn-sm btn-primary me-3" id="backButtonButton"
                                        href="{{ route('clinical_diagnosis.index') }}"> <i
                                            class="text-white ki-outline ki-to-left"></i>Back</a>
                                    @endif



                                </div>
                                <!--end::Actions-->
                                @include('modules.clinical_diagnosis.detail.modals.history')
                                @include('modules.clinical_diagnosis.detail.modals.snapshot')
                            </div>
                            <!--end::Title-->
                            <!--begin::Stats-->
                            <div class="flex-wrap d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <!--begin::Stats-->
                                    <div class="flex-wrap d-flex">

                                        <!--begin::Stat-->
                                        @isset($patient->patient_mr_number)
                                        <div
                                            class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                    data-kt-countup-value="80" data-kt-initialized="1">
                                                    {{$patient->patient_mr_number}}
                                                </div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 fw-semibold fs-6">MR Number</div>
                                            <!--end::Label-->
                                        </div>
                                        @endisset
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        @isset($patient->cnic_number)
                                        <div
                                            class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                    data-kt-countup-value="60" data-kt-countup-prefix="%"
                                                    data-kt-initialized="1">
                                                    {{$patient->cnic_number}}
                                                </div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 fw-semibold fs-6">CNIC</div>
                                            <!--end::Label-->
                                        </div>
                                        @endisset
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        @isset($patient->blood_group)
                                        <div
                                            class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                    data-kt-countup-value="4500" data-kt-countup-prefix="$"
                                                    data-kt-initialized="1">
                                                    {{$patient->blood_group}}
                                                </div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 fw-semibold fs-6">Blood Group</div>
                                            <!--end::Label-->
                                        </div>
                                        @endisset
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        @isset($patient->age)
                                        <div
                                            class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                    data-kt-countup-value="60" data-kt-countup-prefix="%"
                                                    data-kt-initialized="1">
                                                    {{$patient->age}} years
                                                </div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 fw-semibold fs-6">Age</div>
                                            <!--end::Label-->
                                        </div>
                                        @endisset
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        @isset($patient->gender)
                                        <div
                                            class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                    data-kt-countup-value="60" data-kt-countup-prefix="%"
                                                    data-kt-initialized="1">
                                                    {{ucfirst($patient->gender)}}
                                                </div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 fw-semibold fs-6">Gender</div>
                                            <!--end::Label-->
                                        </div>
                                        @endisset
                                        <!--end::Stat-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <br>
                    <p class="text-muted text-end">Date: {{ $obj->created_at->format('d/m/Y h:i A') }}</p>

                </div>
            </div>

            <div class="table-responsive">
                        <table class="table mb-10 border table-hover table-rounded table-striped gy-5 gs-5">
                            <thead>
                                <tr
                                    class="text-center text-gray-800 border-gray-200 fw-bold fs-6 border-bottom-2 bg-primary-subtle">
                                    <th colspan="{{ count($vitals) }}">Vitals</th>
                                </tr>
                                <tr class="text-gray-800 border-gray-200 fw-bold fs-6 border-bottom-2">
                                    @isset($vitals)
                                    @foreach ($vitals as $item)
                                    <th>{{$item->name}}/{{$item->unit}} </th>
                                    @endforeach
                                    @endisset
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($updatedVitalData as $updateitem)
                                    @isset($updateitem->value)
                                    <td>
                                        {{$updateitem->value}}
                                    </td>
                                    @else
                                    <td class="text-danger">
                                        <small>N/A</small>
                                    </td>
                                    @endisset
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>

            <div class="mb-5 card mb-xxl-8">
                <div class="pb-0 card-body pt-9">
                    <div class="mb-10 card card-bordered">
                        <div class="py-4 card-header justify-content-center bg-primary-subtle min-h-50px">
                            <h3 class="text-gray-800 card-title fs-6 fw-bold">Brief History</h3>
                        </div>
                        <div class="card-body">
                            @isset($cdBriefHistoryData)
                            <span class="bullet bg-primary me-5"></span>{{ ucfirst($cdBriefHistoryData->value) }}
                            @else

                            <small class="d-flex justify-content-center text-danger">
                                No brief history data found
                            </small>
                            @endisset

                        </div>
                    </div>

                    <div class="mb-10 card card-bordered">
                        <div class="py-4 card-header justify-content-center bg-primary-subtle min-h-50px">
                            <h3 class="text-gray-800 card-title fs-6 fw-bold">Diagnosis</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                @forelse ($cdDiagnosisData as $diagnosis_data)
                                <li class="py-2 d-flex align-items-center">
                                    <span class="bullet bg-primary me-5"></span>{{
                                    ucfirst($diagnosis_data->diagnosis_name) }}
                                </li>
                                @empty
                                <small class="text-center text-danger">
                                    No diagnosis data found
                                </small>
                                @endforelse
                            </div>

                        </div>
                    </div>

                    <div class="mb-10 card card-bordered">
                        <div class="py-4 card-header justify-content-center bg-primary-subtle min-h-50px">
                            <h3 class="text-gray-800 card-title fs-6 fw-bold">Procedures</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                @forelse ($cdProcedureData as $procedure)
                                <li class="py-2 d-flex align-items-center">
                                    <span class="bullet bg-primary me-5"></span>{{ ucfirst($procedure->procedure_name)
                                    }}
                                </li>
                                @empty
                                <small class="text-center text-danger">
                                    No procedure data found
                                </small>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-10 border table-hover table-rounded table-striped gy-5 gs-5">
                            <thead>
                                <tr
                                    class="text-center text-gray-800 border-gray-200 fw-bold fs-6 border-bottom bg-primary-subtle">
                                    <th colspan="2">Complaints</th>
                                </tr>
                                <tr class="text-gray-800 border-gray-200 fw-bold fs-6 border-bottom">
                                    <th style="width: 55%">Symptoms</th>
                                    {{-- <th>Additional Symptoms</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cdComplaintData as $complaint)
                                <tr>
                                    <td>
                                        {{ $complaint->complaint_name }}
                                        @if(!empty($complaint->child_data) && collect($complaint->child_data)->count() >
                                        0)
                                        ( {{ implode(',
                                        ',collect($complaint->child_data)->pluck('complaint_name')->toArray()) }} )
                                        @endif
                                    </td>
                                    {{-- <td>
                                        @foreach ($complaint->child_data as $cd)
                                        {{$cd->complaint_name}},
                                        @endforeach
                                    </td> --}}
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="2"><small>No Complaints Data</small>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-10 border table-rounded table-striped gy-5 gs-5">
                            <thead>
                                <tr
                                    class="text-center text-gray-800 border-gray-200 fw-bold fs-6 border-bottom bg-primary-subtle">
                                    <th colspan="2">General Physical Examinations</th>
                                </tr>
                                <tr class="text-gray-800 border-gray-200 fw-bold fs-6 border-bottom">
                                    <th style="width: 55%">General Physical Examinations</th>
                                    {{-- <th>Additional GPEs</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cdGPEData as $gpe)
                                <tr>
                                    <td>
                                        {{ $gpe->gpe_name }}
                                        @if (!empty($gpe->child_data) && collect($gpe->child_data)->count() > 0)
                                        ( {{ implode(', ', collect($gpe->child_data)->pluck('gpe_name')->toArray()) }} )
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="2"><small>No General Physical
                                            Examinations Data</small></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-10 border table-rounded table-striped gy-5 gs-5">
                            <thead>
                                <tr
                                    class="text-center text-gray-800 border-gray-200 fw-bold fs-6 border-bottom bg-primary-subtle">
                                    <th colspan="2">Systematic Physical Examinations</th>
                                </tr>
                                <tr class="text-gray-800 border-gray-200 fw-bold fs-6 border-bottom">
                                    <th style="width: 55%">Systematic Physical Examinations</th>
                                    {{-- <th>Additional SPEs</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cdSPEData as $spe)
                                <tr>
                                    <td>
                                        {{ $spe->spe_name }}
                                        @if (!empty($spe->child_data) && collect($spe->child_data)->count() > 0)
                                        ( {{ implode(', ', collect($spe->child_data)->pluck('spe_name')->toArray()) }} )
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="2"><small>No Systematic Physical
                                            Examinations Data</small></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-10 border table-rounded" style="width: 100%">
                            <thead>
                                <tr
                                    class="text-center text-gray-800 border-gray-200 fw-bold fs-6 border-bottom-2 bg-primary-subtle">
                                    <th class="py-5" colspan="3" scope="col">
                                        Investigations
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-0" style="width: 35%">
                                        <table class="table mb-0 table-hover table-striped gs-5 gy-5"
                                            style="border-collapse: collapse;">
                                            <thead>
                                                <tr class="text-gray-800 fw-bold fs-6">
                                                    <th scope="col">Pathology</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($pathologyData as $investigation)
                                                <tr>
                                                    <td>{{$investigation->investigation_name}}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-danger"><small>N/A</small>&nbsp;</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="p-0" style="width: 33.33%">
                                        <table class="table mb-0 table-hover table-striped gs-5 gy-5"
                                            style="border-collapse: collapse;">
                                            <thead>
                                                <tr class="text-gray-800 fw-bold fs-6">
                                                    <th class="px-5" scope="col">Radiology</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($radiologyData as $investigation)
                                                <tr>
                                                    <td>{{$investigation->investigation_name}}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-danger"><small>N/A</small>&nbsp;</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </td>

                                    <td class="p-0" style="width: 33.33%">
                                        <table class="table mb-0 table-hover table-striped gs-5 gy-5"
                                            style="border-collapse: collapse;">
                                            <thead>
                                                <tr class="text-gray-800 fw-bold fs-6">
                                                    <th scope="col">Rehabilitation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($rehablitationData as $investigation)
                                                <tr>
                                                    <td>{{$investigation->investigation_name}}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-danger"><small>N/A</small>&nbsp;</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>



                    <div class="table-responsive">
                        <table class="table mb-10 border table-hover table-rounded table-striped gy-5 gs-5">
                            <thead>
                                <tr
                                    class="text-center text-gray-800 border-gray-200 fw-bold fs-6 border-bottom-2 bg-primary-subtle">
                                    <th colspan="6">Medication</th>
                                </tr>
                                <tr class="text-gray-800 border-gray-200 fw-bold fs-6 border-bottom-2">
                                    <th style="width: 25%">Medicine</th>
                                    <th style="width: 15%">Form</th>
                                    <th style="width: 15%">Quantity</th>
                                    <th>Duration</th>
                                    <th>Frequency</th>
                                    <th>Route</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($medicationData as $td)
                                <tr>
                                    <td>{{$td->medicine_name}}</td>
                                    <td>{{$td->form_name}}</td>
                                    <td>{{$td->treatment_dosage_name}}</td>
                                    <td>{{$td->treatment_duration}}</td>
                                    <td>{{$td->treatment_dose_interval}}</td>
                                    <td>{{$td->route_name}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="6"><small>No Medication Data</small>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if(checkPersonPermission('detail_all_49'))
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                        </div>
                        <div class="col-md-3 text-end">
                            <a class="btn btn-sm btn-success me-3" id="previewButton"
                                href="{{ route('clinical_diagnosis.detail_form', $obj->id) }}"><i
                                    class="text-white ki-outline ki-syringe"></i>Go to Clinical Diagnosis</a>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                @endif

            </div>
        </div>
    </div>
</div>
</div>


@endsection
@section('scripts')
<script>
    var SITEURL = '{{URL::to('')}}';

$(document).ready( function () {
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.history-details', function () {

       var id = $(this).data('id');
        $.ajax({
        url: "{{route('fetch_patient_history',['clinical_diagnosis_id' => $obj->id] )}}",
        method: 'get',
        success: function(result){
            $('#OPDPatientHistoryListingDiv').html(result.html);
        },
        error: function (data) {
            console.log('Error:', data.responseText);
            // var error = data.responseText
            // Swal.fire("Error!", error, "error");
        }
        });

  });

});
</script>
@endsection
