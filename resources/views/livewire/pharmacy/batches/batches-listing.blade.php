<div>
    <div class="flex-wrap d-flex flex-stack pb-7">
        <!--begin::Title-->
        <div class="flex-wrap my-1 d-flex align-items-center">
            <!--begin::Search-->
            <div class="my-1 d-flex align-items-center position-relative">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-3">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <input type="text" wire:model.live.debounce.500ms="q"
                    class="form-control form-control-xl form-control-solid w-350px ps-10" placeholder="Search">
            </div>
            <!--end::Search-->
        </div>
        <!--end::Title-->
        <!--begin::Controls-->
        {{-- <div class="flex-wrap my-1 d-flex">
            <!--begin::Tab nav-->
            <ul class="mb-2 nav nav-pills me-6 mb-sm-0" role="tablist">
                <li class="m-0 nav-item" role="presentation">
                    <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary me-3 active"
                        data-bs-toggle="tab" href="#kt_project_users_card_pane" aria-selected="true" role="tab">
                        <i class="ki-duotone ki-element-plus fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>
                    </a>
                </li>
                <li class="m-0 nav-item" role="presentation">
                    <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary" data-bs-toggle="tab"
                        href="#kt_project_users_table_pane" aria-selected="false" tabindex="-1" role="tab">
                        <i class="ki-duotone ki-row-horizontal fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                </li>
            </ul>
            <!--end::Tab nav-->
        </div> --}}
        <!--end::Controls-->
    </div>

    <div class="tab-content">
        <!--begin::Tab pane-->
        <div id="kt_project_users_card_pane" class="tab-pane fade show active" role="tabpanel">
            <!--begin::Row-->
            <div class="row g-6 g-xl-9">
                <!--begin::Col-->
                @if (count($batches) > 0)
                @foreach ($batches as $d)
                <div class="col-md-6 col-xxl-4">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="pt-12 card-body d-flex flex-center flex-column p-9">

                            <!-- Batch Number -->
                            <a href="#" class="mb-0 text-gray-800 fs-4 text-hover-primary fw-bold">
                                @isset($d->batch_number) {{ $d->batch_number }} @endisset
                            </a>

                            <!-- Barcode -->
                            <div class="mb-6 text-gray-500 fw-semibold">
                                @isset($d->barcode) {{ $d->barcode }} @endisset
                            </div>

                            <!--begin::Info-->
                            <div class="w-100">

                                <!-- Quantities -->
                                <div class="mb-3 row g-3">
                                    <div class="col-6">
                                        <div class="px-4 py-3 text-center border border-gray-300 border-dashed rounded">
                                            <div class="text-gray-700 fs-6 fw-bold">
                                                @isset($d->quantity) {{ $d->quantity }} @endisset
                                            </div>
                                            <div class="text-gray-500 fw-semibold">Quantity</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="px-4 py-3 text-center border border-gray-300 border-dashed rounded">
                                            <div class="text-gray-700 fs-6 fw-bold">
                                                @isset($d->medicine_minimum_quantity) {{ $d->medicine_minimum_quantity
                                                }} @endisset
                                            </div>
                                            <div class="text-gray-500 fw-semibold">Minimum Quantity</div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Dates -->
                                <div class="mb-3 row g-3">
                                    <div class="col-6">
                                        <div class="px-4 py-3 text-center border border-gray-300 border-dashed rounded">
                                            <div class="text-gray-700 fs-6 fw-bold">
                                                @isset($d->expiry_date) {{
                                                getDateInStandardFormat(Carbon\Carbon::parse($d->expiry_date)) }}
                                                @endisset
                                            </div>
                                            <div class="text-gray-500 fw-semibold">Expiry Date</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="px-4 py-3 text-center border border-gray-300 border-dashed rounded">
                                            <div class="text-gray-700 fs-6 fw-bold">
                                                @isset($d->manufacturing_date) {{
                                                getDateInStandardFormat(Carbon\Carbon::parse($d->manufacturing_date)) }}
                                                @endisset
                                            </div>
                                            <div class="text-gray-500 fw-semibold">Manufacturing Date</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-4">
                                        <div class="px-4 py-3 text-center border border-gray-300 border-dashed rounded">
                                            <div class="text-gray-700 fs-6 fw-bold">
                                                @isset($d->packet_price) {{ intval($d->packet_price) }} @endisset
                                            </div>
                                            <div class="text-gray-500 fw-semibold">Packet</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="px-4 py-3 text-center border border-gray-300 border-dashed rounded">
                                            <div class="text-gray-700 fs-6 fw-bold">
                                                @isset($d->packet_items) {{ intval($d->packet_items) }} @endisset
                                            </div>
                                            <div class="text-gray-500 fw-semibold">Items</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="px-4 py-3 text-center border border-gray-300 border-dashed rounded">
                                            <div class="text-gray-700 fs-6 fw-bold">
                                                @isset($d->selling_price) {{ intval($d->selling_price) }} @endisset
                                            </div>
                                            <div class="text-gray-500 fw-semibold">Price</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Card body-->

                        <!--begin::Card footer-->
                        <div class="gap-3 py-3 card-footer d-flex justify-content-center">
                            @if (checkPersonPermission('update_pharmacy_inventory_batches_72'))
                            <livewire:pharmacy.batches.edit-medicine-batch :batchId="$d->id" :medicineId="$medicineId"
                                :medicineName="$medicineName" />
                            @endif
                            @if (checkPersonPermission('delete_pharmacy_inventory_batches_72'))
                            <a wire:click="confirmDelete({{ $d->id }})" class="btn btn-icon btn-sm"
                                data-bs-toggle="tooltip" title="Delete">
                                <i class="bi bi-trash text-danger fs-5"></i>
                            </a>
                            @endif
                            @if (checkPersonPermission('download_barcode_pharmacy_inventory_batches_72'))
                            <a href="{{route('pharmacy.download_pharmacy_inventory_batch_code', ['medicine_id' => $medicineId, 'batch_id' => $d->id])}}"
                                target="_blank" class="btn btn-icon btn-sm" data-bs-toggle="tooltip"
                                title="Download Barcode">
                                <i class="bi bi-upc-scan text-success fs-5"></i>
                            </a>
                            @endif
                        </div>
                        <!--end::Card footer-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
                @endforeach
                @endif



                <div wire:ignore.self class="modal fade" id="deleteConfirmModal" tabindex="-1"
                    aria-labelledby="deleteConfirmLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="text-white modal-header bg-danger">
                                <h5 class="modal-title" id="deleteConfirmLabel">Confirm Deletion</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this medicine Batch?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>





            </div>
            <!--end::Row-->
            <!--begin::Pagination-->
            <br>
            <div class="row">
                <div
                    class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                    <div>
                        @if($batches->total() > 0)
                        Showing {{ $batches->firstItem() }} to {{ $batches->lastItem() }} of {{ $batches->total() }}
                        records
                        @else
                        No records found @if($q) for the applied filters @endif
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
                    <div class="dt-paging paging_simple_numbers">
                        {!! $batches->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
            <!--end::Pagination-->
        </div>
        <!--end::Tab pane-->
        <!--begin::Tab pane-->

        <!--end::Tab pane-->
    </div>

</div>
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        Livewire.on('show-bootEdit-modal', () => {
            console.log("Event received: show-bootEdit-modal"); // ✅ Debug
            let modal = new bootstrap.Modal(document.getElementById('editMedicineBatchModal'));
            modal.show();
        });

        Livewire.on('hide-bootEdit-modal', () => {
            console.log("Event received: hide-bootEdit-modal"); // ✅ Debug
            let modalEl = document.getElementById('editMedicineBatchModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });
    });
</script>
<script>
    window.addEventListener('show-delete-modal', () => {
        let modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        modal.show();
    });
    window.addEventListener('hide-delete-modal', () => {
        let modalEl = document.getElementById('deleteConfirmModal');
        let modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    });




</script>
@endpush
