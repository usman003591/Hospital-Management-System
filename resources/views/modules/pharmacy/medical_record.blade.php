@php $page='patient_medicines'; @endphp
@extends('layouts.master',['activeMenu' => 'pharmacy_management', 'activeSubMenu' => 'patient_medicines',
'activeThirdMenu' => 'patient_medicines'])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <!--begin::Page title-->
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <!--begin::Title-->
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Patient Medicines Record</h1>
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

                <li class="breadcrumb-item text-muted">
                    <a href="" class="text-muted text-hover-primary">Pharmacy</a>
                </li>

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <!--end::Item-->
                <!--begin::Item-->
                <a href="{{route('patient_medication_record.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary"> Patient Medicines</li>
                </a>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
            <!--begin::Filter menu-->
            {{-- <div class="m-0" data-select2-id="select2-data-121-45f5">
                <!--begin::Menu toggle-->
                <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Filter</a>
                <!--end::Menu toggle-->
                <!--begin::Menu 1-->
                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                    id="kt_menu_6606384d61246" style="" data-select2-id="select2-data-kt_menu_6606384d61246">
                    <!--begin::Header-->
                    <div class="py-5 px-7">
                        <div class="text-gray-900 fs-5 fw-bold">Filter Options</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Menu separator-->
                    <div class="border-gray-200 separator"></div>
                    <!--end::Menu separator-->
                    <!--begin::Form-->
                    <div class="py-5 px-7" data-select2-id="select2-data-120-s3mi">
                        <!--begin::Input group-->
                        <div class="mb-10" data-select2-id="select2-data-119-md49">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Status:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div data-select2-id="select2-data-118-i4go">
                                <select class="form-select form-select-solid select2-hidden-accessible" multiple=""
                                    data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_6606384d61246" data-allow-clear="true"
                                    data-select2-id="select2-data-7-19z1" tabindex="-1" aria-hidden="true"
                                    data-kt-initialized="1">
                                    <option data-select2-id="select2-data-125-g7ns"></option>
                                    <option value="1" data-select2-id="select2-data-126-g09z">Approved</option>
                                    <option value="2" data-select2-id="select2-data-127-23ft">Pending</option>
                                    <option value="2" data-select2-id="select2-data-128-ql51">In Process</option>
                                    <option value="2" data-select2-id="select2-data-129-fwv5">Rejected</option>
                                </select><span
                                    class="select2 select2-container select2-container--bootstrap5 select2-container--below"
                                    dir="ltr" data-select2-id="select2-data-8-x24w" style="width: 100%;"><span
                                        class="selection"><span
                                            class="select2-selection select2-selection--multiple form-select form-select-solid"
                                            role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1"
                                            aria-disabled="false">
                                            <ul class="select2-selection__rendered" id="select2-fkxw-container"></ul>
                                            <span class="select2-search select2-search--inline"><textarea
                                                    class="select2-search__field" type="search" tabindex="0"
                                                    autocorrect="off" autocapitalize="none" spellcheck="false"
                                                    role="searchbox" aria-autocomplete="list" autocomplete="off"
                                                    aria-label="Search" aria-describedby="select2-fkxw-container"
                                                    placeholder="Select option" style="width: 100%;"></textarea></span>
                                        </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Member Type:</label>
                            <!--end::Label-->
                            <!--begin::Options-->
                            <div class="d-flex">
                                <!--begin::Options-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1">
                                    <span class="form-check-label">Author</span>
                                </label>
                                <!--end::Options-->
                                <!--begin::Options-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="2" checked="checked">
                                    <span class="form-check-label">Customer</span>
                                </label>
                                <!--end::Options-->
                            </div>
                            <!--end::Options-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Notifications:</label>
                            <!--end::Label-->
                            <!--begin::Switch-->
                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="" name="notifications"
                                    checked="checked">
                                <label class="form-check-label">Enabled</label>
                            </div>
                            <!--end::Switch-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true">Reset</button>
                            <button type="submit" class="btn btn-sm btn-primary"
                                data-kt-menu-dismiss="true">Apply</button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Menu 1-->
            </div> --}}
            <!--end::Filter menu-->
            <!--begin::Secondary button-->
            <!--end::Secondary button-->
            <!--begin::Primary button-->
            <!--end::Primary button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('include.messages')
        </div>
    </div>
</div>

<div class="col-xl-12">
    <!--begin::List Widget 8-->
    <div class="mb-5 card card-xl-stretch mb-xl-8">
        <!--begin::Body-->

        <div class="card-body">
            <h3 class="mb-2"><span class="font-size-lg text-dark font-weight-bold">Search Patient Record</span></h3>
            <div class="mb-5">
                <div class="form-group row">
                    <div class="mb-5 col-lg-12">
                        <div>{{ getActiveHospitalName($preferences['preference']['hospital_id']) }} </div>
                        <input type="hidden" name="hospital_id" value="{{ $preferences['preference']['hospital_id'] }}">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <span class="bg-transparent input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" id="search_patient_medicines"
                                placeholder="Search with MR Number, Patient Name, or Clinical Diagnosis ID">
                        </div>
                        <div class="input-group-append">
                        </div>

                        @error('search')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-lg-3">
                    </div>
                </div>
            </div>
            <br>
        </div>

        <!--end::Body-->
    </div>
</div>

<div id="result_patient_medical_record_data">
    @include('modules.pharmacy.include.list_partial')
</div>

@include('modules.pharmacy.modals.detail')
@endsection
@section('scripts')
{{-- <script src="{{getAssetsURLs('js/custom/search_partial.js')}}"></script> --}}
<script src="{{getAssetsURLs('js/custom/helper_scripts.js')}}"></script>
<script>
    $(document).ready(function(){

    var SITEURL = '{{URL::to('')}}';
    doLiveSearch();

$(document).on('click', '.medicine-details-instance', function(){
    $('#kt_modal_medicine_record_details').modal('show');
        id = $(this).data('id');
        $.ajax({
        type : 'get',
        url : SITEURL + '/patient-medicines-detail/' + id,
            success:function(res){
                    $('#medicines_listing_div').html(res.data);
            },
            error: function (data) {
                    console.log('Error:', data.responseText);
                    var error = data.responseText
                    Swal.fire("Error!", error, "error");
            }
        });
        return false;
});

$(document).on('click', '#kt_modal_delete_{{$page}}_close', function(){
    $('#kt_modal_delete_{{$page}}').modal('hide');
    return false;
});

$(document).on('click', '#kt_modal_delete_{{$page}}_cancel', function(){
    $('#kt_modal_delete_{{$page}}').modal('hide');
    return false;
});

function doLiveSearch() {
        var searchValue = $('#search_patient_medicines').val();

        $.ajax({
            type: 'get',
            url: '{{ route('patient_medication_record.index') }}',
            data: {
                'q': searchValue,
                'type': 'live_search'
            },
            success: function(res){
                $('#result_patient_medical_record_data').html(res.data);
                KTMenu.createInstances();
            },
            error: function(data) {
                console.log('Error:', data.responseText);
                var error = data.responseText;
                Swal.fire("Error!", error, "error");
            }
        });
    }

    $('#search_patient_medicines').on('keyup', function(){
        doLiveSearch();
    });


$(document).on('click', '#kt_modal_delete_{{$page}}_submit', function(event){
    event.preventDefault();
    getURL = $(this).attr('href');
    $.ajax({
        url: getURL,
        method: 'delete',
        success: function(result){
            $('#kt_modal_delete_{{$page}}').modal('hide');
            show_message('success', result.message);
            setTimeout(function() {
                window.location.href = SITEURL+"/{{$page}}";
            }, 3000);

        },
    });
});


});

</script>
@endsection
