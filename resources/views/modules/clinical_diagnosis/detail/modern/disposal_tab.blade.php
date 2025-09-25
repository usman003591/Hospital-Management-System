<div class="mb-5 card card-xl-stretch mb-xl-8">
    <form class="form" action="{{ route('clinical_diagnosis.store_disposal', ['cd_id' => $obj->id]) }}" method="POST"
        enctype="multipart/form-data" class="needs-validation" novalidate>
        @isset($CdDisposalData)
            {{ method_field('PUT') }}
            @endif
            @csrf
            <div class="card-body" style="height:30vh auto; width:100vh; overflow:scroll;">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">9. Patient Disposal</h3>
                <div class="mb-15" >
                    <!--begin::Repeater-->
                    <div id="kt_docs_repeater_advanced_disposal" style="overflow-y: auto;
                      overflow-x: hidden;
                      height: 400px;">
                        <!--begin::Form group-->
                        <div class="form-group">

                                @if (!is_null($CdDisposalData))
                                    @isset($CdDisposalData)

                                    @if($CdDisposalData->disposal_type == 'referred_to_specialist')
                                    <label class="form-label">Referred to Specialist {{ getDoctorNameById($CdDisposalData->disposal_type_id) }}</label>
                                    <br>
                                    @endif

                                    @if($CdDisposalData->disposal_type == 'referred_to_hospital')
                                    <label class="form-label">Referred to {{ getHospitalNameById($CdDisposalData->disposal_type_id) }} </label>
                                    <br>
                                    @endif

                                    @if($CdDisposalData->disposal_type == 'referred_to_department')
                                    <label class="form-label">Referred to {{ getDepartmentNameById($CdDisposalData->disposal_type_id) }} Department </label>
                                    <br>
                                    @endif

                                    <div class="row">
                                        <div class="col-md-10">
                                            <label class="form-label">Date <span class="text-danger">*</span></label>
                                             {{-- @php $date = Carbon\Carbon::parse($CdDisposalData->dated)->toDateString(); @endphp --}}
                                             @php
                                                 $date = isset($CdDisposalData->dated) ? \Carbon\Carbon::parse($CdDisposalData->dated)->format('d/m/Y H:i') : '';
                                             @endphp
                                             <input type="text" name="date"  data-date-format="DD MMMM YYYY"  class="form-control" id="disposalDate" value="{{$date}}">
                                            @error('date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-10">
                                            <label class="form-label">Select Disposal Type <span class="text-danger">*</span></label>
                                            <select class="form-select selectDisposalVal" id="selectDisposalVal" name="disposal_type" data-placeholder="Select disposal type">
                                                <option selected disabled hidden> Select Disposal Type </option>
                                                <option value="referred_to_hospital" @if($CdDisposalData->disposal_type == 'referred_to_hospital') selected @endif> Refer to Hospital </option>
                                                <option value="referred_to_specialist" @if($CdDisposalData->disposal_type == 'referred_to_specialist') selected @endif> Refer to Specialist </option>
                                                <option value="referred_to_department" @if($CdDisposalData->disposal_type == 'referred_to_department') selected @endif> Refer to Department </option>
                                                <option value="discharged" @if($CdDisposalData->disposal_type == 'discharged') selected @endif> Discharged </option>
                                                <option value="medical_advice" @if($CdDisposalData->disposal_type == 'medical_advice') selected @endif> Medical Advice </option>
                                                <option value="death_deceased"  @if($CdDisposalData->disposal_type == 'death_deceased') selected @endif> Deceased </option>
                                                <option value="follow_up"  @if($CdDisposalData->disposal_type == 'follow_up') selected @endif> Follow Up </option>
                                            </select>
                                            @error('disposal_type')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row" style="display: none;" id="followup_div">
                                        <div class="col-md-10">
                                            <label class="form-label">Follow Up date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="disposal_type_value" id="disposal_type_value"
                                                @isset($CdDisposalData->disposal_type_value) value="{{ isset($CdDisposalData) && $CdDisposalData->disposal_type ===
                                            'follow_up' ? \Carbon\Carbon::parse($CdDisposalData->disposal_type_value)->format('d/m/Y h:i A') : old('disposal_type_value') }}" @endisset />
                                        </div>
                                    </div>


                                    <div class="row disposal-dropdown-div" id="disposal-dropdown-div"></div>

                                    {{-- <div class="row"><br>
                                        <div class="col-md-10 ">
                                            <label class="form-label"> Remarks  </label>
                                             <textarea class="form-control" id="disposal_remarks" name="disposal_remarks" placeholder="Enter disposal remarks" rows="3">{{$CdDisposalData->remarks}}</textarea>
                                        </div>
                                    </div> --}}
                                    <div class="row pt-3">
                                        <div class="col-md-10">
                                            <label class="form-label">Remarks</label>
                                            <textarea
                                                class="form-control remarks"
                                                id="disposal_remarks"
                                                name="disposal_remarks"
                                                rows="5"
                                                cols="5"
                                                maxlength="1000"
                                                oninput="updateRemarksCharCount(this)"
                                                placeholder="Enter disposal remarks">{{ isset($CdDisposalData->remarks) ? trim($CdDisposalData->remarks) : '' }}{{ old('kt_docs_repeater_advanced_complaints.0.remarks') }}</textarea>
                                            <small class="text-muted remarks-char-count">0/1000 characters</small>
                                            @error('kt_docs_repeater_advanced_complaints.*.remarks')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>


                                    @endisset
                                @else

                                <div class="row">
                                    <div class="col-md-10">
                                        <label class="form-label">Date <span class="text-danger">*</span></label>
                                         @php $date = Carbon\Carbon::now()->format('d/m/Y H:i'); @endphp
                                         <input type="text" name="date" data-date-format="DD MMMM YYYY"  class="form-control" id="disposalDate" value="{{ $date }}" placeholder="DD/MM/YYYY">
                                         @error('date')
                                            <small class="text-danger">{{ $message }}</small>
                                         @enderror
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-10">
                                        <label class="form-label">Select Disposal Type <span class="text-danger">*</span></label>
                                        <select class="form-select selectDisposalVal" id="selectDisposalVal" name="disposal_type" data-placeholder="Select disposal type">
                                            <option selected disabled hidden value=""> Select Disposal Type </option>
                                            <option value="referred_to_hospital"> Refer to Hospital </option>
                                            <option value="referred_to_specialist"> Refer to Specialist </option>
                                            <option value="referred_to_department"> Refer to Department </option>
                                            <option value="discharged"> Discharged </option>
                                            <option value="medical_advice"> Medical Advice </option>
                                            <option value="death_deceased"> Deceased </option>
                                            <option value="follow_up"> Follow Up </option>
                                            {{-- <option value="admission"> Admission </option> --}}
                                            @error('disposal_type')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </select>
                                    </div>
                                </div>
                                <br>

                                <div class="row" style="display: none;" id="followup_div">
                                    <div class="col-md-10">
                                        <label class="form-label">Follow Up date <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" data-date-format="DD MMMM YYYY" name="disposal_type_value" id="disposal_type_value" value="{{ $date }}" placeholder="dd/mm/YYYY hh:mm AA"/>
                                    </div>
                                </div>

                                <div class="row disposal-dropdown-div" id="disposal-dropdown-div"></div>

                                {{-- <div class="row">
                                    <br>
                                    <div class="col-md-10 ">
                                        <label class="form-label"> Remarks  </label>
                                         <textarea class="form-control" id="disposal_remarks" name="disposal_remarks" placeholder="Enter disposal remarks" rows="3"></textarea>
                                    </div>
                                </div> --}}
                                <div class="row pt-3">
                                    <div class="col-md-10">
                                        <label class="form-label">Remarks</label>
                                        <textarea
                                            class="form-control remarks"
                                            id="disposal_remarks"
                                            name="disposal_remarks"
                                            rows="5"
                                            cols="5"
                                            maxlength="1000"
                                            oninput="updateRemarksCharCount(this)"
                                            placeholder="Enter disposal remarks">{{ old('kt_docs_repeater_advanced_complaints.0.remarks') }}</textarea>
                                        <small class="text-muted remarks-char-count">0/1000 characters</small>
                                        @error('kt_docs_repeater_advanced_complaints.*.remarks')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>


                                @endif
                        </div>
                        <!--end::Form group-->
                    </div>
                    <!--end::Repeater-->
                    <br>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3 text-end">
                        @php
                        $doctorPanelValue = checkDoctorPanelVal();
                        @endphp
                        @if ($doctorPanelValue)
                        <button type="submit" class="mr-2 btn btn-sm btn-primary">Finish</button>
                        @else
                        <button type="submit" class="mr-2 btn btn-sm btn-primary">Submit</button>
                        @endif
                        <a href="{{ route($page . '.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
