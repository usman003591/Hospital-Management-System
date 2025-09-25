@php $page='lab_groups'; @endphp
@extends('layouts.master',['activeMenu' => 'pathology_management', 'activeSubMenu' => 'lab_groups', 'activeThirdMenu' =>
'lab_groups'])
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
                Lab Group Detail</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <a href="{{route('lab_groups.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{titleFilter($page)}}</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{route('lab_groups.detail',['id' => $obj->id ])}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Lab group tests</li>
                </a>

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="#">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Add Lab test data</li>
                </a>

            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

        <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
            <a href="{{route('lab_groups.lab_tests',$lab_group_id)}}" class="btn btn-sm btn-primary">Back</a> &nbsp;
        </div>


    </div>
    <!--end::Toolbar container-->
</div>
@endsection
@section('content')
@include('include.messages')
{{-- @include('modules.lab_groups.details.include.nav_partial',['tab' => 'overview']) --}}
<div class="mb-0 row g-5 gx-xl-10 mb-xl-0">

    <!--begin::Col-->
    <div class="mb-5 col-xxl-12 mb-xl-2">

            <form class="form" id="downloadInvoiceForm" action="{{ route('lab_groups.lab_tests.save_details',['id' => $lab_group_id, 'test_id' => $lab_group_test_id]) }}" method="POST"
            enctype="multipart/form-data" class="needs-validation">
            @csrf

            {{-- <input type="hidden" id="lab_group_test_id" name="lab_group_test_id" value="{{$lab_group_test_id}}" /> --}}
            <div class="table-responsive">
            <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7">
                <thead>
                    <tr class="text-gray-800 fw-semibold fs-6">
                        <th class="min-w-300px">Investigation</th>
                        <th class="min-w-350px">Result</th>
                        <th class="min-w-300px">Ref. Value</th>
                        <th class="min-w-300px">Unit</th>
                    </tr>
                </thead>
                <tbody>

                    @isset($testDetailData)
                        @if (count($testDetailData) > 0)
                            @foreach ($testDetailData as $key => $item)

                            <tr>
                                <td>{{$item->name}}</td>

                                <td>
                                <input
                                style="width: 50px"
                                type="text"
                                name="lab_group_test_data[{{$item->investigation_attached_field_id}}][value]"
                                class="form-control min-w-200px "
                                value="@isset($item->result_value){{$item->result_value}}@endisset"
                                placeholder="Enter Result" >

                                @error('lab_group_test_data.' . $item->investigation_attached_field_id . '.value')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror

                                </td>

                                <td>
                                    @if (!is_null($item->reference_notes))
                                    {{$item->reference_notes}}
                                    @else
                                    Male : {{$item->male_reference_max}} - {{$item->male_reference_min}} <br>
                                    Female : {{$item->female_reference_max}} - {{$item->female_reference_min}}
                                    @endif
                                </td>
                                <td>{{$item->unit}}</td>
                            </tr>

                            @endforeach
                        @endif
                    @endisset

                </tbody>
            </table>
            </div>

            <div style="float:right;">
            <a href="{{route('lab_groups.lab_tests',$lab_group_id)}}" class="btn btn-sm btn-secondary">Cancel</a> &nbsp;
            <button type="submit" class="btn btn-sm btn-primary me-3"
                data-kt-stepper-action="submit">
                <span class="indicator-label">Save
                    {{-- <i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i> --}}
                </span>
                <span class="indicator-progress">Please wait...
                    <span
                        class="align-middle spinner-border spinner-border-sm ms-2"></span></span>
            </button>
            </div>

            </form>

    </div>
    <!--end::Col-->

</div>
@endsection
@section('scripts')
<script>
// $("#kt_datatable_both_scrolls").DataTable({
//     "scrollY": 300,
//     "scrollX": true,
//     "paging": false,
//     "resetPaging": false,
//     "lengthChange": false,
// });
</script>
@endsection
