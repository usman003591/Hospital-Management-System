
      @php
            $doctorPanelValue = checkDoctorPanelVal();
            @endphp
            {{-- @if ($doctorPanelValue) --}}
<form id="globalSearchForm" action="{{ route('global.search') }}" method="GET">
    <div class="container">
        <div class="gap-4 d-flex justify-content-end" style="margin-right: 10px">

            {{-- <div class="">
                <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-start">
                    Search Patient Record or OPD
                </h1>
            </div> --}}

            <div class="flex-1 col-4">
                <div class="input-group">
                    <span class="bg-white input-group-text border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="search_query" name="query"
                        class="form-control form-control-sm border-start-0"
                        placeholder="Search By MR Number or CNIC or Mobile Number" aria-label="Search" maxlength="25" />
                </div>
            </div>

            <div>
                <select class="form-select form-select-sm" id="module" name="module">
                    {{-- <option selected disabled>Select</option> --}}
                    <option value="patients">Patients</option>
                    <option value="clinical_diagnoses" selected>OPD</option>
                </select>
            </div>

            <div class="flex-1 col-1">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 85%;">Search</button>
            </div>

        </div>
    </div>
</form>

            {{-- @endif --}}

