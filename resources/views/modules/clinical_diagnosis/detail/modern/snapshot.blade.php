<div class="mb-5 card card-xl-stretch mb-xl-8" style="width: 73.5rem">
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
                    <a href="{{route($page.'.index')}}" class="btn btn-sm btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
