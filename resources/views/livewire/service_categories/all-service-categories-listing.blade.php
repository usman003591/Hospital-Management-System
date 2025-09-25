<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="mb-5 form-group row bg-search">
                <div class="col-lg-4">
                    <input type="text" wire:model.live.debounce.500ms="q" id="q" name="q"
                        class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
                        placeholder="Search" value="" maxlength="50">
                </div>

                <div class="col-lg-3">
                    <select wire:model.live="parent_id" id="parent_id" class="form-select form-select-solid bg-body-secondary"
                        data-placeholder="Filter by Parent" data-allow-clear="true">
                        <option value="">All Parents</option>
                        <option value="-1">Parent categories only</option>
                        @foreach ($parents as $id => $service_name)
                            <option value="{{ $id }}">{{ $service_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3">
                    <select wire:model.live="status" id="status" class="form-select form-select-solid bg-body-secondary"
                        data-placeholder="Select Status" data-allow-clear="true">
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-lg-2 d-flex justify-content-end">
                    <button type="button" wire:click="resetFilters" class="btn btn-sm btn-light-primary">Reset</button>
                </div>
            </div>
            

            <div class="card card-flush">
                <div class="pt-0 card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable">
                            <thead class="text-gray-500 fs-7 text-uppercase">
                            <tr role="row" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                    data-dt-column="0" rowspan="1" colspan="1" aria-label="Manager: Activate to sort"
                                    tabindex="0" style="min-width: 15rem"><span class="dt-column-title">Service
                                        Category</span><span class="dt-column-order"></span></th>
                                                  <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1"
                                    colspan="1" aria-label="Status: Activate to sort" tabindex="0"
                                    style="min-width: 8rem"><span class="dt-column-title">Hospital</span><span
                                        class="dt-column-order"></span></th>
                                        <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                        colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                        style="min-width: 12rem"><span class="dt-column-title">Code</span><span
                                            class="dt-column-order"></span></th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                    colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                    style="min-width: 12rem"><span class="dt-column-title">Default amount</span><span
                                        class="dt-column-order"></span></th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                    colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                    style="min-width: 15rem"><span class="dt-column-title">Created at</span><span
                                        class="dt-column-order"></span></th>
                                {{-- <th class="min-w-90px dt-type-numeric dt-orderable-asc dt-orderable-desc"
                                    data-dt-column="2" rowspan="1" colspan="1" aria-label="Amount: Activate to sort"
                                    tabindex="0"><span class="dt-column-title" role="button">Role</span><span
                                        class="dt-column-order"></span></th> --}}
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1"
                                    colspan="1" aria-label="Status: Activate to sort" tabindex="0"
                                    style="min-width: 8rem"><span class="dt-column-title">Parent</span><span
                                        class="dt-column-order"></span></th>
                                
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1"
                                    colspan="1" aria-label="Status: Activate to sort" tabindex="0"
                                    style="min-width: 7rem"><span class="dt-column-title">Status</span><span
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
                                                class="mb-1 text-gray-800 text-hover-primary">@isset($d->service_name)
                                                {{$d->service_name}}
                                                @endisset </a>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::User-->
                                </td>
                                <td>  {{$d->hospital_name}}</td>

                                <td>
                                    @isset($d->category_code)
                                        {{$d->category_code}}
                                        @endisset
                                </td>
                                <td>
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Wrapper-->

                                        <!--end::Wrapper-->
                                        <!--begin::Info-->
                                        <div class="d-flex flex-column justify-content-center">
                                            <a href=""
                                                class="mb-1 text-gray-800 text-hover-primary">@isset($d->default_amount)
                                                {{$d->default_amount}}
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
                                    @if($d->parent_id !== 0 && $d->parent_id !== null)
                                    {{$d->parent_name}}
                                    @endif
                                </td>
                                <td>
                                    @if($d->status == 1)
                                    <span class="mr-2 badge badge-success font-weight-lighter">Active</span>
                                    @else
                                    <span class="mr-2 badge badge-danger font-weight-lighter">Inactive</span>
                                    @endif
                                </td>
                                <td class="align-middle text-end">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @if(checkPersonPermission('update_service_categories_11'))
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
                                        @if(checkPersonPermission('delete_service_categories_11'))
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

                        </tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                <div>
                                    @if($data->total() > 0)
                                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
                                    @else
                                        No records found @if(request()->has('q') || request()->has('status') || request()->has('parent_id')) for the applied filters @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
                                <div class="dt-paging paging_simple_numbers">
                                    {!! $data->links('pagination::bootstrap-4') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>