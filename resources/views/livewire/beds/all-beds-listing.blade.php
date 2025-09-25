<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="mb-5 form-group row bg-search">
                <div class="col-lg-4">
                    <input type="text" id="q" name="user_name"
                        wire:model.live.debounce.500ms="q"
                        class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
                        placeholder="Search" value="{{ $q ?? '' }}" maxlength="50">
                </div>

                <div class="col-lg-3">
                    <select wire:model.live="room"
                        class="form-select form-select-solid bg-body-secondary" 
                        id="room" data-placeholder="Select Room"  data-allow-clear="true">
                        <option value="" {{ !$room ? 'selected' : '' }}>All Rooms</option>
                        @foreach ($rooms as $id => $name)
                            <option value="{{ $id }}" {{ $room == $id ? 'selected' : '' }}>{{ $name }}</option>
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
                                <th style="min-width: 12rem"><span class="dt-column-title">Beds</span></th>
                                <th style="min-width: 12rem"><span class="dt-column-title">Rooms</span></th>
                                <th style="min-width: 8rem"><span class="dt-column-title">Status</span></th>
                                <th class="text-center min-w-30px"><span class="dt-column-title">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="fs-6">
                            @if (count($data) > 0)
                            @foreach ($data as $d)
                            <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <a href="" class="mb-1 text-gray-800 text-hover-primary">
                                                   {{ $d->bed_number ?? '' }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td> {{ $d->room->room_number ?? '' }}</td>
                                    <td>
                                        @if($d->status == 1)
                                        <span class="mr-2 badge badge-success font-weight-lighter">Active</span>
                                        @else
                                        <span class="mr-2 badge badge-danger font-weight-lighter">Inactive</span>
                                        @endif
                                    </td>
                                <td class="align-middle text-end">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @if(checkPersonPermission('update_beds_36'))
                                        <a title="Edit" href="{{route($page.'.edit',$d->id)}}">
                                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                                <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </button>
                                        </a>
                                        @endif
                                        
                                        @if(checkPersonPermission('delete_beds_36'))
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
                        <div class="row">
                            <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                <div>
                                    @if($data->total() > 0)
                                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
                                    @else
                                        No records found @if($q || $room || $status) for the applied filters @endif
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
