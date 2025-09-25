
<div class="modal fade" id="investigationsModal" tabindex="-1" aria-labelledby="investigationsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
             <!--begin::Modal title-->
                <h2 class="fw-bold">Investigations</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" data-kt-users-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
      </div>

             <form class="form" action="{{route('clinical_diagnosis.generate_investigations_record',['cd_id'=>$CdObj->id])}}" method="POST" target="_blank"
        enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf

      <div class="px-5 modal-body my-7">


          <div id="kt_modal_roles_add_handler" data-kt-add-keypress="true" data-kt-add-min-length="2"
                        data-kt-add-enter="enter" data-kt-add-layout="inline">
                        <!--begin::Form-->
                        <label class="mb-2 required fs-6 fw-semibold form-label">Investigations</label>
                        <select class="form-control form-select select2" name="provided_investigations[]" multiple
                            data-live-search="true" id="select2investigations">
                            @isset($investigations)
                            @foreach ($investigations as $df)
                            <option value="{{$df->id}}"> {{$df->name}} </option>
                            @endforeach
                            @endisset
                        </select>
                        <div>
                            @error('provided_investigations')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

      </div>
      <div class="modal-footer">
          <div class="pt-10 text-center">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                            <span class="align-middle spinner-border spinner-border-sm ms-2"></span></span>
                        </button>
                    </div>
      </div>
             </form>
    </div>
  </div>
</div>
