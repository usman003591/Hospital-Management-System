
 @if (checkPersonPermission('update_appointments_40'))
<a title="Edit" href="{{ route($page . '.edit', $appointment->id) }}">
   <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
       <i class="ki-duotone ki-pencil fs-3 text-primary">
           <span class="path1"></span>
           <span class="path2"></span>
       </i>
   </button>
</a>
@endif

 @if (checkPersonPermission('delete_appointments_40'))
<a title="Delete" href="{{ route($page . '.delete', $appointment->id) }}"
   data-id="{{ $appointment->id }}"
   class="btn btn-icon btn-active-light-primary w-30px h-30px delete-appointments"
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