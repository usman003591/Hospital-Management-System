@php $page='inventory_management'; @endphp
@extends('layouts.master',['activeMenu' => 'pharmacy_management', 'activeSubMenu' => 'inventory_management','activeThirdMenu' => 'inventory_management'])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <!--begin::Page title-->
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <!--begin::Title-->
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Pharmacy Inventory Management</h1>
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <li class="breadcrumb-item text-muted">
                    <a href="" class="text-muted text-hover-primary">Pharmacy</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <a href="{{route('pharmacy.list_pharmacy_inventory')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary"> Pharmacy Inventory</li>
                </a>
            </ul>
        </div>
              <!--begin::Actions-->

                          @if (checkPersonPermission('create_pharmacy_inventory_71'))
            <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
                    <a href="{{ route('pharmacy.create_pharmacy_inventory') }}">
                        <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_permission">
                            <i class="ki-duotone ki-plus-square fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>Add Medicine Inventory
                        </button>
                    </a>
            </div>
            @endif
            <!--end::Actions-->

    </div>
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
@if (checkIfUserIsAdmin())
<livewire:pharmacy.all-hospitals-inventory-management>
@else
<livewire:pharmacy.inventory-management/>
@endif
@include('modules.pharmacy.inventory_management.modals.delete')
@endsection
@section('scripts')
<script src="{{getAssetsURLs('js/custom/helper_scripts.js')}}"></script>
<script>

$(document).ready(function() {

    $(document).on('click', '.delete-{{ $page }}', function (e) {
        e.preventDefault();
        let inventory_id = $(this).data('id');
        var url = "{{ route('pharmacy.destroy_pharmacy_inventory', ':inventory_id') }}".replace(':inventory_id', inventory_id);
        $('#kt_modal_delete_{{ $page }}_form').attr('action', url);
        $('#kt_modal_delete_{{ $page }}').modal('show');
    });

    $(document).on('click', '#kt_modal_delete_{{ $page }}_close', function() {
        $('#kt_modal_delete_{{ $page }}').modal('hide');
        return false;
    });

    $(document).on('click', '#kt_modal_delete_{{ $page }}_cancel', function() {
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
                    window.location.href = "{{ route('pharmacy.list_pharmacy_inventory') }}";
                }, 3000);
            },
            error: function() {
                $('#kt_modal_delete_{{ $page }}').modal('hide');
                show_message('error', 'Failed to delete Medicine inventory.');
            }
        });
    });
});
</script>
@endsection
