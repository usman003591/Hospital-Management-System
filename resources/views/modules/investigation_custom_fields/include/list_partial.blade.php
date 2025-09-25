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
                                    tabindex="0" style="min-width: 12rem"><span class="dt-column-title">investigation Custom Fields
                                    </span><span class="dt-column-order"></span></th>
                                <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                    data-dt-column="0" rowspan="1" colspan="1" aria-label="Manager: Activate to sort"
                                    tabindex="0" style="min-width: 12rem"><span class="dt-column-title">Unit
                                    </span><span class="dt-column-order"></span></th>

                                {{-- <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                    colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                    style="min-width: 13rem"><span class="dt-column-title">Created at</span><span
                                        class="dt-column-order"></span></th> --}}
                                {{--
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1"
                                    colspan="1" aria-label="Status: Activate to sort" tabindex="0"
                                    style="min-width: 7rem"><span class="dt-column-title">Parent</span><span
                                        class="dt-column-order"></span></th> --}}
                                <th class="dt-type-numeric dt-orderable-asc dt-orderable-desc" data-dt-column="2"
                                rowspan="1" colspan="1" aria-label="Amount: Activate to sort" tabindex="0"
                                style="min-width: 15rem"><span class="dt-column-title" role="button">Created at</span><span class="dt-column-order"></span></th>
                                <th class="text-center min-w-30px dt-orderable-none" data-dt-column="4" rowspan="1"
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
                                                class="mb-1 text-gray-800 text-hover-primary">@isset($d->name)
                                                {{$d->name}}
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
                                                class="mb-1 text-gray-800 text-hover-primary">@isset($d->unit)
                                                {{$d->unit}}
                                                @endisset </a>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::User-->
                                </td>


                                <td>{{getDateInStandardFormat ($d->created_at)}} </td>

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
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <!-- Edit Icon -->
                                        @if(checkPersonPermission('update_investigations_custom_fields_59'))
                                        <a title="Edit" href="{{route($page.'.edit',$d->id)}}">
                                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                                <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </button>
                                        </a>
                                        @endif

                                        @if(checkPersonPermission('delete_investigations_custom_fields_59'))
                                        <!-- Delete Icon -->
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
                            @endisset
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>

                </div>

                @isset($data)
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
                @endisset

            </div>
            <!--end::Table-->
        </div>
        <!--end::Table container-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->
