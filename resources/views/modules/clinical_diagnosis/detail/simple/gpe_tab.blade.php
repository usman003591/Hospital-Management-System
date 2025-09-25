<div class="mb-5 card card-xl-stretch mb-xl-8" style="width: 73.5rem">
    <form class="form" action="{{ route('clinical_diagnosis.store_gpe', ['cd_id' => $obj->id ]) }}" method="POST"
        enctype="multipart/form-data" class="needs-validation" novalidate>
        @isset($CdGeneralPhysicalExaminationData)
            {{ method_field('PUT') }}
            @endif
            @csrf
            <div class="card-body" style="height:auto">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">4. Patient General Physical Examination</h3>
                <div class="mb-15">
                    <!--begin::Repeater-->
                    <div id="kt_docs_repeater_advanced_gpe">
                        <!--begin::Form group-->

                        <div class="form-group">
                            <div data-repeater-list="kt_docs_repeater_advanced_gpe">

                                @if (!is_null($CdGeneralPhysicalExaminationData))
                                    @isset($CdGeneralPhysicalExaminationData)

                                        @foreach ($CdGeneralPhysicalExaminationData as $key => $gpe_data)
                                            @php
                                            @endphp

                                            <div data-repeater-item>
                                                <div class="mb-5 form-group row repeater-row-gpe">
                                                    <div class="col-md-3">
                                                        <label class="form-label"> GPEs <span class="text-danger">*</span></label>
                                                        <select class="form-select selectSubGPE" name="selectSubGPE"
                                                            data-kt-repeater="sub_gpe_select_2" multiple
                                                            data-placeholder="Select GPEs">
                                                            <option></option>
                                                            @isset($child_general_physical_examinations)
                                                                @foreach ($child_general_physical_examinations as $item)
                                                                    <option data-parent-id="{{ $item->parent_id }}"
                                                                        value="{{ $item->id }}"
                                                                        @isset($gpe_data['detail_data'])
                                                                        @foreach ($gpe_data['detail_data'] as $detail)
                                                        @if ($detail['gpe_id'] == $item->id)
                                                        selected
                                                        @endif @endforeach @endisset>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            @endisset

                                                        </select>
                                                        @error('kt_docs_repeater_advanced_gpe.{{ $key }}.selectSubGPE')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    {{-- <div class="col-md-4">
                                                        <label class="form-label">Remarks:</label>
                                                        <input class="form-control" placeholder="Enter remarks" value="{{$gpe_data->remarks}}" name="remarks"
                                                            type="text" maxlength="100"/>
                                                    </div> --}}
                                                    <div class="pt-3 col-md-8">
                                                        <label class="form-label">Remarks</label>
                                                        <textarea 
                                                            class="form-control" 
                                                            name="remarks" 
                                                            rows="4" 
                                                            cols="5" 
                                                            maxlength="250"
                                                            oninput="updateRemarksCharCount(this)" 
                                                            placeholder="Enter remarks">{{ isset($gpe_data->remarks) ? trim($gpe_data->remarks) : '' }}{{ old('kt_docs_repeater_advanced_complaints.0.remarks') }}</textarea>
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
                                        <div class="mb-5 form-group row repeater-row-gpe">
                                            <div class="col-md-3">
                                                <label class="form-label"> GPEs <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select selectSubGPE" name="selectSubGPE"
                                                    data-kt-repeater="sub_gpe_select_2" multiple
                                                    data-placeholder="Select  GPEs">
                                                    <option></option>
                                                    @isset($child_general_physical_examinations)
                                                        @foreach ($child_general_physical_examinations as $item)
                                                            <option data-parent-id="{{ $item->parent_id }}"
                                                                value="{{ $item->id }}"
                                                                {{ in_array($item->id, old('kt_docs_repeater_advanced_gpe.*.selectSubGPE', [])) ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('kt_docs_repeater_advanced_gpe.*.selectSubGPE')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <label class="form-label">Remarks:</label>
                                                <input class="form-control" placeholder="Enter remarks" name="remarks"
                                                    type="text" maxlength="100"/>
                                            </div> --}}
                                            <div class="pt-3 col-md-8">
                                                <label class="form-label">Remarks</label>
                                                <textarea 
                                                    class="form-control" 
                                                    name="remarks" 
                                                    rows="4" 
                                                    cols="5" 
                                                    maxlength="250"
                                                    oninput="updateRemarksCharCount(this)" 
                                                    placeholder="Enter remarks">@if (isset($data->remarks)){{ trim($data->remarks) }}@endif{{ old('kt_docs_repeater_advanced_complaints.0.remarks')}}</textarea>
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
