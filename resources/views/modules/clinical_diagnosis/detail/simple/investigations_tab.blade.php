<div class="mb-5 card card-xl-stretch mb-xl-8" style = "width:70rem;">
    <form class="form" action="{{ route('clinical_diagnosis.store_investigations', ['cd_id' => $obj->id]) }}"
        method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if (!is_null($CdInvestigationsRadiology))
            {{ method_field('PUT') }}
        @endif
        @csrf
        <div class="card-body" style="height:auto">
            <h3 class="mb-6 font-size-lg text-dark font-weight-bold">6. Patient Investigation</h3>
            <div class="mb-15">

                <hr>
                <h5 class="mb-6 font-size-lg text-dark font-weight-bold">Radiology Section</h5>
                <br>

                <!--begin::Repeater-->
                <div id="kt_docs_repeater_advanced_radiology">
                    <!--begin::Form group-->
                    <div class="form-group">
                        <div data-repeater-list="kt_docs_repeater_advanced_radiology">

                            @if (!is_null($CdInvestigationsRadiology))
                                @isset($CdInvestigationsRadiology)
                                    @foreach ($CdInvestigationsRadiology as $key => $data)
                                        @php
                                        @endphp

                                        <div data-repeater-item>
                                            <div class="mb-5 form-group row repeater-row-spes">
                                                <div class="col-md-5">
                                                    <label class="form-label">Radiology Test</label>
                                                    <select class="form-select selectRadiology" name="radiology"
                                                        data-kt-repeater="radiology_select_2"
                                                        data-placeholder="Select radiology test">
                                                        <option></option>
                                                        @isset($radiology_tests)
                                                            @foreach ($radiology_tests as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @if ($item->id === $data->investigation_id) selected @endif>
                                                                      @if($item->is_in_house) * @endif {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                    @error('kt_docs_repeater_advanced_radiology.{{ $key }}.radiology')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                {{-- <div class="col-md-4">
                                                    <label class="form-label">Remarks:</label>
                                                    <input class="form-control" placeholder="Enter remarks" value="{{$data->remarks}}" name="remarks"
                                                        type="text" maxlength="100"/>
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
                                                        placeholder="Enter remarks">{{ isset($data->remarks) ? trim($data->remarks) : '' }}{{ old('kt_docs_repeater_advanced_complaints.0.remarks') }}</textarea>
                                                    <small class="text-muted remarks-char-count">0/250 characters</small>
                                                    @error('kt_docs_repeater_advanced_complaints.*.remarks')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2">
                                                    <a href="javascript:;" data-repeater-delete
                                                        class="mt-3 btn btn-flex btn-sm btn-light-danger mt-md-9">
                                                        <i class="ki-duotone ki-trash fs-3"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span><span
                                                                class="path5"></span></i>
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                            @else
                                <div data-repeater-item>
                                    <div class="mb-5 form-group row repeater-row-spes">

                                        <div class="col-md-5">
                                            <label class="form-label">Radiology Test</label>
                                            <select class="form-select selectRadiology" name="radiology"
                                                data-kt-repeater="radiology_select_2"
                                                data-placeholder="Select radiology test">
                                                <option></option>
                                                @isset($radiology_tests)
                                                    @foreach ($radiology_tests as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('kt_docs_repeater_advanced_radiology.*.radiology') == $item->id ? 'selected' : '' }}>
                                                            @if($item->is_in_house) * @endif  {{ $item->name }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            @error('kt_docs_repeater_advanced_radiology.*.radiology')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <label class="form-label">Remarks:</label>
                                            <input class="form-control" placeholder="Enter remarks" value="" name="remarks"
                                                type="text" maxlength="100"/>
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
                                                    placeholder="Enter remarks">{{ old('kt_docs_repeater_advanced_complaints.0.remarks') }}</textarea>
                                                <small class="text-muted remarks-char-count">0/250 characters</small>
                                                @error('kt_docs_repeater_advanced_complaints.*.remarks')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

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

                <hr>
                <h5 class="mb-6 font-size-lg text-dark font-weight-bold">Pathology Section</h5>
                <br>

                <!--begin::Repeater-->
                <div id="kt_docs_repeater_advanced_pathology">
                    <!--begin::Form group-->
                    <div class="form-group">
                        <div data-repeater-list="kt_docs_repeater_advanced_pathology">


                            @if (!is_null($CdInvestigationsPathology))
                                @isset($CdInvestigationsPathology)
                                    @foreach ($CdInvestigationsPathology as $key => $data)
                                        @php
                                        @endphp

                                        <div data-repeater-item>
                                            <div class="mb-5 form-group row repeater-row-spes">

                                                <div class="col-md-5">
                                                    <label class="form-label">Pathology Test</label>
                                                    <select class="form-select selectPathology" name="pathology"
                                                        data-kt-repeater="pathology_select_2"
                                                        data-placeholder="Select pathology test">
                                                        <option></option>
                                                        @isset($pathology_tests)
                                                            @foreach ($pathology_tests as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @if ($item->id === $data->investigation_id) selected @endif>
                                                                    @if($item->is_in_house) * @endif {{ $item->name }}</option>
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                    @error('kt_docs_repeater_advanced_pathology.{{ $key }}.pathology')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                {{-- <div class="col-md-4">
                                                    <label class="form-label">Remarks:</label>
                                                    <input class="form-control" placeholder="Enter remarks" value="{{$data->remarks}}" name="remarks"
                                                        type="text" maxlength="100"/>
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
                                                        placeholder="Enter Medicine remarks">{{ isset($data->remarks) ? trim($data->remarks) : '' }}{{ old('kt_docs_repeater_advanced_complaints.0.remarks') }}</textarea>
                                                    <small class="text-muted remarks-char-count">0/250 characters</small>
                                                    @error('kt_docs_repeater_advanced_complaints.*.remarks')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-2">
                                                    <a href="javascript:;" data-repeater-delete
                                                        class="mt-3 btn btn-flex btn-sm btn-light-danger mt-md-9">
                                                        <i class="ki-duotone ki-trash fs-3"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span><span
                                                                class="path5"></span></i>
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                            @else
                                <div data-repeater-item>
                                    <div class="mb-5 form-group row repeater-row-spes">

                                        <div class="col-md-5">
                                            <label class="form-label">Pathology Test</label>
                                            <select class="form-select selectPathology" name="pathology"
                                                data-kt-repeater="pathology_select_2"
                                                data-placeholder="Select pathology test">
                                                <option></option>
                                                @isset($pathology_tests)
                                                    @foreach ($pathology_tests as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('kt_docs_repeater_advanced_pathology.*.pathology') == $item->id ? 'selected' : '' }}>
                                                              @if($item->is_in_house) * @endif {{ $item->name }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            @error('kt_docs_repeater_advanced_pathology.*.pathology')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- <div class="col-md-4">
                                            <label class="form-label">Remarks:</label>
                                            <input class="form-control" placeholder="Enter remarks" value="" name="remarks"
                                                type="text" maxlength="100"/>
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
                                                placeholder="Enter Medicine remarks">{{ old('kt_docs_repeater_advanced_complaints.0.remarks') }}</textarea>
                                            <small class="text-muted remarks-char-count">0/250 characters</small>
                                            @error('kt_docs_repeater_advanced_complaints.*.remarks')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

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

                <hr>
                <h5 class="mb-6 font-size-lg text-dark font-weight-bold">Rehabilitation Section</h5>
                <br>

                <!--begin::Repeater-->
                <div id="kt_docs_repeater_advanced_rehablitation">
                    <!--begin::Form group-->
                    <div class="form-group">
                        <div data-repeater-list="kt_docs_repeater_advanced_rehablitation">


                            @if (!is_null($CdInvestigationsRehablitation))
                                @isset($CdInvestigationsRehablitation)
                                    @foreach ($CdInvestigationsRehablitation as $key => $data)
                                        @php
                                        @endphp

                                        <div data-repeater-item>
                                            <div class="mb-5 form-group row repeater-row-spes">

                                                <div class="col-md-5">
                                                    <label class="form-label">Rehabilitation Test</label>
                                                    <select class="form-select selectRehablitation" name="rehablitation"
                                                        data-kt-repeater="rehablitation_select_2"
                                                        data-placeholder="Select rehabilitation test">
                                                        <option></option>
                                                        @isset($rehablitation_tests)
                                                            @foreach ($rehablitation_tests as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @if ($item->id === $data->investigation_id) selected @endif>
                                                                    @if($item->is_in_house) * @endif {{ $item->name }}</option>
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                    @error('kt_docs_repeater_advanced_rehablitation.{{ $key }}.rehablitation')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                {{-- <div class="col-md-4">
                                                    <label class="form-label">Remarks:</label>
                                                    <input class="form-control" placeholder="Enter remarks" value="{{$data->remarks}}" name="remarks"
                                                        type="text" maxlength="100"/>
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
                                                        placeholder="Enter Medicine remarks">{{ isset($data->remarks) ? trim($data->remarks) : '' }}{{ old('kt_docs_repeater_advanced_complaints.0.remarks') }}</textarea>
                                                    <small class="text-muted remarks-char-count">0/250 characters</small>
                                                    @error('kt_docs_repeater_advanced_complaints.*.remarks')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                {{-- <div class="col-md-3">
                                            <label class="form-label">Duration:</label>
                                            <input class="form-control" placeholder="Enter Symptom Duration" name="duration"
                                                type="number" />
                                        </div> --}}
                                                <div class="col-md-2">
                                                    <a href="javascript:;" data-repeater-delete
                                                        class="mt-3 btn btn-flex btn-sm btn-light-danger mt-md-9">
                                                        <i class="ki-duotone ki-trash fs-3"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span><span
                                                                class="path5"></span></i>
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                            @else
                                <div data-repeater-item>
                                    <div class="mb-5 form-group row repeater-row-spes">

                                        <div class="col-md-5">
                                            <label class="form-label">Rehabilitation Test</label>
                                            <select class="form-select selectRehablitation" name="rehablitation"
                                                data-kt-repeater="rehablitation_select_2"
                                                data-placeholder="Select rehabilitation test">
                                                <option></option>
                                                @isset($rehablitation_tests)
                                                    @foreach ($rehablitation_tests as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('kt_docs_repeater_advanced_rehablitation.*.rehablitation') == $item->id ? 'selected' : '' }}>
                                                            @if($item->is_in_house) * @endif {{ $item->name }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            @error('kt_docs_repeater_advanced_rehablitation.*.rehablitation')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- <div class="col-md-4">
                                            <label class="form-label">Remarks:</label>
                                            <input class="form-control" placeholder="Enter remarks" value="" name="remarks"
                                                type="text" maxlength="100"/>
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
                                                placeholder="Enter Medicine remarks">{{ old('kt_docs_repeater_advanced_complaints.0.remarks') }}</textarea>
                                            <small class="text-muted remarks-char-count">0/250 characters</small>
                                            @error('kt_docs_repeater_advanced_complaints.*.remarks')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

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
