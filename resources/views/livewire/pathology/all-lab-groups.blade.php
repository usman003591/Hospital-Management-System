<div class="container">
    <div class="row">
        <div class="col-md-12">
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
                    width: 400px;
                    /* Increased width for search input */
                }
            </style>

            <div class="mb-5 form-group row bg-search">

                <div class="col-lg-6">
                    <input type="text" wire:model.live.debounce.500ms="q" id="q" name="invoice_search" {{--
                        class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary search-input"
                        --}}
                        class="w-100 mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary search-input"
                        placeholder="Search Patient By Name, MR Number, CINIC, Lab Group Number, Or Mobile Number"
                        value="" maxlength="50">
                </div>

                <div class="col-lg-2">
                    <select wire:model.live="hospital_id" class="form-select form-select-solid bg-body-secondary"
                        data-placeholder="Select Hospital" data-allow-clear="false">
                        <option value="">Select All Hospital</option>
                        @foreach ($hospitals as $hospital)
                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <select id="status" wire:model.live="status"
                        class="ajax_call_trigger form-select form-select-solid bg-body-secondary"
                        data-placeholder="Select Status" data-allow-clear="false">
                        <option selected value="2" {{!isset($search['status']) || $search['status']==2}}>Select All
                            Status</option>
                        <option value="pending" {{isset($search['status']) && $search['status']=='pending' }}>Pending
                        </option>
                        <option value="completed" {{isset($search['status']) && $search['status']=='completed' }}>
                            Completed</option>
                        <option value="cancelled" {{isset($search['status']) && $search['status']=='cancelled' }}>
                            Cancelled</option>
                    </select>
                </div>

                <div class="col-lg-2 d-flex justify-content-end align-items-end">
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
                          <div id="" class="table-responsive" style="min-height: 680px; overflow-y: auto;">
                                  <table id="kt_project_users_table" style="width: 100%; border-collapse: collapse;"
                                    class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable"
                                    style="width: 0px;">
                                    <colgroup>
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                    </colgroup>
                                    <thead class="text-gray-500 fs-7 text-uppercase">
                                        <tr role="row"
                                            class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1"
                                                rowspan="1" colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                                style="min-width: 15rem"><span class="dt-column-title">Lab Group
                                                    Number</span><span class="dt-column-order"></span>
                                            </th>
                                            <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                                data-dt-column="0" rowspan="1" colspan="1"
                                                aria-label="Manager: Activate to sort" tabindex="0"
                                                style="min-width: 18rem"><span class="dt-column-title ms-5">Patient
                                                    Name</span><span class="dt-column-order"></span></th>

                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3"
                                                rowspan="1" colspan="1" aria-label="Status: Activate to sort"
                                                tabindex="0" style="min-width: 15rem"><span
                                                    class="dt-column-title">Status</span><span
                                                    class="dt-column-order"></span></th>

                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1"
                                                rowspan="1" colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                                style="min-width: 7rem"><span class="dt-column-title">MR
                                                    Number</span><span class="dt-column-order"></span>
                                            </th>
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1"
                                                rowspan="1" colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                                style="min-width: 15rem"><span class="dt-column-title">Created
                                                    at</span><span class="dt-column-order"></span>
                                            </th>
                                            {{-- <th
                                                class="min-w-90px dt-type-numeric dt-orderable-asc dt-orderable-desc"
                                                data-dt-column="2" rowspan="1" colspan="1"
                                                aria-label="Amount: Activate to sort" tabindex="0"><span
                                                    class="dt-column-title" role="button">Role</span><span
                                                    class="dt-column-order"></span></th> --}}

                                            <th class="text-center dt-orderable-none" data-dt-column="4" rowspan="1"
                                                colspan="1" aria-label="Details" style="min-width: 7rem"><span
                                                    class="dt-column-title">Actions</span><span
                                                    class="dt-column-order"></span>
                                            </th>
                                            <!-- <th class="min-w-50px dt-orderable-none" data-dt-column="4" rowspan="1" colspan="1" aria-label="Details">
                                        <span class="dt-column-title">Actions</span>
                                        <span class="dt-column-order"></span>
                                    </th> -->




                                        </tr>
                                    </thead>
                                    <tbody class="fs-6">
                                        @if (count($data) > 0)
                                        @foreach ($data as $d)
                                        <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">

                                            <td class="mb-1 text-gray-800 text-hover-primary">
                                                @isset($d->lab_group_number)
                                                {{$d->lab_group_number}}
                                                @endisset
                                            </td>
                                            </a>
                                            <td>
                                                <!--begin::User-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Wrapper-->
                                                    <div class="me-5 position-relative">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            @if($d->image)
                                                            <img src="{{ AvatarImagePath($d->image) }}" alt="Pic">
                                                            @endif
                                                        </div>
                                                        <!--end::Avatar-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <a class="mb-1 text-gray-800 text-hover-primary">@isset($d->patient_name)
                                                            {{$d->patient_name}}
                                                            @endisset </a>
                                                        <div class="text-gray-500 fw-semibold fs-6">@isset($d->email)
                                                            {{$d->email}}
                                                            @endisset</div>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::User-->
                                            </td>
                                            {{-- @if(checkPersonPermission('change_status_lab_groups_55')) --}}
                                            <td>
                                                <select name="change_status"
                                                    style="width: 160px; height: 34px;  padding:5px; border: 1px solid #ccc;"
                                                    data-id="{{(integer)$d->id}}" id="change_status"
                                                    class="change-status-{{$page}} {!! getLabGroupStatus($d->status) !!}">
                                                    <option value="pending" class="btn btn-info" @if ( $d->status ===
                                                        'pending')
                                                        selected @endif> Pending </option>
                                                    <option value="completed" class="btn btn-success" @if ( $d->status
                                                        ===
                                                        'completed') selected @endif> Completed </option>
                                                    <option value="cancelled" class="btn btn-danger" @if ( $d->status
                                                        ===
                                                        'cancelled') selected @endif> Cancelled </option>
                                                </select>
                                            </td>
                                            {{-- @endif --}}

                                            <td class="mb-1 text-gray-800 text-hover-primary">
                                                @isset($d->patient_mr_number)
                                                {{$d->patient_mr_number}}
                                                @endisset
                                            </td>
                                            <td data-order="2024-06-20T00:00:00+05:00">
                                                {{getBasicDateTimeFormat($d->created_at)}}
                                            </td>
                                            {{-- <td class="dt-type-numeric">@isset($d->role_name)
                                                {{$d->role_name}}
                                                @endisset
                                            </td> --}}

                                            <td class="align-middle text-end">
                                                <div class="dropdown">
                                                    <!-- Icon Button as Dropdown Toggle -->
                                                    <button class="btn btn-sm btn-icon btn-light-secondary"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ki-duotone ki-category fs-2 text-info">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i>
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                                                        <li>
                                                            <a href="{{route($page. '.download_patient_receipt', $d->id)}}" target="_blank"
                                                                class="dropdown-item d-flex align-items-end"><i
                                                                    class="ki-duotone ki-file-down fs-3 text-warning">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                    <span class="path4"></span>
                                                                    <span class="path5"></span>
                                                                </i>
                                                                &nbsp; Receipt
                                                            </a>
                                                        </li>

                                                        @if($d->allGood)
                                                        <li>
                                                            <a href="{{route($page . '.download_result', $d->id)}}" target="_blank"
                                                                class="dropdown-item d-flex align-items-end"><i
                                                                    class="ki-duotone ki-tablet-text-up fs-3 text-success">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                    <span class="path4"></span>
                                                                    <span class="path5"></span>
                                                                </i>
                                                                &nbsp; Download Result
                                                            </a>
                                                        </li>
                                                        @endif

                                                        <li>
                                                            <a href="{{ route($page . '.lab_code', $d->id) }}"
                                                                class="dropdown-item d-flex align-items-end"><i
                                                                    class="ki-duotone ki-scan-barcode fs-3 text-info">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                    <span class="path4"></span>
                                                                    <span class="path5"></span>
                                                                </i>
                                                                &nbsp; Barcode
                                                            </a>
                                                        </li>

                                                        @if(checkPersonPermission('detail_lab_groups_55'))
                                                        <li>
                                                            <a href="{{ route($page . '.lab_tests', $d->id) }}"
                                                                class="dropdown-item d-flex align-items-end"><i
                                                                    class="ki-duotone ki-document fs-3 text-info">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                    <span class="path4"></span>
                                                                    <span class="path5"></span>
                                                                </i>
                                                                &nbsp; Detail
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if(checkPersonPermission('update_lab_groups_55'))
                                                        <li>
                                                            <a href="{{ route($page . '.edit', $d->id) }}"
                                                                class="dropdown-item d-flex align-items-end"><i
                                                                    class="ki-duotone ki-pencil fs-3 text-primary">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                    <span class="path4"></span>
                                                                    <span class="path5"></span>
                                                                </i>
                                                                &nbsp; Update
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if(checkPersonPermission('delete_lab_groups_55'))
                                                        <li>
                                                            <a href="{{ route($page . '.delete', $d->id) }}"
                                                                data-id="{{$d->id}}"
                                                                title="Delete"
                                                                class="dropdown-item d-flex align-items-end delete-{{$page}}"><i
                                                                    class="ki-duotone ki-trash fs-3 text-danger ">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                    <span class="path4"></span>
                                                                    <span class="path5"></span>
                                                                </i>
                                                                &nbsp; Delete
                                                            </a>
                                                        </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        @endforeach
                                        @endif

                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>

                            </div>
                            <div id="" class="row">
                                <div id=""
                                    class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                    <div>
                                        @if($data->total() > 0)
                                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total()
                                        }} records
                                        @else
                                        No records found
                                        @if(request()->has('q') || request()->has('status'))
                                        for the applied filters
                                        @endif
                                        @endif
                                    </div>
                                </div>
                                <div id=""
                                    class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
                                    <div class="dt-paging paging_simple_numbers">
                                        {{ $data->links() }}
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
