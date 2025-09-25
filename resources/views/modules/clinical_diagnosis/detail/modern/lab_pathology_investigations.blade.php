@php $page = 'clinical_diagnosis'; @endphp
<div class="shadow-sm card">
    {{-- @if (!is_null($CdInvestigationsPathology))
    {{ method_field(method: 'POST') }}
    @endif --}}
    <div class="card-header">
        <h3 class="card-title">Pathology investigations</h3>
        <div class="card-toolbar">
            {{-- <button id="addAllInvestigations" class="btn btn-sm btn-primary">Select All Investigations</button>
            --}}
        </div>
    </div>
    <form class="form" action="{{route('clinical_diagnosis.generate_investigations_record',['cd_id'=>$CdObj->id])}}"
        method="POST" enctype="multipart/form-data" class="needs-validation" novalidate @if(!$errors->any())
        target="_blank" @endif>
        @csrf
        <div class="card-body" style="height:auto">
            <div class="mb-15">
                <div id="kt_docs_repeater_advanced_pathology">

                    @if (!is_null($CdInvestigationsPathology))
                    @isset($CdInvestigationsPathology)

                    <div data-repeater-list="kt_docs_repeater_advanced_pathology">
                        @foreach ($CdInvestigationsPathology as $key => $data)
                        <div data-repeater-item>
                            <div class="mb-5 form-group row repeater-row-spes">

                                <div class="col-md-4">
                                    <div class="mt-2 form-check form-check-custom form-check-solid mt-md-11">
                                        <input class="form-check-input checkboxValues" type="checkbox" value="0"
                                            id="form_checkbox" name="perform_investigation" />

                                        <label class="form-check-label" for="form_checkbox">
                                            Perform this investigation
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">Investigation</label>
                                    <select class="form-select selectPathology" name="pathology"
                                        data-kt-repeater="pathology_select_2" data-placeholder="Select pathology test">
                                        <option></option>
                                        @isset($pathology_tests)
                                        @foreach ($pathology_tests as $item)
                                        <option value="{{ $item->id }}" @if ($item->id == $data->investigation_id)
                                            selected @endif
                                            {{ old('kt_docs_repeater_advanced_pathology.*.pathology')==$item->id ?
                                            'selected' : '' }}>
                                            {{ $item->name }} — {{ number_format($item->price) }} Rs
                                        </option>
                                        @endforeach
                                        @endisset
                                    </select>
                                    @error('kt_docs_repeater_advanced_pathology.*.pathology')
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
                        @endforeach
                    </div>

                    @endisset
                    @else

                    <div data-repeater-list="kt_docs_repeater_advanced_pathology">
                        <div data-repeater-item>
                            <div class="mb-5 form-group row repeater-row-spes">
                                <div class="col-md-4">
                                    <div class="mt-2 form-check form-check-custom form-check-solid mt-md-11">
                                        <input class="form-check-input" class="checkboxValues" type="checkbox" value="0"
                                            id="form_checkbox" name="perform_investigation[]" />
                                        <label class="form-check-label" for="form_checkbox">
                                            Perform this investigation
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">Investigation</label>
                                    <select class="form-select selectPathology" name="pathology"
                                        data-kt-repeater="pathology_select_2" data-placeholder="Select pathology test">
                                        <option></option>
                                        @isset($pathology_tests)
                                        @foreach ($pathology_tests as $item)
                                        <option value="{{ $item->id }}" {{
                                            old('kt_docs_repeater_advanced_pathology.*.pathology')==$item->id ?
                                            'selected' : '' }}>
                                            {{ $item->name }} - {{ number_format($item->price) }} Rs
                                        </option>
                                        @endforeach
                                        @endisset
                                    </select>
                                    @error('kt_docs_repeater_advanced_pathology.*.pathology')
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
                    </div>
                    @endif


                    <div class="mt-3 form-group row">
                        <label class="text-right col-lg-4 col-form-label">
                            Discount Amount <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="number" class="form-control border-end-0" name="discount_percentage"
                                    id="discount_pct" value="{{ old('discount_percentage', 0) }}"
                                    placeholder="Enter Discount %" min="0" max="100" step="1"
                                    oninput="limitDiscount(this)">
                                <span class="bg-transparent input-group-text border-start-0">%</span>
                            </div>
                            <div>
                                @error('discount_percentage')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="form-group row">
                        <label class="text-right col-lg-4 col-form-label">Date</label>
                        <div class="col-lg-5">
                            <input type="date" name="dated" class="form-control" id="dated" min="{{ date('Y-m-d') }}"
                                value="{{ old('dated', now()->format('Y-m-d')) }}">
                            @error('dated')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>


                    <!--end::Form group-->
                    <!--begin::Form group-->
                    <div class="form-group">
                        <a href="javascript:;" data-repeater-create class="btn btn-flex btn-light-primary">
                            <i class="ki-duotone ki-plus fs-3"></i>
                            Add
                        </a>
                    </div>
                    <!--end::Form group-->

                    {{-- @endif --}}

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
