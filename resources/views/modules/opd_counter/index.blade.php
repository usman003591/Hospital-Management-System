@php
    $page = 'opd_counter';
@endphp

@extends('layouts.master', ['activeMenu' => 'settings_management', 'activeSubMenu' => 'opd_counter', 'activeThirdMenu' => 'opd_counter'])

@section('breadcrumbs')
    <div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack" data-select2-id="select2-data-kt_app_toolbar_container">
            <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
                <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                    {{ titleFilter($page) }} List
                </h1>
                <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bg-gray-500 bullet w-5px h-2px"></span>
                    </li>
                    <li><a href="{{ route('opd_counter.index') }}">
                        <li class="breadcrumb-item text-muted text-hover-primary">{{ titleFilter($page) }}</li>
                    </a></li>
                </ul>
            </div>
            <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
                @if(checkPersonPermission('create_opd_counter_57'))
                    <a href="{{ route($page . '.create') }}">
                        <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_permission">
                            <i class="ki-duotone ki-plus-square fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>Add OPD Counter
                        </button>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('include.messages')
                <livewire:opd-counters.all-opd-counters-listing/>
            </div>
        </div>
    </div>

    @include('modules.opd_counter.modals.delete')
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
    </script>
@endsection