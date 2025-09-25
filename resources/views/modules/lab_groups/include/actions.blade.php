  <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
  @if(checkPersonPermission('detail_lab_groups_55'))
<a title="detail" target="_blank"
   href="{{ route($page . '.detail', $lab_group->id) }}">
   <button
     class="btn btn-icon btn-active-light-primary w-30px h-30px"
     data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
      <i class="ki-duotone ki-document fs-3 text-info">
         <span class="path1"></span>
         <span class="path2"></span>
     </i>
   </button>
</a>
@endif

<a title="QrCode" href="{{ route($page . '.lab_code', $lab_group->id) }}" target="_blank">
   <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
       <i class="ki-duotone ki-scan-barcode fs-3 text-primary">
           <span class="path1"></span>
           <span class="path2"></span>
       </i>
   </button>
</a>

 @if(checkPersonPermission('update_lab_groups_55'))
<a title="Edit" href="{{ route($page . '.edit', $lab_group->id) }}">
   <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
       <i class="ki-duotone ki-pencil fs-3 text-primary">
           <span class="path1"></span>
           <span class="path2"></span>
       </i>
   </button>
</a>
@endif

 @if(checkPersonPermission('delete_lab_groups_55'))
<a title="Delete" href="{{ route($page . '.delete', $lab_group->id) }}"
   data-id="{{ $lab_group->id }}"
   class="btn btn-icon btn-active-light-primary w-30px h-30px delete-lab_groups"
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
