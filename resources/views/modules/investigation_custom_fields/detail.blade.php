@php $page='investigation_custom_fields'; @endphp
@extends('layouts.master',['activeMenu' => 'settings_management', 'activeSubMenu' => 'investigation_custom_fields', 'activeThirdMenu' =>
'investigation_custom_fields'])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <!--begin::Page title-->
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <!--begin::Title-->
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Investigation Custom Field Detail</h1>
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
                <a href="{{ route('investigation_custom_fields.index') }}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{ titleFilter($page) }}</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{ route('investigation_custom_fields.show', $customField->id) }}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Detail</li>
                </a>
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="gap-2 d-flex align-items-center gap-lg-3">
            <a href="{{ route('investigation_custom_fields.edit', $customField->id) }}">
                <button type="button" class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-pencil fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Edit</button>
            </a>
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>
@endsection

@section('content')
<div class="col-xl-12">
    <!--begin::List Widget 8-->
    <div class="mb-5 card card-xl-stretch mb-xl-8">
        <!--begin::Body-->
        <div class="card-body">
            <div class="row">
                <!-- First Kanban Board: Custom Field Details (Draggable Fields) -->
                <div class="col-md-6">
                    <h3 class="mb-6 font-size-lg text-dark font-weight-bold">Custom Field Details</h3>
                    <div class="kanban-board" id="customFieldBoard">
                        <div class="kanban-column" data-column="available">
                            <h4>Available Details</h4>
                            <div class="card card-flush draggable" data-id="name" data-type="custom">
                                <div class="card-body">
                                    <strong>Name:</strong> {{ $customField->name }}
                                    <input type="hidden" name="field_ids[]" value="name">
                                </div>
                            </div>
                            <div class="card card-flush draggable" data-id="unit" data-type="custom">
                                <div class="card-body">
                                    <strong>Unit:</strong> {{ $customField->unit }}
                                    <input type="hidden" name="field_ids[]" value="unit">
                                </div>
                            </div>
                            <div class="card card-flush draggable" data-id="male_reference" data-type="custom">
                                <div class="card-body">
                                    <strong>Male Reference:</strong> {{ $customField->male_reference_min }} - {{ $customField->male_reference_max }}
                                    <input type="hidden" name="field_ids[]" value="male_reference">
                                </div>
                            </div>
                            <div class="card card-flush draggable" data-id="female_reference" data-type="custom">
                                <div class="card-body">
                                    <strong>Female Reference:</strong> {{ $customField->female_reference_min }} - {{ $customField->female_reference_max }}
                                    <input type="hidden" name="field_ids[]" value="female_reference">
                                </div>
                            </div>
                            <div class="card card-flush draggable" data-id="all_reference" data-type="custom">
                                <div class="card-body">
                                    <strong>All Reference:</strong> {{ $customField->all_reference_min }} - {{ $customField->all_reference_max }}
                                    <input type="hidden" name="field_ids[]" value="all_reference">
                                </div>
                            </div>
                            @foreach($attachedFields as $attachedField)
                                @if(!in_array($attachedField->name, ['name', 'unit', 'male_reference', 'female_reference', 'all_reference']))
                                    <div class="card card-flush draggable" data-id="{{ $attachedField->id }}" data-type="db">
                                        <div class="card-body">
                                            {{ $attachedField->name ?? 'Unnamed Field' }} (Sort: {{ $attachedField->sort_order }})
                                            <input type="hidden" name="field_ids[]" value="{{ $attachedField->id }}">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Second Kanban Board: Attached Fields (Drop Target) -->
                <div class="col-md-6">
                    <h3 class="mb-6 font-size-lg text-dark font-weight-bold">Attached Fields</h3>
                    <form action="{{ route('investigation_custom_fields.update-attached', $customField->id) }}" method="POST" id="attachedFieldsForm">
                        @csrf
                        <input type="hidden" name="investigation_id" value="{{ $investigationId }}">
                        <input type="hidden" name="attached_field_ids" id="attached_field_ids" value="">
                        <div class="kanban-board" id="attachedFieldsBoard">
                            <div class="kanban-column" data-column="attached">
                                <h4>Attached Details</h4>
                                @foreach($attachedFields as $attachedField)
                                    @if(in_array($attachedField->name, ['name', 'unit', 'male_reference', 'female_reference', 'all_reference']))
                                        <div class="card card-flush draggable" data-id="{{ $attachedField->name }}" data-type="custom">
                                            <div class="card-body">
                                                @switch($attachedField->name)
                                                    @case('name')
                                                        <strong>Name:</strong> {{ $customField->name }}
                                                        @break
                                                    @case('unit')
                                                        <strong>Unit:</strong> {{ $customField->unit }}
                                                        @break
                                                    @case('male_reference')
                                                        <strong>Male Reference:</strong> {{ $customField->male_reference_min }} - {{ $customField->male_reference_max }}
                                                        @break
                                                    @case('female_reference')
                                                        <strong>Female Reference:</strong> {{ $customField->female_reference_min }} - {{ $customField->female_reference_max }}
                                                        @break
                                                    @case('all_reference')
                                                        <strong>All Reference:</strong> {{ $customField->all_reference_min }} - {{ $customField->all_reference_max }}
                                                        @break
                                                @endswitch
                                                <input type="hidden" name="field_ids[]" value="{{ $attachedField->name }}">
                                            </div>
                                        </div>
                                    @else
                                        <div class="card card-flush draggable" data-id="{{ $attachedField->id }}" data-type="db">
                                            <div class="card-body">
                                                {{ $attachedField->name ?? 'Unnamed Field' }} (Sort: {{ $attachedField->sort_order }})
                                                <input type="hidden" name="field_ids[]" value="{{ $attachedField->id }}">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-9"></div>
                                <div class="col-lg-3 text-end">
                                    {{-- <button type="submit" class="mr-2 btn btn-sm btn-primary">Save Attached Fields</button> --}}
                                    <a href="{{ route('investigation_custom_fields.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Body-->
    </div>
    <!--end::List Widget 8-->
</div>
@endsection

@section('styles')
<style>
    .kanban-board {
        display: flex;
        gap: 20px;
        padding: 20px;
        background: #f5f5f5;
        border-radius: 5px;
        min-height: 300px; /* Ensure minimum height for visibility */
    }
    .kanban-column {
        flex: 1;
        background: white;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        min-height: 200px; /* Ensure column is visible */
    }
    .card {
        background: #e9ecef;
        padding: 10px;
        margin: 5px 0;
        border-radius: 3px;
        cursor: move;
    }
    .draggable {
        user-select: none;
    }
</style>
@endsection

@section('scripts')
<script src="{{ getAssetsURLs('js/custom/helper_scripts.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(function() {
        let customFieldId = {{ $customField->id }};

        $(".kanban-board .draggable").draggable({
            revert: "invalid",
            containment: "document",
            helper: "clone",
            appendTo: "body"
        });

        $(".kanban-column").droppable({
            accept: ".draggable",
            drop: function(event, ui) {
                const draggable = ui.draggable;
                const droppedOn = $(this);
                const draggedItem = draggable.clone(); // Clone the original for manipulation
                const draggedId = draggable.data('id');
                const draggedType = draggable.data('type'); // 'custom' or 'db'

                // Remove the original draggable from its source column
                draggable.remove();

                // Add the cloned item to the drop target, but remove any existing clone helper
                draggedItem.css({ top: 0, left: 0 }).appendTo(droppedOn).draggable({
                    revert: "invalid",
                    containment: "document",
                    helper: "clone",
                    appendTo: "body"
                });

                // Update the database and hidden input
                updateDatabase(draggedId, draggedType, droppedOn.data('column'), customFieldId);
                updateHiddenInputs();
            }
        });

        function updateDatabase(fieldId, fieldType, targetColumn, customFieldId) {
            $.ajax({
                url: '{{ route("investigation_custom_fields.update-attached", ":id") }}'.replace(':id', customFieldId),
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    investigation_id: $('input[name="investigation_id"]').val(),
                    field_id: fieldId,
                    field_type: fieldType,
                    target_column: targetColumn
                },
                success: function(response) {
                    show_message('success', response.message);
                    refreshBoards(customFieldId); // Refresh the boards after update
                },
                error: function(xhr) {
                    show_message('error', 'Error updating attached fields');
                    console.log('Error Response:', xhr.responseText); // Log the error response for debugging
                    refreshBoards(customFieldId); // Revert on error
                }
            });
        }

        function refreshBoards(customFieldId) {
            $.ajax({
                url: '{{ route("investigation_custom_fields.show", ":id") }}'.replace(':id', customFieldId),
                method: 'GET',
                success: function(response) {
                    const $customFieldBoard = $('#customFieldBoard .kanban-column[data-column="available"]');
                    const $attachedFieldsBoard = $('#attachedFieldsBoard .kanban-column[data-column="attached"]');
                    const newCustomContent = $(response).find('#customFieldBoard .kanban-column[data-column="available"]').html();
                    const newAttachedContent = $(response).find('#attachedFieldsBoard .kanban-column[data-column="attached"]').html();

                    // Only update if the content has changed to avoid unnecessary resets
                    if ($customFieldBoard.html() !== newCustomContent || $attachedFieldsBoard.html() !== newAttachedContent) {
                        $customFieldBoard.html(newCustomContent);
                        $attachedFieldsBoard.html(newAttachedContent);
                        initializeDragDrop(); // Reinitialize drag-and-drop after refresh
                        updateHiddenInputs(); // Update hidden inputs after refresh
                    }
                },
                error: function(xhr) {
                    show_message('error', 'Error refreshing boards');
                    console.log('Refresh Error:', xhr.responseText);
                }
            });
        }

        function initializeDragDrop() {
            $(".kanban-board .draggable").draggable({
                revert: "invalid",
                containment: "document",
                helper: "clone",
                appendTo: "body"
            });

            $(".kanban-column").droppable({
                accept: ".draggable",
                drop: function(event, ui) {
                    const draggable = ui.draggable;
                    const droppedOn = $(this);
                    const draggedItem = draggable.clone();
                    const draggedId = draggable.data('id');
                    const draggedType = draggable.data('type');

                    draggable.remove();
                    draggedItem.css({ top: 0, left: 0 }).appendTo(droppedOn).draggable({
                        revert: "invalid",
                        containment: "document",
                        helper: "clone",
                        appendTo: "body"
                    });

                    updateDatabase(draggedId, draggedType, droppedOn.data('column'), customFieldId);
                    updateHiddenInputs();
                }
            });
        }

        function updateHiddenInputs() {
            const attachedIds = [];
            $("#attachedFieldsBoard .attached .draggable").each(function() {
                const id = $(this).data('id');
                if (id !== undefined) {
                    attachedIds.push(id);
                }
            });
            $("#attached_field_ids").val(JSON.stringify(attachedIds)); // Store as JSON string
            console.log('Attached IDs:', attachedIds); // Add console log for debugging
        }

        // Handle form submission
        $('#attachedFieldsForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            console.log('Form Data:', formData); // Log form data for debugging
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    show_message('success', response.message);
                    // Instead of refreshing boards immediately, update the UI manually to reflect the current state
                    const attachedIds = JSON.parse($("#attached_field_ids").val() || '[]');
                    const $attachedBoard = $('#attachedFieldsBoard .attached');
                    const $customBoard = $('#customFieldBoard .available');
                    $attachedBoard.empty();
                    $customBoard.empty();

                    // Rebuild boards based on attachedIds
                    attachedIds.forEach((id, index) => {
                        let cardHtml = '';
                        if (isNumeric(id)) {
                            // Database-stored attached fields
                            cardHtml = `<div class="card card-flush draggable" data-id="${id}" data-type="db">
                                <div class="card-body">${id} (Sort: ${index})<input type="hidden" name="field_ids[]" value="${id}"></div>
                            </div>`;
                            $attachedBoard.append(cardHtml);
                        } else {
                            // Custom field details (e.g., 'name', 'unit', etc.)
                            let fieldData = '';
                            switch (id) {
                                case 'name':
                                    fieldData = '<strong>Name:</strong> {{ $customField->name }}';
                                    break;
                                case 'unit':
                                    fieldData = '<strong>Unit:</strong> {{ $customField->unit }}';
                                    break;
                                case 'male_reference':
                                    fieldData = '<strong>Male Reference:</strong> {{ $customField->male_reference_min }} - {{ $customField->male_reference_max }}';
                                    break;
                                case 'female_reference':
                                    fieldData = '<strong>Female Reference:</strong> {{ $customField->female_reference_min }} - {{ $customField->female_reference_max }}';
                                    break;
                                case 'all_reference':
                                    fieldData = '<strong>All Reference:</strong> {{ $customField->all_reference_min }} - {{ $customField->all_reference_max }}';
                                    break;
                            }
                            cardHtml = `<div class="card card-flush draggable" data-id="${id}" data-type="custom">
                                <div class="card-body">${fieldData}<input type="hidden" name="field_ids[]" value="${id}"></div>
                            </div>`;
                            $attachedBoard.append(cardHtml);
                        }
                    });

                    // Rebuild custom board with remaining fields not in attachedIds
                    const allFields = ['name', 'unit', 'male_reference', 'female_reference', 'all_reference'];
                    allFields.forEach(id => {
                        if (!attachedIds.includes(id)) {
                            let fieldData = '';
                            switch (id) {
                                case 'name':
                                    fieldData = '<strong>Name:</strong> {{ $customField->name }}';
                                    break;
                                case 'unit':
                                    fieldData = '<strong>Unit:</strong> {{ $customField->unit }}';
                                    break;
                                case 'male_reference':
                                    fieldData = '<strong>Male Reference:</strong> {{ $customField->male_reference_min }} - {{ $customField->male_reference_max }}';
                                    break;
                                case 'female_reference':
                                    fieldData = '<strong>Female Reference:</strong> {{ $customField->female_reference_min }} - {{ $customField->female_reference_max }}';
                                    break;
                                case 'all_reference':
                                    fieldData = '<strong>All Reference:</strong> {{ $customField->all_reference_min }} - {{ $customField->all_reference_max }}';
                                    break;
                            }
                            const cardHtml = `<div class="card card-flush draggable" data-id="${id}" data-type="custom">
                                <div class="card-body">${fieldData}<input type="hidden" name="field_ids[]" value="${id}"></div>
                            </div>`;
                            $customBoard.append(cardHtml);
                        }
                    });

                    initializeDragDrop(); // Reinitialize drag-and-drop after manual update
                },
                error: function(xhr) {
                    show_message('error', 'Error saving attached fields');
                    console.log('Error Response:', xhr.responseText); // Log the error response for debugging
                }
            });
        });

        // Helper function to check if a value is numeric
        function isNumeric(value) {
            return !isNaN(parseFloat(value)) && isFinite(value);
        }

        // Initial setup
        initializeDragDrop();
        updateHiddenInputs(); // Initialize hidden inputs with current state
    });
</script>
@endsection
