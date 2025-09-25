<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('include.messages')
            <style>
                #normal_reset {
                    background-color: #e9f3ff;
                    color: #1b84ff;
                }
                #normal_reset:hover {
                    background-color: #1b84ff;
                    color: white;
                }
                .search-input {
                    width: 400px; /* Increased width for search input */
                }
            </style>

            {{-- <div class="mb-5 form-group row bg-search">
                <div class="col-lg-4">
                    <input type="text" wire:model.live.debounce.500ms="q" id="q" name="patient_search"
                        class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary search-input"
                        placeholder="Search Patient by Name, MR Number or CNIC" value="" maxlength="50">
                </div>

                <div class="col-lg-2">
                    <select wire:model.live="status" class="form-select form-select-solid bg-body-secondary">
                        <option value="">Select All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="col-lg-2 mobile-space">
                    <div class="d-flex justify-content-end">
                        <button type="button" wire:click="resetFilters" id="normal_reset" class="px-6 btn btn-sm me-2">Reset</button>
                    </div>
                </div>
            </div> --}}
                <div class="mb-5 form-group row bg-search">
                    {{-- <div class="col-lg-6">
                        <input type="text" wire:model.live.debounce.500ms="q" id="q" name="patient_search"
                            class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary search-input"
                            placeholder="Search Patient by Name, MR Number or CNIC or Mobile Number" value="" maxlength="50">
                    </div> --}}
                    <div class="col-lg-7">
                    <input type="text" wire:model.live.debounce.500ms="q" id="q" name="q"
                        class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
                        placeholder="Search Patient By Name, MR Number, CNIC Or Mobile Number" value="" maxlength="50">
                    </div>

                    <div class="col-lg-3">
                        <select wire:model.live="status" class="form-select form-select-solid bg-body-secondary">
                            <option value="">Select All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="col-lg-2 d-flex justify-content-end align-items-start">
                        <button type="button" wire:click="resetFilters" id="normal_reset" class="px-6 btn btn-sm me-2">
                            Reset
                        </button>
                    </div>
                </div>


            <!--begin::Card-->
            <div class="card card-flush">
                <!--begin::Card body-->
                <div class="pt-0 card-body">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                            <div class="table-responsive">
                                <table id="kt_project_users_table"
                                    class="table align-middle table-row-bordered table-row-dashed gy-4 dataTable"
                                    style="width: 100%;">
                                    <thead class="text-gray-500 fs-7 text-uppercase">
                                        <tr role="row"
                                            class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                            <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                                data-dt-column="0" rowspan="1" colspan="1"
                                                aria-label="Patient: Activate to sort" tabindex="0"
                                                style="min-width: 17rem"><span
                                                    class="dt-column-title ms-5">Patients</span><span
                                                    class="dt-column-order"></span></th>

                                         <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1"
                                                rowspan="1" colspan="1"
                                                aria-label="MR Number: Activate to sort" tabindex="0"
                                                style="min-width: 10rem"><span class="dt-column-title"
                                                    role="button">MR Number</span><span class="dt-column-order"></span></th>

                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="2"
                                                rowspan="1" colspan="1" aria-label="Created At: Activate to sort" tabindex="0"
                                                style="min-width: 13rem"><span class="dt-column-title"
                                                    role="button">Created At</span><span class="dt-column-order"></span></th>
                                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3"
                                                rowspan="1" colspan="1" aria-label="Status: Activate to sort"
                                                tabindex="0" style="min-width: 7rem"><span class="dt-column-title"
                                                    role="button">Status</span><span class="dt-column-order"></span></th>
                                            <th class="text-center dt-orderable-none" data-dt-column="4" rowspan="1"
                                                colspan="1" aria-label="Actions" style="min-width: 5rem"><span
                                                    class="dt-column-title">Actions</span><span
                                                    class="dt-column-order"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6">
                                        @if (count($data) > 0)
                                        @foreach ($data as $d)
                                        <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-5 position-relative">
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            @if($d->patient_image)
                                                            <img src="{{ AvatarImagePath($d->patient_image) }}"
                                                                alt="Pic">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <a href="{{ route('patients.detail_page', $d->id) }}"
                                                            class="mb-1 text-gray-800 text-hover-primary">{{ ucwords(strtolower($d->name_of_patient ?? 'Unnamed Patient')) }}</a>
                                                        {{-- <div class="text-gray-500 fw-semibold fs-6">@isset($d->patient_mr_number)
                                                            {{$d->patient_mr_number}}
                                                            @endisset</div> --}}

                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @isset($d->patient_mr_number)
                                                {{ $d->patient_mr_number }}
                                                @endisset
                                            </td>
                                            <td data-order="{{ $d->created_at->toIso8601String() }}">
                                                {{ getBasicDateTimeFormat($d->created_at) }}
                                            </td>
                                            <td>
                                                @if($d->status == 1)
                                                <span class="mr-2 badge badge-success font-weight-lighter">Active</span>
                                                @else
                                                <span
                                                    class="mr-2 badge badge-danger font-weight-lighter">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">

                                                    @if(checkPersonPermission('detail_patients_section_6'))
                                                        <a title="Detail" href="{{ route('patients.detail_page', $d->id) }}"><button
                                                            class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                            <i class="ki-duotone ki-document fs-3 text-info">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </button>
                                                        </a>
                                                    @endif

                                                    @if(checkPersonPermission('download_visiting_card_patients_section_6'))
                                                        <a title="Download Visiting Card" target="_blank"
                                                        href="{{route($page.'.downlaod',$d->id)}}">
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

                                                    @if(checkPersonPermission('update_patients_section_6'))
                                                    <a title="Edit" href="{{ route('patients.edit', $d->id) }}">
                                                        <button
                                                            class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                                            <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </button>
                                                    </a>
                                                    @endif
                                                    @if(checkPersonPermission('delete_patients_section_6'))
                                                    <a title="Delete"
                                                        href="{{ route('patients.delete', ['id' => $d->id]) }}"
                                                        data-id="{{ $d->id }}"
                                                        class="btn btn-icon btn-active-light-primary w-30px h-30px delete-patients">
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
                                        @else
                                        <tr>
                                            <td colspan="4" class="text-center"><small class="text-danger">No records found</small></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                    <div>
                                        @if($data->total() > 0)
                                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
                                            @if(request()->has('q') || request()->has('status'))
                                            for the applied filters
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
                                    <div class="dt-paging paging_simple_numbers">
                                        {{-- {!! $data->links() !!} --}}
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
            <!--end::Card-->
        </div>
    </div>
</div>
