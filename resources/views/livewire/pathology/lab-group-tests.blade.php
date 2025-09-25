<div>
    <div class="flex-wrap d-flex flex-stack pb-7">
        <!--begin::Title-->
        <div class="flex-wrap my-1 d-flex align-items-center">
            <h3 class="my-1 fw-bold me-5">Tests (@isset($count)
                {{$count}}
                @endisset)</h3>
            <!--begin::Search-->
            <!--end::Search-->
        </div>
        <!--end::Title-->
        <!--begin::Controls-->
        <div class="flex-wrap my-1 d-flex">
            <!--begin::Tab nav-->
            <!--end::Tab nav-->
            @if(checkPersonPermission('add_lab_test_lab_group_detail_56'))
            <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                data-bs-target="#kt_modal_add_lab_tests">
                <i class="ki-duotone ki-plus-square fs-3">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>Add Lab Test</button>
            @endif
        </div>
        <!--end::Controls-->
    </div>

    <!--begin::Table-->
    <div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
        <div id="" class="table-responsive">
            <table id="kt_project_users_table"
                class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable"
                style="width: 100%;">
                <colgroup>
                    <col data-dt-column="0" style="width: 0px;">
                    <col data-dt-column="1" style="width: 0px;">
                    <col data-dt-column="2" style="width: 0px;">
                    <col data-dt-column="3" style="width: 0px;">
                    <col data-dt-column="4" style="width: 0px;">
                </colgroup>
                <thead class="text-gray-500 fs-7 text-uppercase">
                    <tr>
                        <th class="min-w-250px dt-orderable-asc dt-orderable-desc" data-dt-column="0" rowspan="1"
                            colspan="1" aria-label="Manager: Activate to sort" tabindex="0"><span
                                class="dt-column-title" role="button">Investigation Name</span><span
                                class="dt-column-order"></span></th>
                        <th class="min-w-200px dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                            colspan="1" aria-label="Date: Activate to sort" tabindex="0"><span class="dt-column-title"
                                role="button">Lab Group Number</span><span class="dt-column-order"></span></th>
                        <th class="min-w-200px dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                            colspan="1" aria-label="Date: Activate to sort" tabindex="0"><span class="dt-column-title"
                                role="button">Report Date</span><span class="dt-column-order"></span></th>
                        <th class="min-w-150px dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                            colspan="1" aria-label="Date: Activate to sort" tabindex="0"><span class="dt-column-title"
                                role="button">Received Date</span><span class="dt-column-order"></span></th>
                        <th class="min-w-200px dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1"
                            colspan="1" aria-label="Status: Activate to sort" tabindex="0"><span class="dt-column-title"
                                role="button">Status</span><span class="dt-column-order"></span></th>
                        <th class="min-w-150px text-end dt-orderable-none" data-dt-column="4" rowspan="1" colspan="1"
                            aria-label="Details"><span class="dt-column-title">Actions</span><span
                                class="dt-column-order"></span></th>
                    </tr>
                </thead>
                <tbody class="fs-6">

                    @isset($lab_group_tests)
                    @if (count($lab_group_tests) > 0)
                    @foreach ($lab_group_tests as $d)
                    <tr>
                        <td>
                            <!--begin::User-->
                            <div class="d-flex align-items-center">
                                <!--begin::Wrapper-->
                                <div class="me-5 position-relative">
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Info-->
                                <div class="d-flex flex-column justify-content-center">
                                    <a href="" class="mb-1 text-gray-800 text-hover-primary">@isset($d->name)
                                        {{$d->name}}
                                        @endisset</a>
                                    {{-- <div class="text-gray-500 fw-semibold fs-6">smith@kpmg.com</div> --}}
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                        </td>
                        <td>@isset($d->lab_group_number)
                            {{$d->lab_group_number}}
                            @endisset</td>
                        <td data-order="2025-08-19T00:00:00+05:00">@isset($d->report_date) {{
                            getBasicDateTimeFormat($d->report_date) }} @endisset</td>
                        <td data-order="2025-08-19T00:00:00+05:00">@isset($d->received_date) {{
                            getBasicDateTimeFormat($d->received_date) }} @endisset</td>

                        {{-- @if(checkPersonPermission('change_lab_test_status_lab_group_detail_56')) --}}
                        <td>
                            <select name="change_status"
                                style="width: 160px; height: 34px;  padding:5px; border: 1px solid #ccc;"
                                data-id="{{(integer)$d->id}}" id="change_status"
                                class="change-status-lab_tests {!! getLabGroupTestStatus($d->status) !!}">
                                <option value="pending" class="btn btn-info" @if ( $d->status === 'pending')
                                    selected @endif> Pending </option>
                                <option value="collected" class="btn btn-success" @if ( $d->status ===
                                    'collected') selected @endif> Collected </option>
                                <option value="in_process" class="btn btn-primary" @if ( $d->status ===
                                    'in_process') selected @endif> Cancelled </option>
                                <option value="completed" class="btn btn-warning" @if ( $d->status ===
                                    'completed') selected @endif> Completed </option>
                            </select>
                        </td>
                        {{-- @endif --}}

                        <td class="text-end">
                            {{-- <a
                                href="{{route('lab_groups.lab_tests.details',['id' => $d->lab_group_id,'test_id' => $d->id])}}"
                                class="btn btn-danger btn-sm">Add Data</a> --}}

                            {{-- @if(checkPersonPermission('add_lab_test_data_lab_group_detail_56'))
                            <a title="Add test result data"
                                href="{{route('lab_groups.lab_tests.details',['id' => $d->lab_group_id,'test_id' => $d->id])}}"><button
                                    class="btn btn-icon btn-active-light-primary w-40px h-40px" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update_permission">
                                    <i class="ki-duotone ki-shield-tick fs-3 text-success">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </button>
                            </a>
                            @endif --}}
                             @if(checkPersonPermission('add_lab_test_data_lab_group_detail_56'))
                             <a 
                                title="{{ !empty($d->value) || !empty($d->generated_report_pdf_path) ? 'Edit test result data' : 'Add test result data' }}"
                                href="{{ route('lab_groups.lab_tests.details',['id' => $d->lab_group_id,'test_id' => $d->id]) }}">
                                
                                <button class="btn btn-icon btn-active-light-primary w-40px h-40px" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_update_permission">

                                    @if(!empty($d->value) || !empty($d->generated_report_pdf_path))
                                        {{-- Edit icon (pencil) --}}
                                        <i class="ki-duotone ki-pencil fs-3 text-warning">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    @else
                                        {{-- Add icon (plus) --}}
                                        <i class="ki-duotone ki-plus fs-3 text-success">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    @endif

                                </button>
                                </a>
                             @endif


                            @if(checkPersonPermission('download_lab_test_lab_group_detail_56'))
                            @if ($d->generated_report_pdf_path)
                            <a title="Download Lab Report" target="_blank"
                                href="{{route('lab_tests.download',$d->id)}}"><button
                                    class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update_permission">
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
                            @endif

                            @if(checkPersonPermission('delete_lab_test_lab_group_detail_56'))
                            <a title="Delete" href="{{route('lab_tests.delete',$d->id)}}" data-id="{{$d->id}}"
                                class="btn btn-icon btn-active-light-primary w-30px h-30px delete_lab_tests">
                                <i class="ki-duotone ki-trash fs-3 text-danger">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                            </a>
                            @endif

                            {{-- <a href="#" class="btn btn-success btn-sm">Download</a> --}}
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    @endisset

                </tbody>
                <tfoot></tfoot>

            </table>
        </div>


        <div id="" class="row">
            <div id=""
                class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                <div>
                    @if($lab_group_tests->total() > 0)
                    Showing {{ $lab_group_tests->firstItem() }} to {{ $lab_group_tests->lastItem() }} of {{
                    $lab_group_tests->total() }} records
                    @else
                    No records found
                    @if(request()->has('q') || request()->has('status'))
                    for the applied filters
                    @endif
                    @endif
                </div>
            </div>
            <div id="" class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
                <div class="dt-paging paging_simple_numbers">

                    {!! $lab_group_tests->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
</div>
