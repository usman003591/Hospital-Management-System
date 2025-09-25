@php
    $page = 'appointment_statuses';
    $ap = 'Appointment Status';
@endphp

@extends('layouts.master', ['activeMenu' => 'settings_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])

@section('breadcrumbs')
    <div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
            data-select2-id="select2-data-kt_app_toolbar_container">
            <!--begin::Page title-->
            <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
                <!--begin::Title-->
                <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                    {{ $ap }} List
                </h1>
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
                    <a href="{{ route('appointment_statuses.index') }}">
                        <span></span>
                        <li class="breadcrumb-item text-muted text-hover-primary">{{ $ap }}</li>
                    </a>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
                @if(checkPersonPermission('create_appointment_statuses_30'))
                    <a href="{{ route($page . '.create') }}">
                        <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_add_permission">
                            <i class="ki-duotone ki-plus-square fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>Add Appointment Status
                        </button>
                    </a>
                @endif
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
                <livewire:appointment-statuses.all-appointment-statuses-listing />
            </div>
        </div>
    </div>

    @include('modules.' . $page . '.modals.delete')
@endsection

@section('scripts')
    <script src="{{ getAssetsURLs('js/custom/helper_scripts.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.delete-{{ $page }}', function() {
                var statusId = $(this).data('id');
                var url = "{{ route($page . '.delete', ':id') }}".replace(':id', statusId);
                $('#kt_modal_delete_{{ $page }}_form').attr('action', url);
                $('#kt_modal_delete_{{ $page }}').modal('show');
                return false;
            });

            $(document).on('click', '#kt_modal_delete_{{ $page }}_close, #kt_modal_delete_{{ $page }}_cancel', function() {
                $('#kt_modal_delete_{{ $page }}').modal('hide');
                return false;
            });

            $(document).on('submit', '#kt_modal_delete_{{ $page }}_form', function(event) {
                event.preventDefault();
                var formAction = $(this).attr('action');
                $.ajax({
                    url: formAction,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(result) {
                        $('#kt_modal_delete_{{ $page }}').modal('hide');
                        show_message('success', result.message);
                        setTimeout(function() {
                            window.location.href = SITEURL + "/{{ $page }}";
                        }, 3000);
                    },
                    error: function() {
                        $('#kt_modal_delete_{{ $page }}').modal('hide');
                        show_message('error', 'Failed to delete appointment status.');
                    }
                });
            });
        });
    </script>
@endsection