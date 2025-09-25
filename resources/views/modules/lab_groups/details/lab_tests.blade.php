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
                    <li class="breadcrumb-item text-muted text-hover-primary">Lab Tests</li>
                </a>
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

    </div>
    <!--end::Toolbar container-->
</div>
@endsection
@section('content')
@include('include.messages')
@include('modules.'.$page.'.details.include.nav_partial',['tab' => 'lab_tests'])
@livewire('pathology.lab-group-tests', ['lab_group_id' => $obj->id])
<br>
@include('modules.'.$page.'.details.modals.delete', [$page => 'lab_tests'])
@include('modules.'.$page.'.details.modals.add_tests', [$page => 'lab_tests'])

@endsection
@php
$page = 'lab_tests';
@endphp
@section('scripts')
<script src="{{getAssetsURLs('js/custom/search_partial_lab_groups.js')}}"></script>
<script src="{{getAssetsURLs('js/custom/helper_scripts.js')}}"></script>
<script src="{{ getAssetsURLs('js/custom/select2_lab_groups.js') }}" ></script>
<script>
    // Set CSRF token for all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

$(document).on('click', '.delete_lab_tests', function(){
    $('#kt_modal_delete_lab_tests_submit').attr('href', $(this).attr('href'));
    $('#kt_modal_delete_lab_tests').modal('show');
    return false;
});

$(document).on('click', '#kt_modal_delete_lab_tests_close', function(){
    $('#kt_modal_delete_lab_tests').modal('hide');
    return false;
});

$(document).on('click', '#kt_modal_delete_lab_tests_cancel', function(){
    $('#kt_modal_delete_lab_tests').modal('hide');
    return false;
});

$(document).on('click', '#kt_modal_add_lab_tests_close', function(){
    $('#kt_modal_add_lab_tests').modal('hide');
    return false;
});

$(document).on('click', '#kt_modal_add_lab_tests_cancel', function(){
    $('#kt_modal_add_lab_tests').modal('hide');
    return false;
});

$(document).on('click', '#kt_modal_delete_lab_tests_submit', function(event){
    event.preventDefault();
    getURL = $(this).attr('href');
    $.ajax({
        url: getURL,
        method: 'delete',
        success: function(result){
            $('#kt_modal_delete_lab_tests').modal('hide');
            show_message('success', result.message);
            setTimeout(function() {
                   window.location.href = "{{route('lab_groups.lab_tests',$obj->id)}}";
            }, 3000);

        },
    });
});


$(document).on('change','.change-status-lab_tests', function(event) {
    event.preventDefault();
    id = $(this).data('id');
    status = this.value;

        $.ajax({
            type: "POST",
            url : '{{ route('lab_tests.change_status')}}',
            dataType: 'json',
            data: {status:status,id:id},
            success: function (data) {
                console.log(data);

                if(data.status === 400){
                        var values = '';
                        $.each(data.message.message, function (key, value) {  values += value   });
                        Swal.fire("Error!",values, "error");
                    }
                    if(data.status === 200) {
                        var message = data.message;
                        Swal.fire("Success!", message, "success");
                        setTimeout(function(){
                            window.location.href = "{{route('lab_groups.lab_tests',$obj->id)}}";
                        }, 3000);
                    }
            },
            error: function (data) {
                console.log('Error:', data.responseText);
                var error = data.responseText
                Swal.fire("Error!", error, "error");
            }

            });
        });



</script>
@endsection
