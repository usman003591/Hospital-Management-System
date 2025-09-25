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
                Lab Groups List</h1>
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
                    <li class="breadcrumb-item text-muted text-hover-primary">Lab Groups</li>
                </a>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
      @if(checkPersonPermission('create_lab_groups_55'))
        <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
            <a href="{{route($page.'.create')}}">
                <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_add_permission">
                    <i class="ki-duotone ki-plus-square fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>Add Lab Group</button></a>
        </div>
        @endif


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
                @if (checkIfUserIsAdmin())
                 <livewire:pathology.all-lab-groups/>
                @else
                <livewire:pathology.lab-groups/>
                @endif
        </div>
    </div>
</div>

@include('modules.'.$page.'.modals.delete')
@endsection

@section('scripts')
<script src="{{getAssetsURLs('js/custom/helper_scripts.js')}}"></script>
@if (auth()->user()->role_id == 1)
{{-- <script src="{{getAssetsURLs('js/custom/search_partial_lab_groups.js')}}"></script> --}}
@endif
@if (auth()->user()->role_id != 1)
 <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


 <style>
 .dataTables_wrapper.no-footer .dataTables_scrollBody {
  border-bottom: none !important;
    }

.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: white !important;
    border: 1px solid #007bff !important;
    background-color: #007bff !important;
    border-radius: 4px !important;
    background-image: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:not(.current):hover {
    color: #007bff !important;
    background-color: #f8f9fa !important;
    border: none !important;
    border-radius: 4px !important;
    background-image: none !important;
    box-shadow: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding:4px 12px;
    margin-left:7px;
}

/* Hide First and Last pagination buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button.first,
.dataTables_wrapper .dataTables_paginate .paginate_button.last {
    display: none !important;
}

</style>
    <script>
        $(document).ready(function() {
            var table = $('#lab-groups-datatable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                lengthChange: false,
                ordering: false,
                ajax: {
                    url: "{{ route('specific_lab_groups') }}",
                    type: 'GET',
                    data: function(d) {
                        d.search.value = $('#q').val();
                    }
                },
                columns: [
                    { data: 'lab_group_number', name: 'lab_group_number' },
                    { data: 'patient_name', name: 'patient_name' },
                    { data: 'status', name: 'status' },
                    { data: 'patient_mr_number', name: 'patient_mr_number' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                scrollY: 500,
                scrollX: true,
                pagingType: "simple_numbers",
                language: {
                    paginate: {
                        next: ">",
                        previous: "<"
                    },
                    info: "Showing _START_ to _END_ of _TOTAL_ records"
                },
                dom: '<"top">rt<"bottom"lip><"clear">'
            });

            $('#q').on('keyup', function() {
                table.search($(this).val()).draw();
            });
        });
    </script>

    @endif
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
             window.location.href = SITEURL+"/{{$page}}";
              }, 3000);

             },
    });
});


$(document).on('change','.change-status-{{$page}}', function(event) {
    event.preventDefault();
    id = $(this).data('id');
    status = this.value;

        $.ajax({
            type: "POST",
            url : '{{ route($page.'.change_status')}}',
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
                            window.location.href = "{{route('lab_groups.index')}}";
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


});

</script>
@endsection
