<!--begin::Card-->
<div class="card card-flush">
    <!--begin::Card body-->
    <div class="pt-0 card-body">
        <!--begin::Table container-->
        <div class="table-responsive">
            <div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                <div class="table-responsive">
                    <table id="kt_project_users_table" class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable">
                        <thead class="text-gray-500 fs-7 text-uppercase">
                            <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                            @forelse ($data as $notification)
                            <tr>
                                <td>{{ $notification->name }}</td>
                                <td>{{ $notification->notification_slug }}</td>
                                <td>{{ $notification->category->name ?? '-' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($notification->description, 50) }}</td>
                                <td>
                                    @if($notification->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        {{-- @if(checkPersonPermission('update_notifications')) --}}
                                        <a href="{{ route($page . '.edit', $notification->id) }}" title="Edit">
                                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                                <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </button>
                                        </a>
                                        {{-- @endif --}}

                                        {{-- @if(checkPersonPermission('delete_notifications')) --}}
                                        <a href="{{ route($page . '.delete', ['id' => $notification->id]) }}"
                                            data-id="{{ $notification->id }}"
                                            class="btn btn-icon btn-active-light-primary w-30px h-30px delete-{{ $page }}"
                                            title="Delete">
                                            <i class="ki-duotone ki-trash fs-3 text-danger">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                        </a>
                                        {{-- @endif --}}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No notifications found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination & summary -->
                <div class="row">
                    <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
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
                    <div class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
                        <div class="dt-paging paging_simple_numbers">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--end::Table container-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->
