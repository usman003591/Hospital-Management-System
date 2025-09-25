<div class="mb-5 card card-xl-stretch mb-xl-12" style="width: 73.5rem">
    <form class="form" action="{{ route('clinical_diagnosis.store_brief_history', ['cd_id' => $obj->id]) }}"
        method="POST" enctype="multipart/form-data">
        @isset($cdCdBriefHistory)
            {{ method_field('PUT') }}
            @endif
            @csrf
            <div class="card-body" style="height:auto;">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">3. Patient Brief History</h3>

                @if (!is_null($cdCdBriefHistory))
                    <div class="form-group row">
                        <div class="pt-5 col-md-12">
                            <label class="form-label">Brief History <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="value" rows="10" cols="50" maxlength="1000"
                                oninput="updateCharCount(this)" placeholder="Enter brief history">@if ($cdCdBriefHistory->value){{ $cdCdBriefHistory->value }}@endif</textarea>
                            <small class="text-muted" id="charCount">0/1000 characters</small>
                        </div>
                        @error('value')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                @else
                    <div class="form-group row">
                        <div class="pt-5 col-md-12">
                            <label class="form-label">Brief History <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="value" rows="9" cols="50" maxlength="1000"
                                oninput="updateCharCount(this)" placeholder="Enter brief history">{{ old('kt_docs_repeater_advanced_treatment.0.remarks')}}</textarea>
                            <small class="text-muted" id="charCount">0/1000 characters</small>
                        </div>
                    </div>
                    @error('value')
                            <small class="text-danger">{{ $message }}</small>
                    @enderror
                @endif

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
        function updateCharCount(textarea) {
            const maxLength = textarea.getAttribute('maxlength');
            const currentLength = textarea.value.length;
            const charCountElement = document.getElementById('charCount');
            charCountElement.textContent = `${currentLength}/${maxLength} characters`;
        }

        // Initialize character count on page load
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.querySelector('textarea[name="value"]');
            if (textarea) {
                updateCharCount(textarea);
            }
        });
    </script>
