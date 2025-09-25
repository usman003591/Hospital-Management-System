         <!--begin::Label-->
         <label class="mt-3 fs-6 fw-semibold form-label">
            <span class="required">Doctors</span>
        </label>
        <!--end::Label-->
        <div class="w-100">
            <!--begin::Select2-->
            <select class="form-select form-select-solid" id="DoctorId"
                value="{{ old('doctor_id') }}" name="doctor_id" tabindex="-1"
                aria-hidden="true">
                <option disabled selected> Select Doctor </option>
                @isset($doctors)
                    @foreach ($doctors as $hos)
                        <option value="{{ $hos->id }}">{{ $hos->doctor_name }}</option>
                    @endforeach
                @endisset
            </select>
            <!--end::Select2-->
        </div>

        <div
            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
            @error('doctor_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
