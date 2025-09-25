<td class="text-center">
    <div class="gap-2 d-flex justify-content-center">

    @if (checkPersonPermission('view_section_pathology_lab_section_54'))
                <a title="investigations" href="{{route($page.'.investigations_form', ['id' => $diagnosis->id])}}"
                    data-id="{{$diagnosis->id}}"
                    class="btn btn-icon btn-active-light-success w-30px h-30px investigations-{{$page}}"
                    data-kt-permissions-table-filter="delete_row">
                    <i class="ki-duotone ki-test-tubes fs-3 text-dark">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                </a>
                @endif

        @if (checkPersonPermission('history_all_49'))
        <a title="investigations" href="{{route($page.'.investigations_form', ['id' => $diagnosis->id])}}"
            data-id="{{$diagnosis->id}}"
            class="btn btn-icon btn-active-light-success w-30px h-30px investigations-{{$page}}"
            data-kt-permissions-table-filter="delete_row">
            <i class="ki-duotone ki-test-tubes fs-3 text-dark">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
                <span class="path5"></span>
            </i>
        </a>
        @endif

        @if(checkPersonPermission('vitals_all_49'))
        <a title="Vitals" href="{{route($page.'.vitals_form', ['id' => $diagnosis->id])}}" data-id="{{$diagnosis->id}}"
            class="btn btn-icon btn-active-light-success w-30px h-30px preview-{{$page}}"
            data-kt-permissions-table-filter="delete_row">
            <i class="ki-duotone ki-pulse fs-3 text-dark">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
                <span class="path5"></span>
            </i>
        </a>
        @endif

        @if(checkPersonPermission('preview_all_49'))
        <a title="Preview" href="{{route($page.'.preview', ['id' => $diagnosis->id])}}" data-id="{{$diagnosis->id}}"
            class="btn btn-icon btn-active-light-success w-30px h-30px preview-{{$page}}"
            data-kt-permissions-table-filter="delete_row">
            <i class="ki-duotone ki-eye fs-3 text-success">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
                <span class="path5"></span>
            </i>
        </a>
        @endif

        @if(checkPersonPermission('download_all_49'))
        <a title="OPD Slip" target="_blank" href="{{route($page.'.download',$diagnosis->id)}}"><button
                class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="modal"
                data-bs-target="#kt_modal_update_permission">
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

        @if(checkPersonPermission('detail_all_49'))
        <a title="Detail" href="{{route($page.'.detail_form',$diagnosis->id)}}"><button
                class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="modal"
                data-bs-target="#kt_modal_update_permission">
                <i class="ki-duotone ki-document fs-3 text-info">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </button>
        </a>
        @endif

        @if(checkPersonPermission('update_all_49'))
        <a title="Edit" href="{{ route($page . '.edit', $diagnosis->id) }}">
            <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
                <i class="ki-duotone ki-pencil fs-3 text-primary">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </button>
        </a>
        @endif

        @if(checkPersonPermission('delete_all_49'))
        <a title="Delete" href="{{route($page.'.delete', ['id' => $diagnosis->id])}}" data-id="{{$diagnosis->id}}"
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
