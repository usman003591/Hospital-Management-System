<!--begin::Card-->
<div class="card card-flush">
    <!--begin::Card body-->
    <div class="pt-0 card-body">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <div id="kt_deposit_slips_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                <div id="" class="table-responsive">
                    <table id="kt_deposit_slips_table" class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable">
                        <colgroup>
                            <col style="width: auto;">
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
                                <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom" data-dt-column="0">
                                    <span class="dt-column-title">Slip Number</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1">
                                    <span class="dt-column-title">User</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="2">
                                    <span class="dt-column-title">Hospital</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-type-numeric dt-orderable-asc dt-orderable-desc" data-dt-column="3">
                                    <span class="dt-column-title">Amount</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="4">
                                    <span class="dt-column-title">Date Issued</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="5">
                                    <span class="dt-column-title">Counter</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="6">
                                    <span class="dt-column-title">Purpose</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="text-center min-w-50px dt-orderable-none" data-dt-column="7">
                                    <span class="dt-column-title">Actions</span>
                                    <span class="dt-column-order"></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fs-6">
                            @if(count($data) > 0)
                                @foreach($data as $d)
                                <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <a href="" class="mb-1 text-gray-800 text-hover-primary">
                                                    {{ $d->deposit_slip_number }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $d->user_name }}</td>
                                    <td>{{ $d->hospital_name }}</td>
                                    <td class="dt-type-numeric">{{ number_format($d->amount_in_figures, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->date_issued)->format('d M, Y') }}</td>
                                    <td>{{ $d->counter_number }}</td>
                                    <td title="{{ $d->payment_purpose }}">{{ \Str::limit($d->payment_purpose, 25, '...') }}</td>
                                    <td class="d-flex justify-content-center align-items-center">

                                        @if(checkPersonPermission('download_deposit_slips_section_51'))
                                        <a title="Download Slip" target="_blank" href="{{ route($page.'.download', $d->id) }}">
                                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
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

                                         @if(checkPersonPermission('update_deposit_slips_section_51'))
                                        <a title="Edit" href="{{ route($page.'.edit', $d->id) }}">
                                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                                <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </button>
                                        </a>
                                        @endif

                                        @if(checkPersonPermission('delete_deposit_slips_section_51'))
                                        <a title="Delete" href="{{ route($page.'.delete', ['id' => $d->id]) }}"
                                           data-id="{{ $d->id }}"
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
                    <div id="" class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                        <div>
                            @if($data->total() > 0)
                                Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
                            @else
                                No records found
                                @if(request()->has('q'))
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
