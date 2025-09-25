@extends('layouts.master', ['activeMenu' => 'clinical_diagnosis_management', 'activeSubMenu' => $page, 'activeThirdMenu'
=> $page])
@section('styles')
<link href="{{ URL::to('src/sass/components/_variables.scss') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
<style>
/* dropdown list items */
.selectMedicine + .select2-container .select2-results__option.is-in-house {
    background-color:#d4edda !important;
    color:#155724 !important;
}

/* tag / single-select text once chosen */
.selectMedicine + .select2-container
    .select2-selection__choice.is-in-house,
.selectMedicine + .select2-container
    .select2-selection__rendered.is-in-house {
    background-color:#d4edda !important;
    color:#155724 !important;
}
</style>
@endsection
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
                Detail </h1>
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
                    <li class="breadcrumb-item text-muted text-hover-primary">{{ $sc }}</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a>
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Vitals</li>
                </a>

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
            {{-- @if (checkPersonPermission('create_service_categories_11')) --}}
            {{-- <a href="{{route($page.'.create')}}">
                <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_add_permission">
                    <i class="ki-duotone ki-plus-square fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>Add {{$sc}}</button></a> --}}
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
            @include('modules.clinical_diagnosis.detail.modern.navbar')
            @include('include.messages')
            <div class="mb-5 card card-xl-stretch mb-xl-8">

                <div class="py-5">
                    <div class="p-10 rorder-0 ounded b d-flex flex-column flex-md-row">
                        <ul class="flex-row mb-3 border-0 nav nav-tabs nav-pills flex-md-column me-5 mb-md-0 fs-6 min-w-lg-200px"
                            role="tablist">

                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link active w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_5" id="kt_vtab_pane_5_link" aria-selected="false" tabindex="-1"
                                    role="tab">
                                    <i class="ki-duotone ki-thermometer fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">Vitals</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li>
                            {{-- <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_13" id="kt_vtab_pane_13_link" aria-selected="false"
                                    tabindex="-1" role="tab">
                                    <i class="ki-duotone ki-printer fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">Snapshot</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li> --}}
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="kt_vtab_pane_5" role="tabpanel">
                                @include('modules.clinical_diagnosis.detail.modern.registration_vitals')
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- @include('modules.clinical_diagnosis.detail.modals.preview') --}}
@endsection

@section('scripts')
{{-- <script src="{{ getAssetsURLs('js/custom/search_partial.js') }}"></script> --}}
<script src="{{ getAssetsURLs('js/custom/select2_clinical_diagnosis.js') }}"></script>
<script src="{{ getAssetsURLs('js/custom/helper_scripts.js') }}"></script>
<script src="{{ getAssetsURLs('plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

<script>
    $(document).ready(function () {

            $(".disposal-dropdown-div").hide();

            $('.selectDisposalVal').on('change', function () {
            var disposal_type = this.value;

                if (disposal_type == 'referred_to_hospital' || disposal_type == 'referred_to_specialist') {
                    $(".disposal-dropdown-div").show();
                    $(".disposal-dropdown-div").html('');

                    $.ajax({
                        url: "{{route('fetch_disposal_data')}}",
                        type: "GET",
                        data: {
                            disposal_type: disposal_type,
                            _token: '{{csrf_token()}}'
                        },
                        dataType: 'json',
                        success: function (result) {
                        console.log(result);

                            $('.disposal-dropdown').html('<option value="">Select Disposal Value</option>');
                            $('.disposal-dropdown-div').html(result.html);

                        },
                        error: function(data){
                            console.log(data);
                        }
                    });


                } else if (disposal_type === 'admission' ) {
                    $("#disposal-dropdown-div").hide();
                } else {
                    $("#disposal-dropdown-div").hide();
                }

            });
        });

        $(document).ready(function() {

            const urlParams = new URLSearchParams(window.location.search);
            const myParam = urlParams.get('tabName');

            if (myParam == 'brief_history') {

                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_6_link');
                var $ndi = $('#kt_vtab_pane_6');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');

            }

            if (myParam == 'complaints') {

                var $nli = $('#kt_vtab_pane_4_link');
                var $ndi = $('#kt_vtab_pane_4');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }

            if (myParam == 'vitals') {

                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_5_link');
                var $ndi = $('#kt_vtab_pane_5');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');

            }

            if (myParam == 'diagnosis') {

                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_10_link');
                var $ndi = $('#kt_vtab_pane_10');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');

            }
            if (myParam == 'procedure') {

                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_14_link');
                var $ndi = $('#kt_vtab_pane_14');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');

            }

            if (myParam == 'gpe') {
                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_7_link');
                var $ndi = $('#kt_vtab_pane_7');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }

            if (myParam == 'spe') {
                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_8_link');
                var $ndi = $('#kt_vtab_pane_8');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }

            if (myParam == 'investigations') {
                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_9_link');
                var $ndi = $('#kt_vtab_pane_9');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }


            if (myParam == 'treatment') {
                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_11_link');
                var $ndi = $('#kt_vtab_pane_11');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }


            if (myParam == 'disposal') {
                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_12_link');
                var $ndi = $('#kt_vtab_pane_12');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }

            // if (myParam == 'snapshot') {
            //     var $li = $('#kt_vtab_pane_4_link');
            //     var $di = $('#kt_vtab_pane_4');

            //     $li.removeClass('active');
            //     $di.removeClass('active');
            //     $di.removeClass('show');

            //     var $nli = $('#kt_vtab_pane_13_link');
            //     var $ndi = $('#kt_vtab_pane_13');

            //     $nli.addClass('active');
            //     $ndi.addClass('active');
            //     $ndi.addClass('show');
            // }


        });
</script>
<script>
    var KTLayoutStretchedCard = function() {
            // Private properties
            var _element;

            // Private functions
            var _init = function() {
                var scroll = KTUtil.find(_element, '.card-scroll');
                var cardBody = KTUtil.find(_element, '.card-body');
                var cardHeader = KTUtil.find(_element, '.card-header');

                var height = KTLayoutContent.getHeight();

                height = height - parseInt(KTUtil.actualHeight(cardHeader));

                height = height - parseInt(KTUtil.css(_element, 'marginTop')) - parseInt(KTUtil.css(_element,
                    'marginBottom'));
                height = height - parseInt(KTUtil.css(_element, 'paddingTop')) - parseInt(KTUtil.css(_element,
                    'paddingBottom'));

                height = height - parseInt(KTUtil.css(cardBody, 'paddingTop')) - parseInt(KTUtil.css(cardBody,
                    'paddingBottom'));
                height = height - parseInt(KTUtil.css(cardBody, 'marginTop')) - parseInt(KTUtil.css(cardBody,
                    'marginBottom'));

                height = height - 3;

                KTUtil.css(scroll, 'height', height + 'px');
            }

            // Public methods
            return {
                init: function(id) {
                    _element = KTUtil.getById(id);

                    if (!_element) {
                        return;
                    }

                    // Initialize
                    _init();

                    // Re-calculate on window resize
                    KTUtil.addResizeHandler(function() {
                        _init();
                    });
                },

                update: function() {
                    _init();
                }
            };
        }();

        // Webpack support
        if (typeof module !== 'undefined') {
            module.exports = KTLayoutStretchedCard;
        }
</script>
<script>
    $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Enter Brief History',
                tabsize: 2,
                height: 100
            });
        });


        $(document).ready(function() {
            $(document).on('change', '.selectSymptom', function() {
                var symptomId = $(this).val();
                var $sub_symptom_dropdown = $(this).closest('.repeater-row').find('.selectSubSymptom');
                $sub_symptom_dropdown.empty().append('<option value="">Select a Sub Symptom</option>')
                    .select2();
                if (symptomId) {
                    $.ajax({
                        url: '/api/fetch-complaints/' + symptomId,
                        type: 'GET',
                        success: function(sub_symptoms) {
                            console.log(sub_symptoms);
                            $.each(sub_symptoms, function(index, symptom) {
                                $sub_symptom_dropdown.append('<option value="' + symptom
                                        .id + '">' + symptom.name + '</option>')
                                    .select2();
                            });
                        },
                        error: function() {
                           alert('Unable to fetch sub symptoms');
                       }
                    });
                }
            });
        });

        $('#kt_docs_repeater_advanced_complaints').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {

                $(this).slideDown();
                $(this).find('[data-kt-repeater="symptom_select_2"]').select2({
                    placeholder: "Select a Symptom"
                });
                $(this).find('[data-kt-repeater="sub_symptom_select_2"]').select2({
                    placeholder: "Select a Sub Symptom"
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="symptom_select_2"]').select2({
                    placeholder: "Select a Symptom"
                });
                $('[data-kt-repeater="sub_symptom_select_2"]').select2({
                    placeholder: "Select a Symptom"
                });
            }
        });
</script>
<script>
    $(document).ready(function() {
            $(document).on('change', '.selectGPE', function() {
                var id = $(this).val();
                var $sub_dropdown = $(this).closest('.repeater-row-gpe').find('.selectSubGPE');
                $sub_dropdown.empty().append('<option value="">Select Addtional GPEs</option>').select2();
                if (id) {
                    $.ajax({
                        url: '/api/fetch-general-physical-examinations/' + id,
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                            $.each(data, function(index, item) {
                                $sub_dropdown.append('<option value="' + item.id +
                                    '">' + item.name + '</option>').select2();
                            });
                        },
                       error: function(data) {
                           console.log(data);
                           alert('Unable to fetch general physical examinations');
                       }
                    });
                }
            });
        });

        $('#kt_docs_repeater_advanced_gpe').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {

                $(this).slideDown();
                $(this).find('[data-kt-repeater="gpe_select_2"]').select2({
                    placeholder: "Select GPE"
                });
                $(this).find('[data-kt-repeater="sub_gpe_select_2"]').select2({
                    placeholder: "Select Addtional GPE"
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="gpe_select_2"]').select2({
                    placeholder: "Select GPE"
                });
                $('[data-kt-repeater="sub_gpe_select_2"]').select2({
                    placeholder: "Select Addtional GPE"
                });
            }
        });
</script>
<script>
    $(document).ready(function() {
            $(document).on('change', '.selectSPE', function() {
                var id = $(this).val();
                var $sub_dropdown = $(this).closest('.repeater-row-spes').find('.selectSubSPE');
                $sub_dropdown.empty().append('<option value="">Select Addtional SPEs </option>').select2();
                if (id) {
                    $.ajax({
                        url: '/api/fetch-systematic-physical-examinations/' + id,
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                            $.each(data, function(index, item) {
                                $sub_dropdown.append('<option value="' + item.id +
                                    '">' + item.name + '</option>').select2();
                            });
                        },
                       error: function(data) {
                           console.log(data);
                           alert('Unable to fetch sub symptoms');
                       }
                    });
                }
            });
        });

        $('#kt_docs_repeater_advanced_spe').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {

                $(this).slideDown();
                $(this).find('[data-kt-repeater="spe_select_2"]').select2({
                    placeholder: "Select SPE"
                });
                $(this).find('[data-kt-repeater="sub_spe_select_2"]').select2({
                    placeholder: "Select Addtional SPE"
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="spe_select_2"]').select2({
                    placeholder: "Select SPE"
                });
                $('[data-kt-repeater="sub_spe_select_2"]').select2({
                    placeholder: "Select Addtional SPE"
                });
            }
        });
</script>

<script>
    $(document).ready(function() {
            $('.selectDiagnosis').select2({
                ajax: {
                    url: "{{ route('search.diagnosis') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // Search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(dia => ({
                                id: dia.id,
                                text: dia.display_name
                            }))
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2 // Minimum characters to trigger search
            });
        });

        $('#kt_docs_repeater_advanced_diagnosis').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {

                $(this).slideDown();
                $(this).find('[data-kt-repeater="diagnosis_select_2"]').select2({
                    placeholder: "Select Diagnosis",
                    ajax: {
                        url: "{{ route('search.diagnosis') }}",
                        dataType: 'json',
                        delay: 50,
                        data: function (params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function (data) {
                            return {
                            results: data.map(dia => ({
                                id: dia.id,
                                text: dia.display_name
                            }))
                        };
                        },
                        cache: true
                    },
                    minimumInputLength: 1
                });

            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="diagnosis_select_2"]').select2({
                    placeholder: "Select Diagnosis"
                });

            }
        });
</script>
<script>
    $(document).ready(function() {
            $(document).on('change', '.selectProcedure', function() {
                var id = $(this).val();
                // var $sub_dropdown = $(this).closest('.repeater-row-procedure').find('.selectSubProcedure');
                // $sub_dropdown.empty().append('<option value="">Select Addtional Procedure </option>')
                //     .select2();

                if (id) {
                    $.ajax({
                        url: '/api/fetch-procedure/' + id,
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                            $.each(data, function(index, item) {
                                $sub_dropdown.append('<option value="' + item.id +
                                    '">' + item.name + '</option>').select2();
                            });
                        },
                        // error: function(data) {
                        //     console.log(data);
                        //     alert('Unable to fetch sub Procedure');
                        // }
                    });
                }
            });
        });

        $('#kt_docs_repeater_advanced_procedure').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {

                $(this).slideDown();
                $(this).find('[data-kt-repeater="procedure_select_2"]').select2({
                    placeholder: "Select procedure"
                });
                // $(this).find('[data-kt-repeater="sub_procedure_select_2"]').select2({
                //     placeholder: "Select Addtional procedure"
                // });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="procedure_select_2"]').select2({
                    placeholder: "Select procedure"
                });
                // $('[data-kt-repeater="sub_procedure_select_2"]').select2({
                //     placeholder: "Select Addtional procedure"
                // });
            }
        });
</script>

<script>
    $('#kt_docs_repeater_advanced_radiology').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                $(this).find('[data-kt-repeater="radiology_select_2"]').select2({
                    placeholder: "Select Radiology test"
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="radiology_select_2"]').select2({
                    placeholder: "Select Radiology test"
                });
            }
        });

        $('#kt_docs_repeater_advanced_pathology').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                $(this).find('[data-kt-repeater="pathology_select_2"]').select2({
                    placeholder: "Select Pathology test"
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="pathology_select_2"]').select2({
                    placeholder: "Select Pathology test"
                });
            }
        });


        $('#kt_docs_repeater_advanced_rehablitation').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                $(this).find('[data-kt-repeater="rehablitation_select_2"]').select2({
                    placeholder: "Select Rehablitation test"
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="rehablitation_select_2"]').select2({
                    placeholder: "Select Rehablitation test"
                });
            }
        });


        function styleOption(state) {
            if (!state.id) return state.text;   // placeholder

            const isInHouse = $(state.element).data('is-in-house') == 1;
            const $node     = $('<span>', { text: state.text });

            if (isInHouse) $node.addClass('is-in-house');
            return $node;
        }

        $('#kt_docs_repeater_advanced_treatment').repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                $(this).find('[data-kt-repeater="medicine_select_2"]').select2({
                    placeholder: "Select Medicine",
                    // templateResult: styleOption,
                    // templateSelection: styleOption
                });

                $(this).find('[data-kt-repeater="dosage_select_2"]').select2({
                    placeholder: "Select Dosage"
                });

                $(this).find('[data-kt-repeater="duration_select_2"]').select2({
                    placeholder: "Select Duration"
                });

                $(this).find('[data-kt-repeater="interval_select_2"]').select2({
                    placeholder: "Select Dosage Interval"
                });

                $(this).find('[data-kt-repeater="form_select_2"]').select2({
                    placeholder: "Select medicine form"
                });
                $(this).find('[data-kt-repeater="route_select_2"]').select2({
                    placeholder: "Select medicine route"
                });

                $(this).find('[data-kt-repeater="frequency_select_2"]').select2({
                    placeholder: "Select medicine Frequency"
                });

            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="medicine_select_2"]').select2({
                    placeholder: "Select Medicine",
                    // templateResult: styleOption,
                    // templateSelection: styleOption
                });

                $('[data-kt-repeater="dosage_select_2"]').select2({
                    placeholder: "Select Dosage"
                });

                $('[data-kt-repeater="duration_select_2"]').select2({
                    placeholder: "Select Duration"
                });

                $('[data-kt-repeater="interval_select_2"]').select2({
                    placeholder: "Select Dosage Interval"
                });

                $('[data-kt-repeater="form_select_2"]').select2({
                    placeholder: "Select medicine form"
                });
                $('[data-kt-repeater="route_select_2"]').select2({
                    placeholder: "Select medicine route"
                });

                $('[data-kt-repeater="frequency_select_2"]').select2({
                    placeholder: "Select medicine Frequency"
                });

            }
        });
</script>

<script>
    $(document).ready(function() {

            // document.querySelector('#kt_check_indeterminate_1').indeterminate = true;

            $(document).on('click', '.delete-{{ $page }}', function() {
                $('#kt_modal_delete_{{ $page }}_submit').attr('href', $(this).attr('href'));
                $('#kt_modal_delete_{{ $page }}').modal('show');
                return false;
            });

            $(document).on('click', '#kt_modal_delete_{{ $page }}_close', function() {
                $('#kt_modal_delete_{{ $page }}').modal('hide');
                return false;
            });

            $(document).on('click', '#kt_modal_delete_{{ $page }}_cancel', function() {
                $('#kt_modal_delete_{{ $page }}').modal('hide');
                return false;
            });


            $(document).on('click', '#kt_modal_delete_{{ $page }}_submit', function(event) {
                event.preventDefault();
                getURL = $(this).attr('href');
                $.ajax({
                    url: getURL,
                    method: 'delete',
                    success: function(result) {
                        $('#kt_modal_delete_{{ $page }}').modal('hide');
                        show_message('success', result.message);
                        setTimeout(function() {
                            window.location.href = SITEURL + "/{{ $page }}";
                        }, 3000);

                    },
                });
            });


        });
</script>

<style>
    .select2-results .select2-disabled,
    .select2-results__option[aria-disabled=true] {
        display: none;
    }
</style>
<script>
    // Get the saved date from the input
    const savedDateValue = document.getElementById('disposalDate').value;

    // Function to parse 'dd/MM/yyyy hh:mm A' into a JS Date object
    function parseSavedDate(dateStr) {
    if (!dateStr) return null;

    // Example: "27/06/2025 03:30 PM"
    const parts = dateStr.split(/[\s:]+/); // ['27/06/2025', '03', '30', 'PM']
    if (parts.length < 4) return null;

    const [datePart, hourStr, minuteStr, meridian] = parts;
    const [day, month, year] = datePart.split('/');

    let hour = parseInt(hourStr);
    const minute = parseInt(minuteStr);

    if (!meridian) return null;

    // Handle AM/PM
    const ampm = meridian.toUpperCase();
    if (ampm === 'PM' && hour < 12) hour += 12;
    if (ampm === 'AM' && hour === 12) hour = 0;

    return new Date(year, month - 1, day, hour, minute);
}

    // Initialize AirDatepicker with defaultDate from input
    new AirDatepicker('#disposalDate', {
        dateFormat: 'dd/MM/yyyy',
        timepicker: true,
        autoClose: true,
        minDate: new Date(1900, 0, 1),
        maxDate: new Date(2200, 0, 1),
        selectedDates: [parseSavedDate(savedDateValue)],
        locale: {
            days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            today: 'Today',
            clear: 'Clear',
            timeFormat: 'hh:mm AA',
            firstDay: 0
        }
    });
</script>


@endsection
