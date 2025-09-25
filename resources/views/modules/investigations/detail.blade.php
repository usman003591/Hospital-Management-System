@extends('layouts.master', ['activeMenu' => 'settings_management', 'activeSubMenu' => $page,
'activeThirdMenu' => $page])
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
                <a href="{{route($page.'.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{titleFilter($page)}}</li>
                </a>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="#">
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
{{-- <h3 class="mb-4 text-center">{{ $investigation->name ?? 'N/A' }}</h3> --}}
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h4 class="text-primary">Available Custom Fields</h4>
            <div id="custom-fields" class="connected-sortable border p-3 rounded bg-light min-h-300px">
                @foreach($customFields as $field)
                <div class="kanban-item card p-2 mb-2" data-id="{{ $field->field_id }}" data-type="custom">
                    <div class="fw-semibold">{{ $field->name }}</div>
                    <small class="text-muted">{{ $field->unit }}</small>
                </div>
                @endforeach

            </div>
        </div>

        <div class="col-md-6">
            <h4 class="text-success">Attached Fields</h4>
            {{-- @if($attachedFields->isNotEmpty()) --}}
            <div id="attached-fields" class="connected-sortable border p-3 rounded bg-light min-h-300px">
                @foreach($attachedFields as $field)
                <div class="kanban-item card p-2 mb-2" data-id="{{ $field->field_id }}"
                    data-attached-id="{{ $field->attached_id }}" data-type="attached">
                    <div class="fw-semibold">{{ $field->name }}</div>
                    <small class="text-muted">{{ $field->unit }}</small>
                </div>
                @endforeach
            </div>
            {{-- @else
            <p class="text text-danger">No attached fields found for this investigation.</p>
            @endif --}}
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
    $(function () {
    $(".connected-sortable").sortable({
        connectWith: ".connected-sortable",
        placeholder: "sortable-placeholder",
        receive: function (event, ui) {
            const item = $(ui.item);
            const from = item.data('type');
            const fieldId = item.data('id');
            const attachedId = item.data('attached-id');
            const targetId = $(this).attr('id');

            if (from === 'attached' && targetId === 'custom-fields') {
                $.ajax({
                    url: "{{ route('investigations.detach') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        field_id: fieldId,
                        attached_id: attachedId
                    },
                    success: function () {
                        item.removeAttr('data-attached-id');
                        item.attr('data-type', 'custom');
                        refreshFields();
                    },
                    error: function () {
                        alert('Error detaching field.');
                    }
                });
            }

            if (from === 'custom' && targetId === 'attached-fields') {
                $.ajax({
                    url: "{{ route('investigations.attach') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        field_id: fieldId,
                        investigation_id: '{{ $investigation_id }}'
                    },
                    success: function (response) {
                        item.attr('data-attached-id', response.attached_id);
                        item.attr('data-type', 'attached');
                        refreshFields();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('Error attaching field.');
                    }
                });
            }
        }
    }).disableSelection();

    function refreshFields() {
        $.ajax({
            url: "{{ route('investigations.show', $investigation_id) }}",
            method: 'GET',
            success: function (response) {
                $('#attached-fields').html($(response).find('#attached-fields').html());
                $('#custom-fields').html($(response).find('#custom-fields').html());
            },
            error: function () {
                console.error('Error refreshing fields');
            }
        });
    }
});

</script>

@endsection
