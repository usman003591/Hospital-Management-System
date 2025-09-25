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
            </style>

            <div class="mb-5 form-group row bg-search">
                <div class="col-lg-5">
                    <input type="text" wire:model.live.debounce.500ms="q" id="q" name="user_name"
                        class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
                        placeholder="Search Patient by Name, CNIC or MR Number. Mobile Number" value="" maxlength="50">
                </div>


                <div class="col-lg-3">
                    <select wire:model.live="status" class="form-select form-select-solid bg-body-secondary"
                        data-placeholder="Select Status" data-allow-clear="false">
                        <option value="">Select All Status</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                    </select>
                </div>

                <div class="col-lg-4 mobile-space">
                    <div class="d-flex justify-content-end">
                        <button type="button" wire:click="resetFilters" id="normal_reset" class="px-6 btn btn-sm me-2">Reset</button>
                    </div>
                </div>
            </div>

             <div class="card card-flush">
                <!--begin::Card body-->
                <div class="pt-0 card-body">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                            <div id="" class="table-responsive">
                                <table id="kt_project_users_table"
                                    class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable"
                                    style="width: 0px;">
                                    <colgroup>
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                    </colgroup>
                                    <thead class="text-gray-500 fs-7 text-uppercase">
                                        <tr role="row" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                            <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                                data-dt-column="0" rowspan="1" colspan="1"
                                                aria-label="Patient Name" tabindex="0"
                                                style="min-width: 12rem"><span class="dt-column-title">Patient Name</span><span class="dt-column-order"></span></th>
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1"
                                                rowspan="1" colspan="1" aria-label="Doctor Name" tabindex="0"
                                                style="min-width: 12rem"><span class="dt-column-title">Doctor Name</span><span class="dt-column-order"></span></th>
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="2"
                                                rowspan="1" colspan="1" aria-label="Counter/Token" tabindex="0"
                                                style="min-width: 10rem"><span class="dt-column-title">Counter/Token</span><span class="dt-column-order"></span></th>
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3"
                                                rowspan="1" colspan="1" aria-label="Hospital" tabindex="0"
                                                style="min-width: 12rem"><span class="dt-column-title">Hospital</span><span class="dt-column-order"></span></th>
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="4"
                                                rowspan="1" colspan="1" aria-label="Date" tabindex="0"
                                                style="min-width: 10rem"><span class="dt-column-title">Date</span><span class="dt-column-order"></span></th>
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="5"
                                                rowspan="1" colspan="1" aria-label="Status" tabindex="0"
                                                style="min-width: 7rem"><span class="dt-column-title">Status</span><span class="dt-column-order"></span></th>
                                            <th class="text-center dt-orderable-none" data-dt-column="6" rowspan="1"
                                                colspan="1" aria-label="Actions" style="min-width: 7rem"><span class="dt-column-title">Actions</span><span class="dt-column-order"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6">
                                         @if($data->count() > 0)
                                            @foreach ($data as $d)
                                               <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <a href="{{ route('patients.detail_page', $d->patient_id) }}" class="mb-1 text-gray-800 text-hover-primary">{{ $d->patient_name }}</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <a href="" class="mb-1 text-gray-800 text-hover-primary">{{ $d->doctor_name }}</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $d->counter_name }} / {{ $d->token_number }}</td>
                                                    <td>{{ $d->hospital_name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y h:i A') }}</td>
                                                    <td>
                                                        @if($d->status == 'paid')
                                                            <span class="mr-2 badge badge-success font-weight-lighter">Paid</span>
                                                        @else
                                                            <span class="mr-2 badge badge-danger font-weight-lighter">Unpaid</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="pt-1 d-flex justify-content-center align-items-center">
                                                            @if(checkPersonPermission('download_prescription_slip_prescriptions_section_7'))
                                                            <a title="Preview Prescription" target="_blank"
                                                                href="{{route($page.'.downlaod',$d->id)}}"><button
                                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px"
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
                                                            @if(checkPersonPermission('update_prescriptions_section_7'))
                                                            <a title="Edit" href="{{route($page.'.edit',$d->id)}}"><button
                                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                                    <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </button>
                                                            </a>
                                                            @endif
                                                            @if(checkPersonPermission('delete_prescriptions_section_7'))
                                                            <a title="Delete" href="{{route($page.'.delete', ['id' => $d->id])}}"
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
                                                                </button>
                                                            </a>
                                                            @endif

                                                        </div>


                                                    </td>
                                                </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="7">
                                                    No records found
                                                    @if(request()->has('q') || request()->has('status') || request()->has('hospital')) for the applied filters @endif</td>
                                            </tr>
                                            @endif
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                            <div id="" class="row">
                                <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                    <div>
                                        @if($data->total() > 0)
                                            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
                                        @else
                                            No records found
                                            @if(request()->has('q') || request()->has('status') || request()->has('hospital'))
                                                for the applied filters
                                            @endif
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

            <!--begin::Card-->
          {{--
        </div>
    </div> --}}
{{-- </div> --}}
