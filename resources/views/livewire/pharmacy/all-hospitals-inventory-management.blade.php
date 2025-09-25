<div class="container">

    <div class="row">
        <div class="col-md-12">

            <div class="mb-5 form-group row bg-search">
             <div class="col-lg-3">
                    <input type="text" wire:model.live.debounce.500ms="q" id="q" name="invoice_search"
                        {{-- class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary search-input" --}}
                         class="mb-3 w-100 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary search-input"
                        placeholder="Search Inventory By Medicine Name" value="" maxlength="50">
                </div>

                <div class="col-lg-3">
                    <select wire:model.live="hospital" class="form-select form-select-solid bg-body-secondary"
                         data-placeholder="Select Hospital" data-allow-clear="false">
                        <option value="">Select All Hospital</option>
                        @foreach ($hospitals as $hospital)
                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3">
                    <select wire:model.live="status" id="status" class="form-select form-select-solid bg-body-secondary"
                        data-placeholder="Select Status" data-allow-clear="true">
                        <option value="">Select Status</option>
                        @isset($inventory_statuses)
                          @foreach ($inventory_statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                          @endforeach
                        @endisset
                    </select>
                </div>

                <div class="col-lg-3 d-flex justify-content-end">
                    <button type="button" wire:click="resetFilters" class="btn btn-sm btn-light-primary">Reset</button>
                </div>
            </div>

            <div class="card card-flush">
                <div class="pt-0 card-body">
                    <div class="table-responsive">
                                    <table class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable">
                           <thead class="text-gray-500 fs-7 text-uppercase">
                            <tr role="row" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                    data-dt-column="0" rowspan="1" colspan="1" aria-label="Manager: Activate to sort"
                                    tabindex="0" style="min-width: 18rem"><span
                                        class="dt-column-title">Name</span><span
                                        class="dt-column-order"></span></th>

                                  <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                    data-dt-column="0" rowspan="1" colspan="1" aria-label="Manager: Activate to sort"
                                    tabindex="0" style="min-width: 18rem"><span
                                        class="dt-column-title">Reorder Number</span><span
                                        class="dt-column-order"></span></th>

                                   <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                    data-dt-column="0" rowspan="1" colspan="1" aria-label="Manager: Activate to sort"
                                    tabindex="0" style="min-width: 18rem"><span
                                        class="dt-column-title">Quantity</span><span
                                        class="dt-column-order"></span></th>

                                         <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1"
                                    colspan="1" aria-label="Status: Activate to sort" tabindex="0"
                                    style="min-width: 7rem"><span class="dt-column-title">Status</span><span
                                        class="dt-column-order"></span></th>
                                <th class="text-center dt-orderable-none" data-dt-column="4" rowspan="1" colspan="1"
                                    aria-label="Details" style="min-width: 7rem"><span
                                        class="dt-column-title">Actions</span><span class="dt-column-order"></span>
                                </th>
                                          </tr>
                        </thead>

                <tbody class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                     @forelse ($data as $inventory)
                            <tr>

                                <td><a class="mb-1 text-gray-800 text-hover-primary" href="{{ route('pharmacy.list_pharmacy_inventory_batches', $inventory->medicine_id) }}">{{ $inventory->medicine_name }}</a></td>
                                <td>{{ $inventory->reorder_number }}</td>
                                <td>{{ $inventory->quantity }}</td>
                                <td>
                                    @isset($inventory->medicine_inventory_status)
                                    <span>{{ $inventory->medicine_inventory_status }}</span>
                                    @endisset
                                </td>

                                  <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center">

                                            @if (checkPersonPermission('inventory_batches_pharmacy_inventory_71'))
                                            <a href="{{ route('pharmacy.list_pharmacy_inventory_batches', $inventory->medicine_id) }}"
                                                data-id="{{ $inventory->id }}"
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px medicine-inventory-batches-{{ $page }}"
                                                title="Medicine Inventory Batches">
                                                <i class="ki-duotone ki-element-11 fs-3 text-danger">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>
                                            </a>
                                            @endif

                                            @if (checkPersonPermission('update_pharmacy_inventory_71'))
                                            <a title="Edit Inventory Batches"
                                                href="{{ route('pharmacy.edit_pharmacy_inventory', $inventory->id) }}">
                                                <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                                    <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                            </a>
                                            @endif

                                            @if (checkPersonPermission('delete_pharmacy_inventory_71'))
                                            <a title="Delete" data-id="{{ $inventory->id }}"
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px delete-{{$page}}"
                                                data-kt-permissions-table-filter="delete_row">
                                                <i class="ki-duotone ki-trash fs-3 text-danger">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>
                                            </a>
                                            @endif

                                        </div>
                                    </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No Medicine Inventory found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                      <div class="row">
                            <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                <div>
                                    @if($data->total() > 0)
                                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
                                    @else
                                        No records found @if(request()->has('q') || request()->has('status')) for the applied filters @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
                                <div class="dt-paging paging_simple_numbers">
                                    {!! $data->links('pagination::bootstrap-4') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
