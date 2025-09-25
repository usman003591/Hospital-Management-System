<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('include.messages')
            <style>
                #normal_reset {
                    background-color: #e9f3ff;
                    color: #1b84ff
                }

                #normal_reset:hover {
                    background-color: #1b84ff;
                    color: #fff;
                }
            </style>
            <div class="mb-5 form-group row bg-search">
                <div class="col-lg-6">
                    <input type="text" wire:model.live.debounce.500ms="q" id="q"
                        class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
                        placeholder="Search Invoice" maxlength="50">
                </div>

                <div class="col-lg-4">
                    <select wire:model.live="hospital_id" class="form-select form-select-solid bg-body-secondary"
                        data-placeholder="Select hospital" data-allow-clear="false">
                        <option value="">All hospitals</option>
                        @foreach($hospitals as $hospital)
                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 mobile-space">
                    <div class="d-flex justify-content-end">
                        <button type="button" wire:click="resetFilters" id="normal_reset"
                            class="px-6 btn btn-sm me-2">Reset</button>
                    </div>
                </div>
            </div>

            <!--begin::Card-->
            <div class="mb-5 card mb-xl-8">
                <!--begin::Header-->
                <div class="pt-5 border-0 card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="mb-1 card-label fw-bold fs-3">Recent Pathology Invoices</span>
                    </h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-success btn-sm mb-3" wire:click="verifySelected"
                            wire:loading.attr="disabled"> <i class="ki-duotone ki-check fs-2">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            Verify Selected
                            <span class="spinner-border spinner-border-sm ms-2" role="status" wire:loading></span>
                        </button>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="py-3 card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-bordered table-row-gray-100 gs-0 gy-3">
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th class="w-25px">
                                    </th>
                                    <th class="min-w-150px">Hospital Name</th>
                                    <th class="min-w-140px">Hospital Receipt#</th>
                                    <th class="min-w-120px">Date</th>
                                    <th class="min-w-120px">Total Amount</th>
                                    <th class="min-w-120px">Discount</th>
                                    <th class="min-w-120px">Net Amount</th>
                                    <th class="min-w-120px">Finance Status</th>
                                    <th class="min-w-100px text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($data as $d)
                                <tr wire:key="pathology-invoice-{{ $d->id }}">
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" wire:model="selectedItems"
                                                value="{{ $d->id }}">
                                        </div>
                                    </td>

                                    <td class="text-gray-900 text-hover-primary fs-6">
                                        {{ $d->hospital_name }}
                                    </td>

                                    <td class="text-gray-900 text-hover-primary fs-6">
                                        {{ $d->invoice_sequence }}
                                    </td>

                                    <td class="text-gray-900 text-hover-primary fs-6">
                                        {{ $d->date_issued ? \Carbon\Carbon::parse($d->date_issued)->format('Y-m-d') :
                                        '' }}
                                    </td>

                                    <td class="text-gray-900 text-hover-primary fs-6">
                                        {{ number_format((float) ($d->total_amount ?? 0), 2) }}
                                    </td>

                                    <td class="text-gray-900 text-hover-primary fs-6">
                                        {{ number_format((float) ($d->discount_amount ?? 0), 2) }}
                                    </td>

                                    <td class="text-gray-900 text-hover-primary fs-6">
                                        {{ number_format((float) ($d->net_amount ?? 0), 2) }}
                                    </td>

                                    <td>
                                        {!! getFinanceApprovalStatusLabel($d->is_finance_verified) !!}
                                    </td>

                                    <td class="text-center">
                                        @if(checkPersonPermission('detail_pathology_invoices_verification_64'))
                                        <a title="Detail"
                                            href="{{route('finance.pathology_invoices_verification_detail', ['id' => $d->id])}}"
                                            class="btn btn-icon btn-active-color-primary w-30px h-30px">
                                            <i class="ki-duotone ki-document fs-3 text-info">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                        </a>
                                        @endif
                                        @if(checkPersonPermission('download_pathology_invoices_verification_64'))
                                        <a title="Download Receipt" target="_blank"
                                            href="{{ route('finance.download_pathology_invoice', $d->id) }}"
                                            class="btn btn-icon btn-active-color-primary w-30px h-30px">
                                            <i class="ki-duotone ki-folder-down fs-3 text-warning">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="py-10 text-center text-muted">No records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div
                            class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                            <div>
                                @if($data->total() > 0)
                                Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }}
                                records
                                @else
                                No records found
                                @if(request()->has('q') || request()->has('status'))
                                for the applied filters
                                @endif
                                @endif
                            </div>
                        </div>

                        <div
                            class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
                            <div class="dt-paging paging_simple_numbers">
                                {!! $data->links('pagination::bootstrap-4') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
</div>
