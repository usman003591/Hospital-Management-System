<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-5 form-group row bg-search">
                <div class="col-lg-4">
                    <input type="text" wire:model.live.debounce.500ms="q" id="q" name="q"
                           class="mb-3 form-control form-control-solid mb-lg-0 bg-body-secondary"
                           placeholder="Search Investigation" value="" maxlength="50">
                </div>

                <div class="col-lg-3">
                    <select wire:model.live="type_id" id="type_id"
                            class="form-select form-select-solid bg-body-secondary">
                        @foreach($investigationTypes as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                    <select wire:model.live="verification_status" id="verification_status"
                            class="form-select form-select-solid bg-body-secondary">
                        <option value="">All Verification Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
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
                                        data-dt-column="0" rowspan="1" colspan="1" aria-label="Name: Activate to sort"
                                        tabindex="0" style="min-width: 12rem"><span class="dt-column-title">Name</span><span class="dt-column-order"></span></th>
                                        <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                                        aria-label="Type: Activate to sort" tabindex="0" style="min-width: 7rem"><span
                                            class="dt-column-title">Type Name</span><span class="dt-column-order"></span></th>
                                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                        colspan="1" aria-label="Created At: Activate to sort" tabindex="0"
                                        style="min-width: 13rem"><span class="dt-column-title">Created At</span><span
                                            class="dt-column-order"></span></th>

                                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                                        aria-label="Status: Activate to sort" tabindex="0" style="min-width: 7rem"><span
                                            class="dt-column-title">Status</span><span class="dt-column-order"></span></th>
                                    <th class="min-w-90px dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                                        aria-label="In House Status: Activate to sort" tabindex="0"><span class="dt-column-title">In House Status</span><span
                                            class="dt-column-order"></span></th>

                                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                                        aria-label="Verification Status: Activate to sort" tabindex="0" style="min-width: 7rem"><span
                                            class="dt-column-title">Verification Status</span><span class="dt-column-order"></span></th>
                                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                                        aria-label="Is Manual: Activate to sort" tabindex="0" style="min-width: 7rem"><span
                                            class="dt-column-title">Is Manual</span><span class="dt-column-order"></span></th>
                                    <th class="text-center min-w-30px dt-orderable-none" data-dt-column="4" rowspan="1"
                                        colspan="1" aria-label="Actions"><span class="dt-column-title">Actions</span><span
                                            class="dt-column-order"></span></th>
                                </tr>
                            </thead>
                            <tbody class="fs-6">
                                @if (count($data) > 0)
                                    @foreach ($data as $d)
                                        <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <a href="{{route('investigations.show',['id'=>$d->id])}}" class="mb-1 text-gray-800 text-hover-primary">@isset($d->name)
                                                            {{ $d->name }}
                                                        @endisset</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @isset($d->type_id)
                                                    {{ \App\Models\InvestigationType::find($d->type_id)->name ?? 'N/A' }}
                                                @endisset
                                            </td>
                                            <td>{{ getBasicDateTimeFormat($d->created_at) }}</td>

                                            <td>
                                                @if($d->status == 1)
                                                    <span class="mr-2 badge badge-success font-weight-lighter">Active</span>
                                                @else
                                                    <span class="mr-2 badge badge-danger font-weight-lighter">Inactive</span>
                                                @endif
                                            </td>
                                            {{-- <td>{!! getInhouseStatusLabel($d->is_in_house) !!}</td> --}}
                                             <td> {!!getInhouseStatusLable($d->is_in_house)!!}</td>

                                            <td>
                                                <select wire:change="changeStatus({{ $d->id }}, $event.target.value)"
                                                        @if($d->verification_status == 'approved')
                                                            class="form-select form-select-solid w-125px bg-light-success text-success"
                                                        @elseif($d->verification_status == 'pending')
                                                            class="form-select form-select-solid w-125px bg-light-warning text-warning"
                                                        @elseif($d->verification_status == 'rejected')
                                                            class="form-select form-select-solid w-125px bg-light-danger text-danger"
                                                        @endif>
                                                    <option class="bg-light-success text-success" value="approved" {{ $d->verification_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option class="bg-light-warning text-warning" value="pending" {{ $d->verification_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option class="bg-light-danger text-danger" value="rejected" {{ $d->verification_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
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
                                            <td class="align-middle text-end">
                                                <div class="d-flex justify-content-center align-items-center">

                                                    <a title="Details" href="{{ route($page . '.details', ['id' => $d->id]) }}"
                                                        data-id="{{ $d->id }}"
                                                        class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                        data-kt-permissions-table-filter="delete_row">
                                                        <i class="ki-duotone ki-document fs-3 text-info">
                                                                          <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                        <span class="path4"></span>
                                                                        <span class="path5"></span>
                                                                    </i>
                                                    </a>

                                                    @if(checkPersonPermission('update_investigations_26'))
                                                        <a title="Edit" href="{{ route($page . '.edit', $d->id) }}">
                                                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                                <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                    @if(checkPersonPermission('delete_investigations_26'))
                                                        <a title="Delete" href="{{ route($page . '.delete', ['id' => $d->id]) }}"
                                                           data-id="{{ $d->id }}"
                                                           class="btn btn-icon btn-active-light-primary w-30px h-30px delete-{{ $page }}"
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
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center">No records found @if($q || $type_id || $verification_status) for the applied filters @endif</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                <div>
                                    @if($data->total() > 0)
                                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
                                    @else
                                        No records found @if($q || $type_id || $verification_status) for the applied filters @endif
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.options = {
                "progressBar": true,
                "timeOut": "3000"
            };

            window.Livewire.on('show-toast', ({ type, message }) => {
                if (['success', 'info', 'warning', 'error'].includes(type)) {
                    toastr[type](message);
                } else {
                    toastr.info(message);
                }
            });
        });
    </script>
</div>
