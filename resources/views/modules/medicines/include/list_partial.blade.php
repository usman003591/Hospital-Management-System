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
                                    tabindex="0" style="min-width: 7rem"><span class="dt-column-title">Name</span><span
                                        class="dt-column-order"></span></th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                    colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                    style="min-width: 15rem"><span class="dt-column-title">Created at</span><span
                                        class="dt-column-order"></span>
                                </th>
                                {{-- <th class="min-w-90px dt-type-numeric dt-orderable-asc dt-orderable-desc"
                                    data-dt-column="2" rowspan="1" colspan="1" aria-label="Amount: Activate to sort"
                                    tabindex="0"><span class="dt-column-title" role="button">Role</span><span
                                        class="dt-column-order"></span></th> --}}
                                <th class="min-w-90px dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                                    aria-label="Status: Activate to sort" tabindex="0"><span class="dt-column-title">Status</span><span
                                        class="dt-column-order"></span></th>
                                <th class="min-w-90px dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                                    aria-label="Status: Activate to sort" tabindex="0"><span class="dt-column-title">inHouse Status</span><span
                                        class="dt-column-order"></span></th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                                    aria-label="Status: Activate to sort" tabindex="0" style="min-width: 7rem"><span
                                        class="dt-column-title">Verification Status</span><span class="dt-column-order"></span></th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                                    aria-label="Status: Activate to sort" tabindex="0" style="min-width: 7rem"><span class="dt-column-title">Is
                                        Manual</span><span class="dt-column-order"></span></th>
                                <th class="text-center min-w-50px dt-orderable-none" data-dt-column="4" rowspan="1" colspan="1" aria-label="Details">
                                    <span class="dt-column-title">Actions</span><span class="dt-column-order"></span></th>
                            </tr>
                        </thead>
                        <tbody class="fs-6">
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
                                            <a href="" class="mb-1 text-gray-800 text-hover-primary">@isset($d->name)
                                                {{$d->name}}
                                                @endisset </a>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::User-->
                                </td>
                                <td data-order="2024-06-20T00:00:00+05:00">{{getBasicDateTimeFormat($d->created_at)}}
                                </td>
                                {{-- <td class="dt-type-numeric">@isset($d->role_name)
                                    {{$d->role_name}}
                                    @endisset
                                </td> --}}
                                <td>
                                    @if($d->status == 1)
                                    <span class="mr-2 badge badge-success font-weight-lighter">Active</span>
                                    @else
                                    <span class="mr-2 badge badge-danger font-weight-lighter">Inactive</span>
                                    @endif
                                </td>
                                <td> {!!getInhouseStatusLable($d->is_in_house)!!}</td>
                                <td>
                                    <select @if($d->verification_status=='approved') class="form-select form-select-solid w-125px bg-light-success
                                        text-success" @endif
                                        @if($d->verification_status=='pending') class="form-select form-select-solid w-125px bg-light-warning
                                        text-warning" @endif
                                        @if($d->verification_status=='rejected') class="form-select form-select-solid w-125px bg-light-danger
                                        text-danger" @endif data-control="select2" data-dropdown-css-class="w-200px" id="verificationStatusSelect"
                                        data-placeholder="Select verification status" data-hide-search="true" data-id="{{ $d->id }}">

                                        <option class="bg-light-success text-success" value="approved" @if($d->verification_status=='approved')
                                            selected @endif > Approved </option>
                                        <option class="bg-light-warning text-warning" value="pending" @if($d->verification_status=='pending') selected
                                            @endif > Pending </option>
                                        <option class="bg-light-danger text-danger" value="rejected" @if($d->verification_status=='rejected') selected
                                            @endif > Rejected </option>

                                    </select>
                                    {{-- {{ ucfirst($d->verification_status) }} --}}
                                </td>
                                <td>
                                    @if($d->is_manual == 1)
                                    {{-- <span class="mr-2 badge badge-success font-weight-lighter"> --}}
                                        Yes
                                        {{-- </span> --}}
                                    @else
                                    {{-- <span class="mr-2 badge badge-danger font-weight-lighter"> --}}
                                        No
                                        {{-- </span> --}}
                                    @endif
                                </td>
                                <td class="d-flex justify-content-center">
                                    @if(checkPersonPermission('update_medicines_24'))
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
                                    @if(checkPersonPermission('delete_medicines_24'))
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
