<div>
    @if($documents->isNotEmpty())
    <h4 class="mb-5 modal-header">Uploaded Documents</h4>
    <div class="table-responsive mx-7" id="document-table-wrapper">
        <table class="table table-hover table-row-bordered align-middle">
            <tbody>
                @foreach($documents as $document)
                <tr wire:key="doc-{{ $document->id }}">
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold">{{ $document->external_document_name }}</span>
                            <small class="text-muted">
                                Size: {{ number_format($document->external_document_file_size / 1024, 2) }} KB
                                @if($document->external_document_extension)
                                | Type: {{ strtoupper($document->external_document_extension) }}
                                @endif
                            </small>
                        </div>
                    </td>
                    <td class="text-center py-5">
                        {{-- <button wire:click="previewDocument({{ $document->id }})" class="btn btn-sm btn-link me-5"
                            wire:loading.attr="disabled">
                            <i class="ki-duotone ki-folder-down fs-3 text-warning">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </button> --}}

                        <a href="{{ route('patient_external_documents.preview', ['document' => $document->id]) }}" target="_blank"
                            class="btn btn-sm" title="Preview">
                            <i class="ki-duotone ki-eye fs-3 text-success">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                        </a>

                        <button wire:click="confirmDelete({{ $document->id }})" title="Delete"
                            class="btn btn-sm btn-link">
                                <i class="ki-duotone ki-trash fs-3 text-danger">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                            </span>

                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-10">
        <i class="ki-duotone ki-folder fs-3x text-muted mb-3">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        <p class="text-muted fs-5">No documents found</p>
    </div>
    @endif
@if ($showDeleteConfirmation)
<div class="modal fade show d-block" tabindex="-1" aria-modal="true" role="dialog">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <h2 class="fw-bold">Are you sure you want to delete this document?</h2>
                <button wire:click="$set('showDeleteConfirmation', false)" type="button"
                    class="btn btn-icon btn-sm btn-active-icon-primary">
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                </button>
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body">
                <p>Document: <strong>{{ $documentToDelete->external_document_name ?? '—' }}</strong></p>
                <p>This action cannot be undone.</p>
            </div>
            <!--end::Modal body-->

            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <button wire:click="$set('showDeleteConfirmation', false)" type="button"
                    class="btn btn-light me-3">Discard</button>
                <button wire:click="deleteDocument" type="button" class="btn btn-danger">
                    <span class="indicator-label">Confirm Delete</span>
                </button>
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
</div>

<!-- Modal backdrop -->
<div class="modal-backdrop fade show"></div>
@endif
<div class="col-sm-12 col-md-7 d-flex align-items-end justify-content-end justify-content-md-end w-100 mt-3">
            {!! $documents->links('pagination::bootstrap-4') !!}
    </div>


</div>
