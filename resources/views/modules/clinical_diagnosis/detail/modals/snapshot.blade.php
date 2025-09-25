
<div class="modal fade" id="snapshotModal" tabindex="-1" aria-labelledby="snapshotModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
             <!--begin::Modal title-->
                <h2 class="fw-bold">Snapshot</h2>
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
      <div class="modal-body px-5 my-7">


          <form class="form" action="{{route('clinical_diagnosis.get_snapshot',['cd_id'=>$obj->id])}}" method="POST" target="_blank"
        enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <div class="card-body" style="height:auto">
            <h3 class="mb-6 font-size-lg text-dark font-weight-bold">10. Snapshot</h3>
            <div class="mb-15">

                <div class="container">
                    <div class="row">
                      <div class="p-3 col-md-4">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="vitals" checked="checked" name="values[]" id="vitalsCheckbox" />
                          <label class="form-check-label" for="vitalsCheckbox">
                            Vitals
                          </label>
                        </div>
                      </div>


                      <div class="p-3 col-md-4">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="treatment"  checked="checked"  name="values[]" id="treatmentCheckbox" />
                          <label class="form-check-label" for="treatmentCheckbox">
                            Medications
                          </label>
                        </div>
                      </div>

                      <div class="p-3 col-md-4">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="investigations"  checked="checked"  name="values[]" id="investigationsCheckbox" />
                          <label class="form-check-label" for="investigationsCheckbox">
                            Investigations
                          </label>
                        </div>
                      </div>

                      <div class="p-3 col-md-4">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="brief_history" checked="checked" name="values[]" id="briefHistoryCheckbox" />
                          <label class="form-check-label" for="briefHistoryCheckbox">
                            Brief History
                          </label>
                        </div>
                      </div>

                      <div class="p-3 col-md-4">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="complaints" checked="checked" name="values[]" id="briefHistoryCheckbox" />
                          <label class="form-check-label" for="briefHistoryCheckbox">
                            Complaints
                          </label>
                        </div>
                      </div>

                      <div class="p-3 col-md-4">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="diagnosis" checked="checked" name="values[]" id="treatmentCheckbox" />
                          <label class="form-check-label" for="treatmentCheckbox">
                            Diagnosis
                          </label>
                        </div>
                      </div>

                      {{-- <div class="p-3 col-md-4">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="gpe" name="values[]" id="treatmentCheckbox" />
                          <label class="form-check-label" for="treatmentCheckbox">
                            General Physical Examination
                          </label>
                        </div>
                      </div>

                      <div class="p-3 col-md-4">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="spe" name="values[]" id="treatmentCheckbox" />
                          <label class="form-check-label" for="treatmentCheckbox">
                            Systemic Physical Examination
                          </label>
                        </div>
                      </div> --}}

                    </div>
                  </div>

            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-9"></div>
                <div class="col-lg-3 text-end">
                    <button type="submit" class="mr-2 btn btn-sm btn-primary">Generate</button>
                    <a data-bs-dismiss="modal" class="btn btn-sm btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>



      </div>
      {{-- <div class="modal-footer">
          <div class="text-center pt-10">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
      </div> --}}
    </div>
  </div>
</div>
