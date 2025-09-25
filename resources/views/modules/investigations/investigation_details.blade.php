@php
    $page = 'investigations';
    $sc = 'Investigations';
@endphp
@extends('layouts.master', ['activeMenu' => 'settings_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])
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
                {{ $sc }} Detail</h1>
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
                <p>
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{ $sc }} Detail</li>
                </p>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>
@endsection
@section('content')
<div class="container">
    <div class="row">
         @include('modules.investigations.include.nav_partial')
         @livewire('investigations.investigation-prices', ['investigationId' => $investigation->id], key('prices-list-'.$investigation->id))
    </div>
</div>
@include('modules.'.$page.'.modals.delete')
@endsection

@section('scripts')
<script src="{{getAssetsURLs('js/custom/helper_scripts.js')}}"></script>
<script>
$(document).ready(function(){
$(document).on('click', '.delete-{{$page}}', function(){
    $('#kt_modal_delete_{{$page}}_submit').attr('href', $(this).attr('href'));
    $('#kt_modal_delete_{{$page}}').modal('show');
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
                $("#dataResultDivLiveWire").load(location.href + " #dataResultDivLiveWire");
              }, 3000);
       },
    });
});

});
</script>
<script>
    function reinitMetronicMenuDropdowns() {
        // Destroy and re-init all dropdown menus
        document.querySelectorAll('[data-kt-menu]').forEach(el => {
            // Remove old menu instance if any (important for Livewire)
            if (KTMenu.getInstance(el)) {
                KTMenu.getInstance(el).destroy();
            }

            // Reinitialize menu
            KTMenu.createInstances();
        });
    }

    // Hook into Livewire render (for polling or form reset)
    Livewire.hook('message.processed', () => {
        reinitMetronicMenuDropdowns();
    });

    // Initial run
    document.addEventListener("DOMContentLoaded", () => {
        reinitMetronicMenuDropdowns();
    });
</script>
@endsection
