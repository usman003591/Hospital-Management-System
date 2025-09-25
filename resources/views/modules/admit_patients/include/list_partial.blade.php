<!--begin::Card-->
<div class="card card-flush">
    <!--begin::Card body-->
    <div class="pt-0 card-body">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                <div id="" class="table-responsive">
                    <table id="kt_project_users_table" class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable">
                        <colgroup>
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                        </colgroup> 
                        <thead class="text-gray-500 fs-7 text-uppercase">
                            <tr role="row" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                <th style="min-width: 12rem"><span class="dt-column-title">Ward</span></th>
                                <th style="min-width: 12rem"><span class="dt-column-title">Room</span></th>
                                <th style="min-width: 12rem"><span class="dt-column-title">Bed</span></th>
                                <th style="min-width: 12rem"><span class="dt-column-title">Department</span></th>
                                <th style="min-width: 13rem"><span class="dt-column-title">Admission Date</span></th>
                                <th style="min-width: 8rem"><span class="dt-column-title">Status</span></th>
                                <th class="text-center min-w-30px"><span class="dt-column-title">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="fs-6">
                            @if (count($data) > 0)
                            @foreach ($data as $d)
                            <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column justify-content-center">
                                            <a href="" class="mb-1 text-gray-800 text-hover-primary">
                                                {{ $d->ward->ward_name ?? '' }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $d->room->room_number ?? '' }}</td>
                                <td>{{ $d->bed->bed_number ?? '' }}</td>
                                <td>{{ $d->department->name ?? '' }}</td>
                                <td>{{getBasicDateTimeFormat($d->admission_date)}}</td>
                                <td>
                                    @if($d->status == 1)
                                    <span class="mr-2 badge badge-success font-weight-lighter">Active</span>
                                    @else
                                    <span class="mr-2 badge badge-danger font-weight-lighter">Inactive</span>
                                    @endif
                                </td>
                                <td class="align-middle text-end">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @if(checkPersonPermission('update_admit_patients_18'))
                                        <a title="Edit" href="{{route($page.'.edit',$d->id)}}">
                                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                                <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </button>
                                        </a>
                                        @endif

                                        @if(checkPersonPermission('delete_admit_patients_18'))
                                        <a title="Delete" href="{{route($page.'.delete', ['id' => $d->id])}}"
                                            data-id="{{$d->id}}"
                                            class="btn btn-icon btn-active-light-primary w-30px h-30px delete-{{$page}}">
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
                        </tbody>
                    </table>
                </div>
                <div id="" class="row">
                    <div id="" class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                        <div>
                            @if($data->total() > 0)
                            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
                            @else
                            No records found
                            @if(request()->has('q') || request()->has('status') || request()->has('department') || request()->has('ward'))
                            for the applied filters
                            @endif
                            @endif
                        </div>
                    </div>
                    <div id="" class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
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
