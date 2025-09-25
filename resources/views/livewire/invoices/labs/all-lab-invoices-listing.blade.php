<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('include.messages')
            <style>
                #normal_reset {
                    background-color: #e9f3ff;
                    color: #1b84ff;
                }
                #normal_reset:hover {
                    background-color: #1b84ff;
                    color: white;
                }
                .search-input {
                    width: 400px; /* Increased width for search input */
                }
            </style>

        <div class="mb-5 form-group row bg-search">

            <div class="col-lg-6">
                    <input type="text" wire:model.live.debounce.500ms="q" id="q" name="invoice_search"
                        class="w-100 mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary search-input"
                        placeholder="Search by Receipt Number, Patient Name, Mobile Number" maxlength="50">
            </div>
            <div class="col-lg-4">
                <select wire:model.live="hospital_id" class="form-select form-select-solid bg-body-secondary">
                    <option value="">Select All Hospital</option>
                    @foreach ($hospitals as $hospital)
                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 d-flex justify-content-end align-items-start">
                <button type="button" wire:click="resetFilters" id="normal_reset" class="px-6 btn btn-sm me-2">
                    Reset
                </button>
            </div>
        </div>

            <!--begin::Card-->
            <div class="card card-flush">
                <!--begin::Card body-->
                <div class="pt-0 card-body">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                            <div class="table-responsive">
                                <table id="kt_project_users_table"
                                    class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable"
                                    style="width: 100%;">
                                    <thead class="text-gray-500 fs-7 text-uppercase">
                                        <tr role="row"
                                            class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="0"
                                                rowspan="1" colspan="1"
                                                aria-label="Receipt Number: Activate to sort" tabindex="0"
                                                style="min-width: 10rem"><span class="dt-column-title"
                                                    role="button">Receipt Number</span><span class="dt-column-order"></span></th>
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1"
                                                rowspan="1" colspan="1"
                                                aria-label="Hospital Receipt: Activate to sort" tabindex="0"
                                                style="min-width: 10rem"><span class="dt-column-title"
                                                    role="button">Hospital Receipt</span><span class="dt-column-order"></span></th>
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="2"
                                                rowspan="1" colspan="1" aria-label="Patient Name: Activate to sort" tabindex="0"
                                                style="min-width: 15rem"><span class="dt-column-title"
                                                    role="button">Patient Name</span><span class="dt-column-order"></span></th>

                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="5"
                                                rowspan="1" colspan="1" aria-label="Net Amount: Activate to sort" tabindex="0"
                                                style="min-width: 10rem"><span class="dt-column-title"
                                                    role="button">Net Amount</span><span class="dt-column-order"></span></th>
                                             <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="4"
                                                rowspan="1" colspan="1" aria-label="Date Issued: Activate to sort" tabindex="0"
                                                style="min-width: 12rem"><span class="dt-column-title"
                                                    role="button">Date Issued</span><span class="dt-column-order"></span></th>
                                            <th class="text-center dt-orderable-none" data-dt-column="7" rowspan="1"
                                                colspan="1" aria-label="Actions" style="min-width: 15rem"><span
                                                    class="dt-column-title">Actions</span><span
                                                    class="dt-column-order"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6">
                                        @if (count($data) > 0)
                                        @foreach ($data as $d)
                                        <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                            <td>{{ $d->receipt_number ?? 'N/A' }}</td>

                                             <td>
                                                @isset($d->invoice_sequence)
                                                                {{$d->invoice_sequence}}
                                                                @endisset
                                            </td>
                                            <td>{{ $d->patient->name_of_patient ?? 'Unnamed Patient' }}</td>

                                            {{-- <td>{{ number_format($d->net_amount, 2) ?? '0.00' }}</td> --}}
                                            <td>{{$d->net_amount}}</td>

                                            {{-- <td>{{ getBasicDateTimeFormat($d->date_issued) }}</td> --}}
                                            <td data-order="2024-06-20T00:00:00+05:00">{{getBasicDateTimeFormat($d->date_issued)}}</td>
                                            {{-- <td>
                                                @if($d->paymentStatus)
                                                    @if($d->paymentStatus->name === 'Paid')
                                                        <span class="mr-2 badge badge-success font-weight-lighter">Paid</span>
                                                    @elseif($d->paymentStatus->name === 'Unpaid')
                                                        <span class="mr-2 badge badge-warning font-weight-lighter">Unpaid</span>
                                                    @else
                                                        <span class="mr-2 badge badge-danger font-weight-lighter">Rejected</span>
                                                    @endif
                                                @else
                                                    <span class="mr-2 badge badge-danger font-weight-lighter">Unknown</span>
                                                @endif
                                            </td> --}}
                                            <td class="d-flex justify-content-center align-items-center">

                                               @if (checkPersonPermission('download_lab_invoices_60'))
                                                  <a target="_blank" title="Download Receipt" href="{{route('lab_groups.download_patient_receipt', $d->lab_group_id)}}">
                                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                        data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                        <i class="ki-duotone ki-folder-down fs-3 text-warning">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i>
                                                    </button>
                                                </a>
                                                @endif

                                                @if (checkPersonPermission('update_lab_invoices_60'))
                                                {{-- <a title="Edit" href="{{route($page.'.edit',$d->id)}}"><button
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                    <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                                </a> --}}
                                                @endif


                                                @if (checkPersonPermission('delete_lab_invoices_60'))
                                                {{-- <a title="Delete" href="{{route($page.'.delete', ['id' => $d->id])}}"
                                                    data-id="{{$d->id}}"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px delete-{{$page}}"
                                                    data-kt-permissions-table-filter="delete_row">
                                                    <i class="ki-duotone ki-trash fs-3 text-danger">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </a> --}}
                                                @endif

                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="8" class="text-center">No records found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                    <div>
                                        @if($data->total() > 0)
                                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
                                        @else
                                        No records found
                                        @if(request()->has('q') || request()->has('hospital_id'))
                                        for the applied filters
                                        @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
                                    <div class="dt-paging paging_simple_numbers">
                                        {{-- {{ $data->links() }} --}}
                                        {!! $data->links('pagination::bootstrap-4') !!}

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
</div>
