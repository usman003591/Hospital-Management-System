<td class="text-center">
    <div class="d-flex justify-content-center gap-2">
 @if(checkPersonPermission('download_prescription_slip_prescriptions_section_7'))
<a title="Preview Prescription " target="_blank"
   href="{{ route($page . '.downlaod', $prescription->id) }}">
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

@if(checkPersonPermission('update_prescriptions_section_7'))
<a title="Edit" href="{{ route($page . '.edit', $prescription->id) }}">
    <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
        <i class="ki-duotone ki-pencil fs-3 text-primary">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </button>
</a>
@endif

@if(checkPersonPermission('delete_prescriptions_section_7'))
  <a title="Delete" href="{{route($page.'.delete', ['id' => $prescription->id])}}"
   data-id="{{$prescription->id}}"
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
