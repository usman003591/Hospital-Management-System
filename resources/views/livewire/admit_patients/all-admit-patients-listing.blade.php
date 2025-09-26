<div class="container">
    <style>
        #normal_reset {
            background-color: #e9f3ff;
            color: #1b84ff;
        }

        #normal_reset:hover {
            background-color: #1b84ff;
            color: white;
        }

    </style>
    <div class="row">
        <div class="col-md-12">

            <div class="mb-5 form-group row bg-search">
                <div class="col-lg-4">
                    <input type="text" wire:model.live.debounce.500ms="q" id="q" name="q"
                        class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
                        placeholder="Search by Ward Name or Room Number or Bed Number" value="" maxlength="50">
                </div>

                <div class="col-lg-2">
                    <select wire:model.live="department" id="department"
                        class="form-select form-select-solid bg-body-secondary" data-placeholder="Select Department"
                        data-allow-clear="true">
                        <option value="">Select Department</option>
                        @foreach ($departments as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <select wire:model.live="ward" id="ward" class="form-select form-select-solid bg-body-secondary"
                        data-placeholder="Select Ward" data-allow-clear="true">
                        <option value="">Select Ward</option>
                        @foreach ($wards as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <select wire:model.live="status" id="status" class="form-select form-select-solid bg-body-secondary"
                        data-placeholder="Select Status" data-allow-clear="true">
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="col-lg-2 d-flex justify-content-end align-items-start">
                    <button type="button" wire:click="resetFilters" id="normal_reset"
                        class="px-6 btn btn-sm">Reset</button>
                </div>
            </div>

            <div class="card card-flush">
                <div class="pt-0 card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-bordered table-row-dashed gy-4">
                            <thead class="text-gray-500 fs-7 text-uppercase">
                                <tr role="row" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                    <th style="min-width: 12rem"><span class="dt-column-title">Ward</span></th>
                                    <th style="min-width: 12rem"><span class="dt-column-title">Room</span></th>
                                    <th style="min-width: 12rem"><span class="dt-column-title">Bed</span></th>
                                    <th style="min-width: 12rem"><span class="dt-column-title">Department</span></th>
                                    <th style="min-width: 13rem"><span class="dt-column-title">Admission Date</span>
                                    </th>
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
                                @else
                                <tr>
                                    <td colspan="7" class="text-center"><small class="text-danger">No records
                                            found</small></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="row">
                            <div
                                class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                <div>
                                    @if($data->total() > 0)
                                    Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }}
                                    records
                                    @if(request()->has('q') || request()->has('department') ||
                                    request()->has('ward') || request()->has('status')) for the applied filters @endif
                                    @endif
                                </div>
                            </div>
                            <div
                                class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
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
