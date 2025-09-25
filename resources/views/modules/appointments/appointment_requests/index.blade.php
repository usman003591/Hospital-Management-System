@php
    $page = 'appointment_requests';
    $sc = 'Appointment Requests';
@endphp

@extends('layouts.master', ['activeMenu' => 'appointment_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])

@section('breadcrumbs')
    <div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack" data-select2-id="select2-data-kt_app_toolbar_container">
            <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
                <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                    {{ $sc }} List
                </h1>
                <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bg-gray-500 bullet w-5px h-2px"></span>
                    </li>
                    <a href="{{ route($page . '.index') }}">
                        <li class="breadcrumb-item text-muted text-hover-primary">{{ $sc }}</li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('include.messages')
                <livewire:appointment-requests.all-appointment-requests-listing />
            </div>
        </div>
    </div>

    @include('modules.appointments.appointment_requests.modals.delete')
@endsection

@section('scripts')
    <script src="{{ getAssetsURLs('js/custom/helper_scripts.js') }}"></script>
    <script>
        $(document).ready(function() {
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
                var getURL = $(this).attr('href');
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

        function show_message(type, message) {
            Swal.fire({
                text: message,
                icon: type,
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
    </script>
@endsection