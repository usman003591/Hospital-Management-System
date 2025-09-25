<div class="mb-5 card card-xl-stretch mb-xl-8" style="width:73.5rem">
    <form class="form" action="{{ route('clinical_diagnosis.store_procedure', ['cd_id' => $obj->id]) }}" method="POST"
        enctype="multipart/form-data" class="needs-validation" novalidate>
        @isset($CdProcedureData)
            {{ method_field('PUT') }}
            @endif
            @csrf
            <div class="card-body" style="height:auto">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">7. Patient Procedure</h3>
                <div class="mb-15">
                    <!--begin::Repeater-->
                    <div id="kt_docs_repeater_advanced_procedure">
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div data-repeater-list="kt_docs_repeater_advanced_procedure">

                                @if (!is_null($CdProcedureData))
                                    @isset($CdProcedureData)

                                        @foreach ($CdProcedureData as $key => $data)
                                            @php
                                            @endphp

                                            <div data-repeater-item>
                                                <div class="mb-5 form-group row repeater-row-procedure">
                                                    <div class="col-md-10">
                                                        <label class="form-label"> Procedures <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select selectProcedure" name="selectProcedure"
                                                            data-kt-repeater="procedure_select_2"
                                                            data-placeholder="Select procedure">
                                                            <option></option>
                                                            @isset($procedure)
                                                                @foreach ($procedure as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        @if ($item->id === $data->procedure_id) selected @endif>
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                        @error('kt_docs_repeater_advanced_procedure.{{ $key }}.selectProcedure')
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
                                        <div class="mb-5 form-group row repeater-row-procedure">
                                            <div class="col-md-10">
                                                <label class="form-label"> Procedure <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select selectProcedure" name="selectProcedure"
                                                    data-kt-repeater="procedure_select_2"
                                                    data-placeholder="Select procedure">
                                                    <option></option>
                                                    @isset($procedure)
                                                        @foreach ($procedure as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('kt_docs_repeater_advanced_procedure.0.selectProcedure') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('kt_docs_repeater_advanced_procedure.*.selectProcedure')
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
