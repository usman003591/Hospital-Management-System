<div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
    <div class="table-responsive">
        <!--begin::Table-->
        <div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <div id="" class="table-responsive">
                <table id="kt_project_users_table"
                    class="table align-middle table-row-bordered table-row-dashed gy-4 dataTable" style="width: 0px;">
                    <colgroup>
                        <col style="width: auto;">
                        <col style="width: auto;">
                        <col style="width: auto;">
                        <col style="width: auto;">
                        <col style="width: auto;">
                    </colgroup>
                    <thead class="fs-7 text-uppercase">
                        <tr role="row" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1" colspan="1"
                                aria-label="Date: Activate to sort" tabindex="0" style="min-width: 15rem"><span
                                    class="dt-column-title">Lab Group Number</span><span class="dt-column-order"></span>
                            </th>
                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1" colspan="1"
                                aria-label="Date: Activate to sort" tabindex="0" style="min-width: 15rem"><span
                                    class="dt-column-title">Doctor Name</span><span class="dt-column-order"></span>
                            </th>
                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                                aria-label="Status: Activate to sort" tabindex="0" style="min-width: 12rem"><span
                                    class="dt-column-title">Status</span><span class="dt-column-order"></span></th>

                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1" colspan="1"
                                aria-label="Date: Activate to sort" tabindex="0" style="min-width: 15rem"><span
                                    class="dt-column-title">Created at</span><span class="dt-column-order"></span>
                            </th>

                            <th class="text-center dt-orderable-none" data-dt-column="4" rowspan="1" colspan="1"
                                aria-label="Details" style="min-width: 7rem"><span
                                    class="dt-column-title">Actions</span><span class="dt-column-order"></span>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (count($labGroups) > 0)
                        @foreach ($labGroups as $d)
                        <tr class="text-gray-700 border-gray-200 fs-7 border-bottom">

                            <td class="mb-1 text-hover-primary">@isset($d->lab_group_number)
                                {{$d->lab_group_number}}
                                @endisset
                            </td>
                            <td class="mb-1 text-hover-primary">@isset($d->doctor_name)
                                {{$d->doctor_name}}
                                @endisset
                            </td>

                            {{-- @if(checkPersonPermission('change_status_lab_groups_55')) --}}
                            <td>
                                @if ( $d->status === 'pending')
                                <span class="badge badge-warning p-2">Pending</span>
                                @endif
                                @if ( $d->status === 'completed')
                                <span class="badge badge-success p-2">Completed</span>
                                @endif
                                @if ( $d->status === 'cancelled')
                                <span class="badge badge-danger p-2">Cancelled</span>
                                @endif

                            </td>
                            {{-- @endif --}}


                            <td data-order="2024-06-20T00:00:00+05:00">{{getBasicDateTimeFormat($d->created_at)}}</td>


                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    @if(checkPersonPermission('detail_lab_groups_55'))
                                    @if($d->allGood == true)
                                    <a title="Preview Result"
                                        href="{{route($page . '.download_result', $d->id)}}" target="_blank"><button
                                            class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                            <i class="ki-duotone ki-eye fs-3 text-success">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                        </button>
                                    </a>
                                    @endif

                                    <a title="Detail" href="{{route($page.'.patient_lab_tests',$d->id)}}" target="_blank"><button
                                            class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                            <i class="ki-duotone ki-document fs-3 text-info">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </button>
                                    </a>
                                    @endif

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

        </div>
        <!--end::Table-->
    </div>
    <div class="col-sm-12 col-md-7 d-flex align-items-end justify-content-end justify-content-md-end w-100 mt-3">
            {!! $labGroups->links('pagination::bootstrap-4') !!}
    </div>
</div>
