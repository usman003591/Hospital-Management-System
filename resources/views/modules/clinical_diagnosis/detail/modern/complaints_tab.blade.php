<div class="mb-5 card card-xl-stretch mb-xl-8" style="width: 73.5rem">
    <form class="form" action="{{ route('clinical_diagnosis.store_complaints', ['cd_id' => $obj->id]) }}" method="POST"
        enctype="multipart/form-data" class="needs-validation" novalidate>
        @isset($cdComplaintData)
            {{ method_field('PUT') }}
            @endif
            @csrf
            <div class="card-body" style="height:40vh auto">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. Patient Complaints</h3>
                <div class="mb-15" >
                    <!--begin::Repeater-->
            <div id="kt_docs_repeater_advanced_complaints" {{--
                    style="overflow-y: auto;
                      overflow-x: hidden;
                      height: 400px;"
            --}} >
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div data-repeater-list="kt_docs_repeater_advanced_complaints">

                                @if (!is_null($cdComplaintData))
                                    @isset($cdComplaintData)
                                        @foreach ($cdComplaintData as $key => $complaint_data)
                                            <div data-repeater-item>
                                                <div class="mb-5 form-group row repeater-row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Symptoms <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select selectSymptom" name="selectSymptom"
                                                            data-kt-repeater="symptom_select_2"
                                                            data-placeholder="Select Symptom">
                                                            <option></option>
                                                            @isset($complaints)
                                                                @foreach ($complaints as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        @if ($item->id === $complaint_data->complaint_id) selected @endif>
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                        @error('kt_docs_repeater_advanced_complaints.{{ $key }}.selectSymptom')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Additional Symptoms <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select selectSubSymptom" name="selectSubSymptom"
                                                            data-kt-repeater="sub_symptom_select_2" multiple
                                                            data-placeholder="Select Additional Symptom">
                                                            <option></option>
                                                            @isset($child_complaints)
                                                                @foreach ($child_complaints as $item)
                                                                    <option data-parent-id="{{ $item->parent_id }}"
                                                                        value="{{ $item->id }}"
                                                                        @isset($complaint_data['detail_data'])
                                                                        @foreach ($complaint_data['detail_data'] as $detail)
                                                  @if ($detail['complaint_id'] == $item->id)
                                                  selected
                                                  @endif @endforeach @endisset>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                        @error('kt_docs_repeater_advanced_complaints.{{ $key }}.selectSubSymptom')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Duration (Days)
                                                            {{-- <span class="text-danger">*</span> --}}
                                                        </label>
                                                        <input class="form-control" placeholder="Enter Duration" name="duration"
                                                            type="number" min="0" step="1" oninput="this.value = this.value.replace(/\D/g, '').substring(0, 20)"
                                                            @if ($complaint_data->duration) value="{{ $complaint_data->duration }}" @endif />
                                                        @error('kt_docs_repeater_advanced_complaints.{{ $key }}.duration')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="pt-3 col-md-8">
                                                        <label class="form-label">Remarks</label>
                                                        <textarea class="form-control remarks" name="remarks" rows="4" cols="5" maxlength="250"
                                                            oninput="updateRemarksCharCount(this)" placeholder="Enter Complaint remarks">@if (isset($complaint_data->remarks)){{ trim($complaint_data->remarks) }}@endif</textarea>
                                                        <small class="text-muted remarks-char-count">0/250 characters</small>
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
                                        <div class="mb-5 form-group row repeater-row">
                                            <div class="col-md-4">
                                                <label class="form-label">Symptoms <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select selectSymptom" name="selectSymptom"
                                                    data-kt-repeater="symptom_select_2" data-placeholder="Select a Symptom">
                                                    <option></option>
                                                    @isset($complaints)
                                                        @foreach ($complaints as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('kt_docs_repeater_advanced_complaints.*.selectSymptom') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('kt_docs_repeater_advanced_complaints.*.selectSymptom')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Additional Symptoms <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select selectSubSymptom" name="selectSubSymptom"
                                                    data-kt-repeater="sub_symptom_select_2" multiple
                                                    data-placeholder="Select Additional Symptom">
                                                    <option></option>
                                                    @isset($child_complaints)
                                                        @foreach ($child_complaints as $item)
                                                            <option data-parent-id="{{ $item->parent_id }}"
                                                                value="{{ $item->id }}"
                                                                {{ in_array($item->id, old('kt_docs_repeater_advanced_complaints.*.selectSubSymptom', [])) ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('kt_docs_repeater_advanced_complaints.*.selectSubSymptom')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Duration (Days)
                                                    {{-- <span class="text-danger">*</span> --}}
                                                </label>
                                                <input class="form-control" placeholder="Enter Duration" name="duration"
                                                    type="number" min="0" step="1" oninput="this.value = this.value.replace(/\D/g, '').substring(0, 20)"
                                                    value="{{ old('kt_docs_repeater_advanced_complaints.*.duration') }}" />
                                                @error('kt_docs_repeater_advanced_complaints.*.duration')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                                  <div class="pt-3 col-md-8">
                                                <label class="form-label">Remarks</label>
                                                <textarea class="form-control remarks" name="remarks" rows="4" cols="5" maxlength="250"
                                                    oninput="updateRemarksCharCount(this)" placeholder="Enter Medicine remarks">@if (isset($data->remarks)){{ trim($data->remarks) }}@endif{{ old('kt_docs_repeater_advanced_complaints.0.remarks')}}</textarea>
                                                <small class="text-muted remarks-char-count">0/250 characters</small>
                                                @error('kt_docs_repeater_advanced_complaints.*.remarks')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>


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
