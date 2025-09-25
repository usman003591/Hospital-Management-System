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
                                    tabindex="0" style="min-width: 90px">
                                    <span class="dt-column-title">Receipt number</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                          <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                style="min-width: 150px">
                                <span class="dt-column-title">Hospital Receipt#</span><span class="dt-column-order"></span>
                               </th>
                               <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                style="min-width: 150px">
                                <span class="dt-column-title">Patient Name</span><span class="dt-column-order"></span>
                               </th>
                               <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                               colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                               style="min-width: 150px">
                               <span class="dt-column-title">Net Amount</span><span class="dt-column-order"></span>
                           </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                    colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                    style="min-width: 150px">
                                    <span class="dt-column-title">Date Issued</span><span class="dt-column-order"></span>
                                </th>


                                {{-- <th class="min-w-90px dt-type-numeric dt-orderable-asc dt-orderable-desc"
                                    data-dt-column="2" rowspan="1" colspan="1" aria-label="Amount: Activate to sort"
                                    tabindex="0"><span class="dt-column-title" role="button">Role</span><span
                                        class="dt-column-order"></span></th> --}}
                                <th class="min-w-90px dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1"
                                    colspan="1" aria-label="Status: Activate to sort" tabindex="0"><span
                                        class="dt-column-title" role="button">Status</span><span
                                        class="dt-column-order"></span></th>
                                <th class="text-center min-w-50px dt-orderable-none" data-dt-column="4" rowspan="1"
                                    colspan="1" aria-label="Details"><span class="dt-column-title">Actions</span><span
                                        class="dt-column-order"></span></th>
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
                                            <a href=""
                                                class="mb-1 text-gray-800 text-hover-primary">@isset($d->receipt_number)
                                                {{$d->receipt_number}}
                                                @endisset </a>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::User-->
                                </td>
                                <td>
                                @isset($d->invoice_sequence)
                                                {{$d->invoice_sequence}}
                                                @endisset
                                </td>
                                <td>{{$d->name_of_patient}} </td>
                                <td>{{$d->net_amount}}</td>
                                <td data-order="2024-06-20T00:00:00+05:00">{{getBasicDateTimeFormat($d->date_issued)}}</td>
                                {{-- <td class="dt-type-numeric">@isset($d->role_name)
                                    {{$d->role_name}}
                                    @endisset
                                </td> --}}
                                <td>
                                    @if($d->payment_status)
                                    {!! $d->payment_status !!}
                                    @endif
                                </td>
                                <td class="d-flex justify-content-center align-items-center">
                                    @if(checkPersonPermission('download_invoices_section_8'))
                                    <a title="Download Receipt" target="_blank"
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

                                    @if(checkPersonPermission('update_invoices_section_8'))
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

                                    @if(checkPersonPermission('delete_invoices_section_8'))
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
                                          {{-- {{ $data->links() }} --}}
                            {{ $data->links('vendor.pagination.custom_pagination') }}
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
