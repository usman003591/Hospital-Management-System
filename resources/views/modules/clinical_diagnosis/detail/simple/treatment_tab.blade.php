<div class="mb-5 card card-xl-stretch mb-xl-8" style="width: 73.5rem">
    <form class="form" action="{{ route('clinical_diagnosis.store_treatment', ['cd_id' => $obj->id]) }}" method="POST"
        enctype="multipart/form-data" class="needs-validation" novalidate>

        @isset($CdTreatmentData)
            {{ method_field('PUT') }}
            @endif

            @csrf
            <div class="card-body" style="height:auto">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">8. Patient Medication</h3>
                <div class="mb-15">
                    <!--begin::Repeater-->
                    <div id="kt_docs_repeater_advanced_treatment">
                        <!--begin::Form group-->

                        <div class="form-group">
                            <div data-repeater-list="kt_docs_repeater_advanced_treatment">

                                @if (!is_null($CdTreatmentData))
                                    @isset($CdTreatmentData)
                                        @foreach ($CdTreatmentData as $key => $data)
                                            @php
                                            @endphp

                                            <div data-repeater-item>
                                                <div class="mb-5 form-group row repeater-row-treatment">
                                                    <div class="pt-3 col-md-8">
                                                        <label class="form-label">Select Medicine <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select selectMedicine" name="selectMedicine"
                                                            data-kt-repeater="medicine_select_2"
                                                            data-placeholder="Select medicine">
                                                            <option></option>
                                                            @isset($medicines)
                                                                @foreach ($medicines as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        @if ($item->id === $data->medicine_id) selected @endif>
                                                                        @if($item->is_in_house) * @endif {{ $item->name }}
                                                                        {{-- {{ $item->name }} --}}
                                                                    </option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                        @error('kt_docs_repeater_advanced_treatment.*.selectMedicine')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="pt-3 col-md-4">
                                                        <label class="form-label">Select Form
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-select treatment_forms" name="selectForm"
                                                            data-kt-repeater="form_select_2"
                                                            data-placeholder="Select medicine form">
                                                            <option></option>
                                                            @isset($treatment_forms)
                                                                @foreach ($treatment_forms as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        @if ($item->id === $data->treatment_form_id) selected @endif
                                                                        {{ old('kt_docs_repeater_advanced_treatment.0.selectForm') == $item->id ? 'selected' : '' }}>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                        @error('kt_docs_repeater_advanced_treatment.*.selectForm')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>


                                                    <div class="pt-3 col-md-4">
                                                        <label class="form-label">Select Quantity <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select selectDosage" name="selectDosage"
                                                            data-kt-repeater="dosage_select_2" data-placeholder="Select dosage">
                                                            <option></option>
                                                            @isset($treatment_dosage)
                                                                @foreach ($treatment_dosage as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        @if ($item->id === $data->treatment_dosage_id) selected @endif>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                        @error('kt_docs_repeater_advanced_treatment.*.selectDosage')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="pt-3 col-md-4">
                                                        <label class="form-label">Select Duration <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select selectDuration" name="selectDuration"
                                                            data-kt-repeater="dosage_select_2" data-placeholder="Select duration">
                                                            <option></option>
                                                            @isset($durations)
                                                                @foreach ($durations as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        @if ($item->id === $data->treatment_duration_id) selected @endif>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                        @error('kt_docs_repeater_advanced_treatment.*.selectDuration')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="pt-3 col-md-4">
                                                        <label class="form-label">Select Frequency <span
                                                                class="text-danger">*</span></label>
                                                                <select class="form-select selectFrequency" name="selectFrequency"
                                                                data-kt-repeater="frequency_select_2" data-placeholder="Select frequency">
                                                            <option></option>
                                                            @isset($treatment_interval)
                                                            @foreach ($treatment_interval as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        @if ($item->id === $data->treatment_dose_interval_id) selected @endif>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                        @error('kt_docs_repeater_advanced_treatment.*.selectFrequency')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    {{-- <div class="pt-3 col-md-4">
                                                        <label class="form-label">Select Interval <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select selectDuration" name="selectInterval"
                                                            data-kt-repeater="interval_select_2"
                                                            data-placeholder="Select quantity interval">
                                                            <option></option>
                                                            @isset($treatment_interval)
                                                                @foreach ($treatment_interval as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        @if ($item->id === $data->treatment_dose_interval_id) selected @endif>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                    </div> --}}

                                                    <div class="pt-3 col-md-4">
                                                        <label class="form-label">Select Route
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-select treatment_routes" name="selectRoute"
                                                            data-kt-repeater="route_select_2"
                                                            data-placeholder="Select medicine route">
                                                            <option></option>
                                                            @isset($treatment_routes)
                                                                @foreach ($treatment_routes as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        @if ($item->id === $data->treatment_route_id) selected @endif
                                                                        {{ old('kt_docs_repeater_advanced_treatment.0.selectRoute') == $item->id ? 'selected' : '' }}>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                        @error('kt_docs_repeater_advanced_treatment.*.selectRoute')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    {{-- <div class="pt-3 col-md-8">
                                                        <label class="form-label">Remarks</label>
                                                        <textarea class="form-control remarks" name="remarks" rows="1" cols="5" maxlength="100"
                                                            oninput="updateRemarksCharCount(this)" placeholder="Enter Medicine remarks">@if (isset($data->remarks)){{ trim($data->remarks) }}@endif</textarea>
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
                                                        placeholder="Enter Medicine remarks">@if (isset($data->remarks)){{ trim($data->remarks) }}@endif{{ old('kt_docs_repeater_advanced_treatment.0.remarks') }}</textarea>
                                                    <small class="text-muted remarks-char-count">0/250 characters</small>
                                                    @error('kt_docs_repeater_advanced_treatment.*.remarks')
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
                                        <div class="mb-5 form-group row repeater-row-treatment">
                                            <div class="pt-3 col-md-8">
                                                <label class="form-label">Select Medicine
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select selectMedicine" name="selectMedicine"
                                                    data-kt-repeater="medicine_select_2" data-placeholder="Select medicine">
                                                    <option></option>
                                                    @isset($medicines)

                                                        @foreach ($medicines as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('kt_docs_repeater_advanced_treatment.0.selectMedicine') == $item->id ? 'selected' : '' }}>
                                                                @if($item->is_in_house) * @endif {{ $item->name }}
                                                                </option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('kt_docs_repeater_advanced_treatment.*.selectMedicine')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="pt-3 col-md-4">
                                                <label class="form-label">Select Form
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select treatment_forms" name="selectForm"
                                                    data-kt-repeater="form_select_2"
                                                    data-placeholder="Select medicine form">
                                                    <option></option>
                                                    @isset($treatment_forms)
                                                        @foreach ($treatment_forms as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('kt_docs_repeater_advanced_treatment.0.selectForm') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('kt_docs_repeater_advanced_treatment.*.selectForm')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>


                                            <div class="pt-3 col-md-4">
                                                <label class="form-label">Select Quantity
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select selectDosage" name="selectDosage"
                                                    data-kt-repeater="dosage_select_2" data-placeholder="Select dosage">
                                                    <option></option>
                                                    @isset($treatment_dosage)
                                                        @foreach ($treatment_dosage as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('kt_docs_repeater_advanced_treatment.0.selectDosage') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('kt_docs_repeater_advanced_treatment.*.selectDosage')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="pt-3 col-md-4">
                                                <label class="form-label">Select Duration <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select selectDuration" name="selectDuration"
                                                    data-kt-repeater="dosage_select_2" data-placeholder="Select duration">
                                                    <option></option>
                                                    @isset($durations)
                                                        @foreach ($durations as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('kt_docs_repeater_advanced_treatment.*.selectDuration')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="pt-3 col-md-4">
                                                <label class="form-label">Select Frequency
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select selectFrequency" name="selectFrequency"
                                                    data-kt-repeater="frequency_select_2" data-placeholder="Select frequency">
                                                    <option></option>
                                                    @isset($treatment_interval)
                                                        @foreach ($treatment_interval as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('kt_docs_repeater_advanced_treatment.0.selectFrequency') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('kt_docs_repeater_advanced_treatment.*.selectFrequency')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            {{-- <div class="pt-3 col-md-4">
                                                <label class="form-label">Select Interval
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select selectDuration" name="selectInterval"
                                                    data-kt-repeater="interval_select_2"
                                                    data-placeholder="Select quantity interval">
                                                    <option></option>
                                                    @isset($treatment_interval)
                                                        @foreach ($treatment_interval as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('kt_docs_repeater_advanced_treatment.0.selectInterval') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('kt_docs_repeater_advanced_treatment.*.selectInterval')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div> --}}



                                            <div class="pt-3 col-md-4">
                                                <label class="form-label">Select Route
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select treatment_routes" name="selectRoute"
                                                    data-kt-repeater="route_select_2"
                                                    data-placeholder="Select medicine route">
                                                    <option></option>
                                                    @isset($treatment_routes)
                                                        @foreach ($treatment_routes as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('kt_docs_repeater_advanced_treatment.0.selectRoute') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('kt_docs_repeater_advanced_treatment.*.selectRoute')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            {{-- <div class="pt-3 col-md-8">
                                                <label class="form-label">Remarks</label>
                                                <textarea class="form-control remarks" name="remarks" rows="1" cols="5" maxlength="100"
                                                    oninput="updateRemarksCharCount(this)" placeholder="Enter Medicine remarks">@if (isset($data->remarks)){{ trim($data->remarks) }}@endif{{ old('kt_docs_repeater_advanced_treatment.0.remarks')}}</textarea>
                                                <small class="text-muted remarks-char-count">0/100 characters</small>
                                                @error('kt_docs_repeater_advanced_treatment.*.remarks')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
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
                                                    placeholder="Enter Medicine remarks">@if (isset($data->remarks)){{ trim($data->remarks) }}@endif{{ old('kt_docs_repeater_advanced_treatment.0.remarks') }}</textarea>
                                                <small class="text-muted remarks-char-count">0/250 characters</small>
                                                @error('kt_docs_repeater_advanced_treatment.*.remarks')
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

    <script>
        function updateRemarksCharCount(textarea) {
            const maxLength = textarea.getAttribute('maxlength');
            const currentLength = textarea.value.length;
            const charCountElement = textarea.nextElementSibling;
            charCountElement.textContent = `${currentLength}/${maxLength} characters`;
        }

        // Initialize remarks character count on page load
        document.addEventListener('DOMContentLoaded', function() {
            const remarksFields = document.querySelectorAll('textarea.remarks');
            remarksFields.forEach(textarea => {
                updateRemarksCharCount(textarea);
            });
        });
    </script>
