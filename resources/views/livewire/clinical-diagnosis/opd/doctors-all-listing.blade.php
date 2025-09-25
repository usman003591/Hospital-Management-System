<div class="container" contenteditable="false" wire:poll.10s.keep-alive>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-5 form-group row bg-search">

                <div class="col-lg-5">
                       <input type="text" wire:model.live.debounce.500ms="q" id="q" name="user_name"
                        class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
                        placeholder="Search Patient By Name, CNIC, MR Number, Mobile Number" value="" maxlength="50">
                </div>

                <div class="col-lg-5">
                    <select wire:model.live="status" class="form-select form-select-solid bg-body-secondary"  data-placeholder="Select Status" data-allow-clear="false">
                        <option value="">Select All Status</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        {{-- <option value="cancelled">Cancelled</option> --}}
                        <option value="referred">Referred</option>
                    </select>
                </div>

                <div class="col-lg-2 d-flex justify-content-end align-items-end">
                    <button type="button" wire:click="resetFilters" id="normal_reset" class="px-6 btn btn-sm btn-primary me-2">
                        Reset
                    </button>
                </div>
            </div>


            <div class="card card-flush">
                <!--begin::Card body-->
                <div class="pt-0 card-body">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                            <div id="" class="table-responsive" style="min-height: 680px; overflow-y: auto;">
                                <table id="kt_project_users_table" style="width: 100%; border-collapse: collapse;"
                                    class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable">
                                    <colgroup>
                                        <col  style="width: auto;">
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                        <col style="width: auto;">
                                    </colgroup>
                                    <thead class="text-gray-500 fs-7">
                                        <tr role="row"
                                            class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                            <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom" style="min-width: 10rem">Patient Name</th>
                                            <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                                data-dt-column="0" rowspan="1" colspan="1"
                                                aria-label="Manager: Activate to sort" tabindex="0"
                                                style="min-width: 10rem"><span class="dt-column-title">Doctor Name
                                                </span><span class="dt-column-order"></span></th>
                                            <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                                data-dt-column="0" rowspan="1" colspan="1"
                                                aria-label="Manager: Activate to sort" tabindex="0"
                                                style="min-width: 4rem"><span class="dt-column-title">Counter/Token
                                                </span><span class="dt-column-order"></span></th>
                                            {{-- <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1"
                                                rowspan="1" colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                                style="min-width: 7rem">
                                                <span class="dt-column-title">Hospital</span><span
                                                    class="dt-column-order"></span>
                                            </th> --}}
                                            <th class="dt-type-numeric dt-orderable-asc dt-orderable-desc"
                                                data-dt-column="2" rowspan="1" colspan="1"
                                                aria-label="Amount: Activate to sort" tabindex="0"
                                                style="min-width: 7rem"><span class="dt-column-title" role="button">MR
                                                    Number</span><span class="dt-column-order"></span></th>
                                            <th class="dt-type-numeric dt-orderable-asc dt-orderable-desc"
                                                data-dt-column="2" rowspan="1" colspan="1"
                                                aria-label="Amount: Activate to sort" tabindex="0"
                                                style="min-width: 5rem"><span class="dt-column-title"
                                                    role="button">Status</span><span class="dt-column-order"></span>
                                            </th>
                                            <th class="dt-type-numeric dt-orderable-asc dt-orderable-desc"
                                                data-dt-column="2" rowspan="1" colspan="1"
                                                aria-label="Amount: Activate to sort" tabindex="0"
                                                style="min-width: 5rem"
                                            ><span class="dt-column-title"
                                                    role="button">Visited At</span><span class="dt-column-order"></span>
                                            </th>
                                            {{-- <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1"
                                                rowspan="1" colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                                style="min-width: 13rem"><span class="dt-column-title">Created
                                                    at</span><span class="dt-column-order"></span></th> --}}
                                            {{--
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3"
                                                rowspan="1" colspan="1" aria-label="Status: Activate to sort"
                                                tabindex="0" style="min-width: 7rem"><span
                                                    class="dt-column-title">Parent</span><span
                                                    class="dt-column-order"></span></th> --}}
                                            <th class="text-center dt-orderable-none" style="min-width: 5rem" data-dt-column="4"
                                                rowspan="1" colspan="1" aria-label="Details"><span
                                                    class="dt-column-title">Actions</span><span
                                                    class="dt-column-order"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6">
                                        @isset($data)
                                        @if (count($data) > 0)
                                        @foreach ($data as $d)
                                        <tr wire:key="item-{{ $d->id }}" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                            <td>
                                                <!--begin::User-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Wrapper-->

                                                    <!--end::Wrapper-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-column justify-content-center">
                                                        {{-- <a href="" --}}
                                                         <a href="{{ route('patients.detail_page', $d->patient_id) }}"
                                                            class="mb-1 text-gray-800 text-hover-primary">@isset($d->patient_name)
                                                            {{$d->patient_name}}
                                                            @endisset </a>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::User-->
                                            </td>
                                            <td>
                                                <!--begin::User-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Wrapper-->

                                                    <!--end::Wrapper-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <a href=""
                                                            class="mb-1 text-gray-800 text-hover-primary">@isset($d->doctor_name)
                                                            {{$d->doctor_name}}
                                                            @endisset </a>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::User-->
                                            </td>
                                            <td> {{$d->counter_name}} / {{$d->count}} </td>
                                            {{-- <td> {{$d->hospital_name}} </td> --}}
                                            <td>
                                                <!--begin::User-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Wrapper-->

                                                    <!--end::Wrapper-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="mb-1 text-gray-800 text-hover-primary">
                                                            @isset($d->patient_mr_number)
                                                            {{$d->patient_mr_number}}
                                                            @endisset </p>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::User-->
                                            </td>
                                            <td class="mb-1 text-gray-800">
                                                @isset($d->status)
                                                {!!getOPDStatusValuesBasedOnStatus($d->status) !!}
                                                @endisset
                                            </td>

                                            <td data-order="2024-06-20T00:00:00+05:00">
                                                {{getDateInStandardFormat(Carbon\Carbon::parse($d->created_at))}}</td>

                                            {{-- <td data-order="2024-06-20T00:00:00+05:00">
                                                {{getDateInStandardFormat(Carbon\Carbon::parse($d->created_at))}}</td>
                                            --}}
                                            {{-- <td class="dt-type-numeric">@isset($d->role_name)
                                                {{$d->role_name}}
                                                @endisset
                                            </td> --}}
                                            {{-- <td>
                                                @if($d->parent_id !== 0 && $d->parent_id !== null)
                                                {{$d->parent_name}}
                                                @endif
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

                                                    <!-- Dropdown Menu -->
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                                                        @if(checkPersonPermission('laboratory_doctor_opd_50'))
                                                        <li>
                                                            <a href="{{ route($page . '.investigations_form', ['id' => $d->id]) }}"
                                                                class="dropdown-item d-flex align-items-end"><i class="ki-duotone ki-test-tubes fs-3 text-info">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                        <span class="path4"></span>
                                                                        <span class="path5"></span>
                                                                    </i>
                                                               &nbsp; Lab Investigations
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if (checkPersonPermission('vitals_doctor_opd_50'))
                                                        <li>
                                                            <a href="{{ route($page . '.vitals_form', ['id' => $d->id]) }}"
                                                                class="dropdown-item d-flex align-items-end"><i class="ki-duotone ki-pulse fs-3 text-dark">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                    <span class="path4"></span>
                                                                    <span class="path5"></span>
                                                                </i>
                                                               &nbsp; Patient Vitals
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if (checkPersonPermission('preview_doctor_opd_50'))
                                                        <li>
                                                            <a href="{{ route($page . '.preview', ['id' => $d->id]) }}"
                                                                class="dropdown-item d-flex align-items-end"> <i class="ki-duotone ki-eye fs-3 text-success">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                        <span class="path4"></span>
                                                                        <span class="path5"></span>
                                                                    </i>
                                                                 &nbsp;Preview
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if (checkPersonPermission('download_doctor_opd_50'))
                                                        <li>
                                                            <a href="{{ route($page . '.download', ['id' => $d->id]) }}"
                                                                target="_blank"
                                                                class="dropdown-item d-flex align-items-center"> <i class="ki-duotone ki-folder-down fs-3 text-warning">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                        <span class="path4"></span>
                                                                        <span class="path5"></span>
                                                                    </i>
                                                               &nbsp; Download Slip
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if (checkPersonPermission('detail_doctor_opd_50'))
                                                        <li>
                                                            <a href="{{ route($page . '.detail_form', ['id' => $d->id]) }}"
                                                                class="dropdown-item d-flex align-items-center">   <i class="ki-duotone ki-document fs-3 text-info">
                                                                          <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                        <span class="path4"></span>
                                                                        <span class="path5"></span>
                                                                    </i>
                                                              &nbsp;  Detail
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if (checkPersonPermission('update_doctor_opd_50'))
                                                        <li>
                                                            <a href="{{ route($page . '.edit', ['id' => $d->id]) }}"
                                                                class="dropdown-item d-flex align-items-center">   <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                                         <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                        <span class="path4"></span>
                                                                        <span class="path5"></span>
                                                                    </i>
                                                                &nbsp;  Edit
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if (checkPersonPermission('delete_doctor_opd_50'))
                                                        <li>
                                                            <a href="{{ route($page . '.delete', ['id' => $d->id]) }}"
                                                                class="dropdown-item d-flex align-items-center delete-{{ $page }}"
                                                                data-id="{{ $d->id }}"><i class="ki-duotone ki-trash fs-3 text-danger">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                        <span class="path4"></span>
                                                                        <span class="path5"></span>
                                                                    </i>
                                                                &nbsp;Delete
                                                            </a>
                                                        </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        @endforeach
                                        @endif
                                        @endisset
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


        </div>
    </div>
</div>
<script>
    function reinitializeMetronicComponents() {
        // Reinitialize KTMenu
        if (typeof KTMenu !== 'undefined') {
            document.querySelectorAll('[data-kt-menu="true"]').forEach(el => {
                const instance = KTMenu.getInstance(el);
                if (instance) instance.destroy();
            });
            KTMenu.createInstances();
        }

        // Reinitialize Bootstrap Tooltips (if you're using them)
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Add any other plugin reinitializations here (e.g. flatpickr, select2, etc.)
    }

    // Livewire hook to refresh JS after render
    Livewire.hook('message.processed', () => {
        reinitializeMetronicComponents();
    });

    // Run on page load too
    document.addEventListener("DOMContentLoaded", reinitializeMetronicComponents);
</script>
