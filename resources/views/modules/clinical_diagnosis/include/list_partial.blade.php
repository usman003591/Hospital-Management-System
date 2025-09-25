<!--begin::Card-->

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
                        </colgroup>
                        <thead class="text-gray-500 fs-7 text-uppercase">
                            <tr role="row" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                    data-dt-column="0" rowspan="1" colspan="1" aria-label="Manager: Activate to sort"
                                    tabindex="0" style="min-width: 12rem"><span class="dt-column-title">Patient Name
                                    </span><span class="dt-column-order"></span></th>
                                <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                    data-dt-column="0" rowspan="1" colspan="1" aria-label="Manager: Activate to sort"
                                    tabindex="0" style="min-width: 12rem"><span class="dt-column-title">Doctor Name
                                    </span><span class="dt-column-order"></span></th>
                                    <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                    data-dt-column="0" rowspan="1" colspan="1" aria-label="Manager: Activate to sort"
                                    tabindex="0" style="min-width: 7rem"><span class="dt-column-title">Counter/Token
                                    </span><span class="dt-column-order"></span></th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                    colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                    style="min-width: 7rem">
                                    <span class="dt-column-title">Hospital</span><span class="dt-column-order"></span>
                                </th>
                                <th class="dt-type-numeric dt-orderable-asc dt-orderable-desc" data-dt-column="2"
                                    rowspan="1" colspan="1" aria-label="Amount: Activate to sort" tabindex="0"
                                    style="min-width: 7rem"><span class="dt-column-title" role="button">MR
                                        Number</span><span class="dt-column-order"></span></th>
                                <th class="dt-type-numeric dt-orderable-asc dt-orderable-desc" data-dt-column="2"
                                    rowspan="1" colspan="1" aria-label="Amount: Activate to sort" tabindex="0"
                                    style="min-width: 7rem"><span class="dt-column-title" role="button">Status</span><span class="dt-column-order"></span></th>
                                {{-- <th class="dt-type-numeric dt-orderable-asc dt-orderable-desc" data-dt-column="2"
                                    rowspan="1" colspan="1" aria-label="Amount: Activate to sort" tabindex="0"
                                    style="min-width: 15rem"><span class="dt-column-title" role="button">Created at</span><span class="dt-column-order"></span></th> --}}
                                {{-- <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                    colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                    style="min-width: 13rem"><span class="dt-column-title">Created at</span><span
                                        class="dt-column-order"></span></th> --}}
                                {{--
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1"
                                    colspan="1" aria-label="Status: Activate to sort" tabindex="0"
                                    style="min-width: 7rem"><span class="dt-column-title">Parent</span><span
                                        class="dt-column-order"></span></th> --}}
                                <th class="text-center min-w-40px dt-orderable-none" data-dt-column="4" rowspan="1"
                                    colspan="1" aria-label="Details"><span class="dt-column-title">Actions</span><span
                                        class="dt-column-order"></span></th>
                            </tr>
                        </thead>
                        <tbody class="fs-6">
                            @isset($data)
                            @if (count($data) > 0)
                            @foreach ($data as $d)
                            <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                <td>
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Wrapper-->

                                        <!--end::Wrapper-->
                                        <!--begin::Info-->
                                        <div class="d-flex flex-column justify-content-center">
                                            <a href=""
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
                                <td> {{$d->hospital_name}} </td>
                                <td>
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Wrapper-->

                                        <!--end::Wrapper-->
                                        <!--begin::Info-->
                                        <div class="d-flex flex-column justify-content-center">
                                            <p
                                                class="mb-1 text-gray-800 text-hover-primary">@isset($d->patient_mr_number)
                                                {{$d->patient_mr_number}}
                                                @endisset </p>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::User-->
                                </td>
                                <td class="mb-1 text-gray-800">
                                    @isset($d->status)
                                        {{ ucfirst($d->status) }}
                                    @endisset
                                </td>

                                {{-- <td data-order="2024-06-20T00:00:00+05:00">
                                    {{getDateInStandardFormat(Carbon\Carbon::parse($d->created_at))}}</td> --}}
                                {{-- <td data-order="2024-06-20T00:00:00+05:00">
                                    {{getDateInStandardFormat(Carbon\Carbon::parse($d->created_at))}}</td> --}}
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
                                    <div class="d-flex justify-content-center align-items-center">

                                      @if (checkPersonPermission('view_section_pathology_lab_section_54'))
                                    <a title="investigations" href="{{route($page.'.investigations_form', ['id' => $d->id])}}"
                                        data-id="{{$d->id}}"
                                        class="btn btn-icon btn-active-light-success w-30px h-30px investigations-{{$page}}"
                                        data-kt-permissions-table-filter="delete_row">
                                        <i class="ki-duotone ki-test-tubes fs-3 text-dark">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </a>
                                    @endif

                                    @if(checkPersonPermission('vitals_all_49'))
                                      <a title="Vitals" href="{{route($page.'.vitals_form', ['id' => $d->id])}}"
                                            data-id="{{$d->id}}"
                                            class="btn btn-icon btn-active-light-success w-30px h-30px preview-{{$page}}"
                                            data-kt-permissions-table-filter="delete_row">
                                            <i class="ki-duotone ki-pulse fs-3 text-dark">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                        </a>
                                        @endif

                                        @if(checkPersonPermission('preview_all_49'))
                                        <a title="Preview" href="{{route($page.'.preview', ['id' => $d->id])}}"
                                            data-id="{{$d->id}}"
                                            class="btn btn-icon btn-active-light-success w-30px h-30px preview-{{$page}}"
                                            data-kt-permissions-table-filter="delete_row">
                                            <i class="ki-duotone ki-eye fs-3 text-success">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                        </a>
                                        @endif

                                        @if(checkPersonPermission('download_all_49'))
                                        <a title="OPD Slip" target="_blank"
                                        href="{{route($page.'.download',$d->id)}}"><button
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
                                       @if(checkPersonPermission('detail_all_49'))
                                        <a title="Detail" href="{{route($page.'.detail_form',$d->id)}}"><button
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                <i class="ki-duotone ki-document fs-3 text-info">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </button>
                                        </a>
                                        @endif
                                        @if(checkPersonPermission('update_all_49'))
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


                                        @if(checkPersonPermission('delete_all_49'))
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
                                        </a>
                                        @endif
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
                            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
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
