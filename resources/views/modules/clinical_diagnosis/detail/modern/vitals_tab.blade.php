{{-- <div class="mb-5 card card-xl-stretch mb-xl-12 w-auto" style="width: 73.5rem">
    <form class="form" action="{{ route('clinical_diagnosis.store_vitals', ['cd_id' => $obj->id]) }}" method="POST" enctype="multipart/form-data" novalidate>
        @isset($CdVital)
            {{ method_field('PUT') }}
        @endisset
        @csrf
        <div class="card-body h-auto w-auto">
            <h3 class="mb-6 font-size-lg text-dark font-weight-bold">2. Patient Vitals</h3>

            <div class="form-group row">
                @php
                    $vitalMap = [];
                    if (isset($CdVital)) {
                        foreach ($CdVital as $vitalItem) {
                            $vitalMap[$vitalItem->vital_id] = $vitalItem->value;
                        }
                    }
                @endphp

                @isset($vitals)
                    @foreach ($vitals as $item)
                        @php
                            $value = old("vitals.{$item->id}", $vitalMap[$item->id] ?? '');
                        @endphp

                        <div class="pt-5 col-md-6">
                            <label class="form-label">{{ $item->name }}</label>

                            @if ($item->is_boolean)
                                <select class="form-control form-select" name="vitals[{{ $item->id }}]" data-live-search="true">
                                    <option disabled {{ $value === '' ? 'selected' : '' }}>Select option</option>
                                    <option value="1" {{ $value == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $value == '0' ? 'selected' : '' }}>No</option>
                                </select>
                            @else
                                <input class="form-control" name="vitals[{{ $item->id }}]" type="text" maxlength="50"
                                       placeholder="Enter {{ $item->name }} in {{ $item->unit }}"
                                       value="{{ $value }}">
                            @endif
                        </div>
                    @endforeach
                @endisset
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
</div> --}}



<div class="mb-5 card card-xl-stretch mb-xl-12 w-auto" style="width: 73.5rem">
    <form class="form needs-validation" 
          action="{{ route('clinical_diagnosis.store_vitals', ['cd_id' => $obj->id]) }}" 
          method="POST" enctype="multipart/form-data" novalidate>
        @isset($CdVital)
            {{ method_field('PUT') }}
        @endisset
        @csrf
        <div class="card-body h-auto w-auto">
            <h3 class="mb-6 font-size-lg text-dark font-weight-bold">2. Patient Vitals</h3>

            <div class="form-group row">
                @php
                    $vitalMap = [];
                    if (isset($CdVital)) {
                        foreach ($CdVital as $vitalItem) {
                            $vitalMap[$vitalItem->vital_id] = $vitalItem->value;
                        }
                    }
                @endphp

                @isset($vitals)
                    @foreach ($vitals as $item)
                        @php
                            $value = old("vitals.{$item->id}", $vitalMap[$item->id] ?? '');

                            $pattern = '';
                            $maxlength = 50;
                            $title = "Invalid format for {$item->name}";

                            switch (strtolower($item->name)) {
                                case 'blood pressure':
                                case 'b p':
                                    $pattern = '^\d{1,3}\/\d{1,3}$'; // e.g., 120/80
                                    $maxlength = 7;
                                    $title = "Enter a number (e.g., 120/80)";
                                    break;

                                case 'pulse':
                                case 'pulse rate':
                                    $pattern = '^\d{1,3}$'; // e.g., 75
                                    $maxlength = 3;
                                    $title = "Enter a number (e.g., 75)";
                                    break;

                                case 'temperature':
                                case 'body temperature':
                                    $pattern = '^\d{1,3}(\.\d{1,2})?$'; // allows 98 or 98.6
                                    $maxlength = 7;
                                    $title = "Enter a number (e.g., 98 or 98.6)";
                                    break;
                                

                                case 'respiratory rate':
                                case 'resp':
                                    $pattern = '^\d{1,2}$'; // e.g., 20
                                    $maxlength = 2;
                                    $title = "Enter a number up to 2 digits (e.g., 20)";
                                    break;

                                case 'saturation':
                                case 'spo2':
                                case 'oxygen saturation':
                                    $pattern = '^\d{1,3}$'; // e.g., 95%
                                    $maxlength = 4;
                                    $title = "Enter a number (e.g., 95)";
                                    break;
                            }
                        @endphp

                        <div class="pt-5 col-md-6">
                            <label class="form-label">{{ $item->name }}</label>

                            @if ($item->is_boolean)
                                <select class="form-control form-select" 
                                        name="vitals[{{ $item->id }}]" 
                                        data-live-search="true">
                                    <option disabled {{ $value === '' ? 'selected' : '' }}>Select option</option>
                                    <option value="1" {{ $value == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $value == '0' ? 'selected' : '' }}>No</option>
                                </select>
                            @else
                                <input class="form-control" 
                                       name="vitals[{{ $item->id }}]" 
                                       type="text"
                                       maxlength="{{ $maxlength }}"
                                       placeholder="Enter {{ $item->name }} in {{ $item->unit }}"
                                       value="{{ $value }}"
                                       @if($pattern) pattern="{{ $pattern }}" @endif
                                       title="{{ $title }}">
                                <div class="invalid-feedback">
                                    {{ $title }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endisset
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

{{-- Enable Bootstrap validation --}}
<script>
    (function () {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');

        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                let isValid = true;

                // Check each input with pattern
                form.querySelectorAll('input[pattern]').forEach(function (input) {
                    if (input.value !== '' && !new RegExp(input.getAttribute('pattern')).test(input.value)) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            }, false);
        });
    })();



</script>
