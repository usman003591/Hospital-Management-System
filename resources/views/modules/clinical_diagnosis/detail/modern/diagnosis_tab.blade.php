<div class="mb-5 card card-xl-stretch mb-xl-8" style="width:73.5rem">
    <form class="form" action="{{ route('clinical_diagnosis.store_diagnosis', ['cd_id' => $obj->id]) }}" method="POST"
        enctype="multipart/form-data" class="needs-validation" novalidate>
        @isset($CdDiagnosisData)
        {{ method_field('PUT') }}
        @endif
        @csrf
        <div class="card-body" style="height:auto">
            <h3 class="mb-6 font-size-lg text-dark font-weight-bold">7. Patient Diagnosis</h3>
            <div class="mb-15">
                <!--begin::Repeater-->
                <div id="kt_docs_repeater_advanced_diagnosis">
                    <!--begin::Form group-->
                    <div class="form-group">
                        <div data-repeater-list="kt_docs_repeater_advanced_diagnosis">

                            @if (!is_null($CdDiagnosisData))
                            @isset($CdDiagnosisData)

                            @foreach ($CdDiagnosisData as $key => $data)
                            @php
                            @endphp

                            <div data-repeater-item>
                                <div class="mb-5 form-group row repeater-row-diagnosis">
                                    <div class="col-md-5">
                                        <label class="form-label"> Diagnosis <span class="text-danger">*</span></label>

                                        <select class="form-select selectDiagnosis" name="selectDiagnosis"
                                            data-kt-repeater="diagnosis_select_2" data-placeholder="Select diagnosis">
                                            <option></option>
                                            @isset($diagnosis)
                                            @foreach ($diagnosis as $item)
                                            <option value="{{ $item->id }}" @if ($item->id === $data->diagnosis_id)
                                                selected @endif>
                                                {{ $item->code }}  {{ $item->name }}
                                            </option>
                                            @endforeach
                                            @endisset
                                        </select>
                                        @error('kt_docs_repeater_advanced_diagnosis.{{ $key }}.selectDiagnosis')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label">Diagnosis Categories <span class="text-danger">*</span></label>
                                        <select class="form-select selectDiagnosisCategory" name="selectDiagnosisCategory"
                                            data-kt-repeater="diagnosis_categories_select_2"
                                            data-placeholder="Select diagnosis category">
                                            <option></option>
                                            @isset($diagnosis_categories)
                                            @foreach ($diagnosis_categories as $item)
                                            <option value="{{ $item->id }}" @if ($item->id === $data->diagnosis_category_id)
                                                selected @endif>
                                                {{ $item->name }}
                                            </option>
                                            @endforeach
                                            @endisset
                                        </select>
                                        @error('kt_docs_repeater_advanced_diagnosis.{{ $key }}.selectDiagnosisCategory')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- <div class="pt-3 col-md-8">
                                        <label class="form-label">Remarks</label>
                                        <textarea class="form-control remarks" name="remarks" rows="1" cols="5" maxlength="100"
                                            oninput="updateRemarksCharCount(this)" placeholder="Enter Diagnosis remarks">@if (isset($data->remarks)){{ trim($data->remarks) }}@endif</textarea>
                                        <small class="text-muted remarks-char-count">0/100 characters</small>
                                    </div> --}}

                                    <div class="pt-3 col-md-8">
                                        <label class="form-label">Remarks</label>
                                        <textarea 
                                            class="form-control remarks" 
                                            name="remarks" 
                                            rows="4" 
                                            cols="5" 
                                            maxlength="250"
                                            oninput="updateRemarksCharCount(this)" 
                                            placeholder="Enter Diagnosis remarks">@if (isset($data->remarks)){{ trim($data->remarks) }}@endif{{ old('kt_docs_repeater_advanced_complaints.0.remarks') }}</textarea>
                                        <small class="text-muted remarks-char-count">0/250 characters</small>
                                        @error('kt_docs_repeater_advanced_complaints.*.remarks')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    {{-- <div class="col-md-5">
                                        <label class="form-label">Addtional Diagnosis <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select selectSubDiagnosis" name="selectSubDiagnosis"
                                            data-kt-repeater="sub_diagnosis_select_2" multiple
                                            data-placeholder="Addtional diagnosis">
                                            <option></option>
                                            @isset($child_diagnosis)
                                            @foreach ($child_diagnosis as $item)
                                            <option data-parent-id="{{ $item->parent_id }}" value="{{ $item->id }}"
                                                @foreach ($data['detail_data'] as $detail) @if
                                                ($detail['diagnosis_id']==$item->id)
                                                selected
                                                @endif @endforeach>
                                                {{ $item->name }}</option>
                                            @endforeach
                                            @endisset
                                        </select>
                                        @error('kt_docs_repeater_advanced_diagnosis.{{ $key }}.selectSubDiagnosis')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div> --}}
                                    {{-- <div class="col-md-3">
                                        <label class="form-label">Duration:</label>
                                        <input class="form-control" placeholder="Enter Symptom Duration" name="duration"
                                            type="number" />
                                    </div> --}}
                                    <div class="col-md-2">
                                        <a href="javascript:;" data-repeater-delete
                                            class="mt-3 btn btn-flex btn-sm btn-light-danger mt-md-9">
                                            <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span></i>
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endisset
                            @else
                            <div data-repeater-item>
                                <div class="mb-5 form-group row repeater-row-diagnosis">
                                    <div class="col-md-5">
                                        <label class="form-label"> Diagnosis <span class="text-danger">*</span></label>
                                        <select class="form-select selectDiagnosis" name="selectDiagnosis"
                                            data-kt-repeater="diagnosis_select_2" data-placeholder="Select diagnosis">
                                            {{-- <option></option> --}}
                                            {{-- @isset($diagnosis)
                                            @foreach ($diagnosis as $item)
                                            <option value="{{ $item->id }}" {{
                                                old('kt_docs_repeater_advanced_diagnosis.0.selectDiagnosis')==$item->id
                                                ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                            @endforeach
                                            @endisset --}}
                                        </select>

                                        @error('kt_docs_repeater_advanced_diagnosis.*.selectDiagnosis')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                      <div class="col-md-5">
                                        <label class="form-label">Diagnosis Categories <span class="text-danger">*</span></label>
                                        <select class="form-select selectDiagnosisCategory" name="selectDiagnosisCategory"
                                            data-kt-repeater="diagnosis_categories_select_2"
                                            data-placeholder="Select diagnosis category">
                                            <option></option>
                                            @isset($diagnosis_categories)
                                            @foreach ($diagnosis_categories as $item)
                                            <option value="{{ $item->id }}" {{
                                                old('kt_docs_repeater_advanced_diagnosis.0.selectDiagnosisCategory')==$item->id
                                                ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                            @endforeach
                                            @endisset
                                        </select>
                                        @error('kt_docs_repeater_advanced_diagnosis.{{ $key }}.selectDiagnosisCategory')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- <div class="pt-3 col-md-8">
                                        <label class="form-label">Remarks</label>
                                        <textarea class="form-control remarks" name="remarks" rows="1" cols="5" maxlength="100"
                                            oninput="updateRemarksCharCount(this)" placeholder="Enter Diagnosis remarks"></textarea>
                                        <small class="text-muted remarks-char-count">0/100 characters</small>
                                    </div> --}}
                                    <div class="pt-3 col-md-8">
                                        <label class="form-label">Remarks</label>
                                        <textarea 
                                            class="form-control remarks" 
                                            name="remarks" 
                                            rows="4" 
                                            cols="5" 
                                            maxlength="250"
                                            oninput="updateRemarksCharCount(this)" 
                                            placeholder="Enter Diagnosis remarks">{{ old('kt_docs_repeater_advanced_complaints.0.remarks') }}</textarea>
                                        <small class="text-muted remarks-char-count">0/250 characters</small>
                                        @error('kt_docs_repeater_advanced_complaints.*.remarks')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    {{-- <div class="col-md-5">
                                        <label class="form-label">Addtional Diagnosis <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select selectSubDiagnosis" name="selectSubDiagnosis"
                                            data-kt-repeater="sub_diagnosis_select_2" multiple
                                            data-placeholder="Addtional diagnosis">
                                            <option></option>
                                            @isset($child_diagnosis)
                                            @foreach ($child_diagnosis as $item)
                                            <option data-parent-id="{{ $item->parent_id }}" value="{{ $item->id }}" {{
                                                in_array($item->id,
                                                old('kt_docs_repeater_advanced_diagnosis.0.selectSubDiagnosis', [])) ?
                                                'selected' : '' }}>
                                                {{ $item->name }}</option>
                                            @endforeach
                                            @endisset
                                        </select>
                                        @error('kt_docs_repeater_advanced_diagnosis.*.selectSubDiagnosis')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div> --}}
                                    {{-- <div class="col-md-3">
                                        <label class="form-label">Duration:</label>
                                        <input class="form-control" placeholder="Enter Symptom Duration" name="duration"
                                            type="number" />
                                    </div> --}}
                                    <div class="col-md-2">
                                        <a href="javascript:;" data-repeater-delete
                                            class="mt-3 btn btn-flex btn-sm btn-light-danger mt-md-9">
                                            <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span></i>
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!--end::Form group-->

                    <!--begin::Form group-->
                    <div class="form-group">
                        <a href="javascript:;" data-repeater-create class="btn btn-flex btn-light-primary">
                            <i class="ki-duotone ki-plus fs-3"></i>
                            Add
                        </a>
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
                    <button type="submit" class="mr-2 btn btn-sm btn-primary">Submit</button>
                    <a href="{{ route($page . '.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
