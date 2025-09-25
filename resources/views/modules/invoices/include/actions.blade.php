<td class="text-center">
     <div class="d-flex justify-content-center gap-2">
@if(checkPersonPermission('download_invoices_section_8'))
<a title="Download Receipt" target="_blank"
                                        href="{{route($page.'.downlaod',$invoice->id)}}"><button
                                            class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
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
 
@if(checkPersonPermission('update_invoices_section_8'))
           <a title="Edit" href="{{ route($page . '.edit', $invoice->id) }}"><button
                                        class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                        <i class="ki-duotone ki-pencil fs-3 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
           </a>
           @endif


    @if(checkPersonPermission('delete_invoices_section_8'))
   <a title="Delete" href="{{route($page.'.delete', ['id' => $invoice->id])}}"
   data-id="{{$invoice->id}}"
   class="btn btn-icon btn-active-light-primary w-30px h-30px delete-invoices"
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