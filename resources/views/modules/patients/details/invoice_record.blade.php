@php $page='patients'; @endphp
@extends('layouts.master',['activeMenu' => 'patients_management', 'activeSubMenu' => 'patients', 'activeThirdMenu' =>
'patients'])
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
                {{titleFilter($page)}} List</h1>
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
                <a href="{{route('patients.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{titleFilter($page)}}</li>
                </a>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{route($page.'.detail_page', ['id' => $patient->id])}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Details</li>
                </a>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">

        </div>


        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>
@endsection

@section('content')
@include('include.messages')
@include('modules.patients.details.include.nav_partial',['tab' => 'invoice_record'])
<!--begin::Card-->
<div class="card card-flush">

    <!--begin::Card body-->
    <div class="pt-10 card-body">

        <div class="mb-5 form-group row bg-search">
            <div class="col-4">
                <div class="input-group">
                    <span class="bg-white input-group-text border-start-0 border-end-0 border-top-0 rounded-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="q" name="q" class="form-control form-control-sm border-start-0 border-end-0 border-top-0 rounded-0"
                        placeholder="Search by Receipt Number" autocomplete="off" maxlength="20">
                </div>
            </div>
        </div>
        <div id="ajax_result">
            @include('modules.patients.details.include.invoices_record_partial',['page'=>'invoices'])
        </div>
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->
@endsection
@section('scripts')
<script>
    window.patientConfig = {
        storeUrl: "{{ route('patient_external_documents.store') }}",
        csrfToken: "{{ csrf_token() }}",
        patientId: "{{ $patient->id }}",
        documentsListUrl: "{{ route('patients.documents_list', $patient->id) }}"
    };
</script>
<script src="{{getAssetsURLs('js/custom/patient_ex_docs.js')}}"></script>
<script>
    function updateInvoiceResults() {
        const q = $('#q').val().trim();
        const url = new URL(window.location.href);
        if (q !== '') {
            url.searchParams.set('q', q);
        } else {
            url.searchParams.delete('q');
        }

        $.ajax({
            url: url.href,
            type: "GET",
            dataType: 'json',
            success: function (response) {
                if (response.status === 200) {
                    $('#ajax_result').html(response.data);
                    window.history.pushState({}, '', url);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                Swal.fire("Error!", "Failed to fetch results", "error");
            }
        });
    }

    $(document).ready(function () {
        $('#q').on('keyup', function () {
            clearTimeout($.data(this, 'timer'));
            var wait = setTimeout(updateInvoiceResults, 300); // debounce
            $(this).data('timer', wait);
        });
    });
</script>
@endsection

