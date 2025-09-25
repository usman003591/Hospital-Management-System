<div class="w-auto mb-5 card card-xl-stretch mb-xl-12" style="width: 73.5rem">
    <form class="form" action="{{ route('clinical_diagnosis.registration_vitals_form', ['cd_id' => $obj->id]) }}" method="POST" enctype="multipart/form-data" novalidate>
        @isset($CdVital)
            {{ method_field('PUT') }}
        @endisset
        @csrf
        <div class="w-auto h-auto card-body">
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
                    <a href="{{ route('clinical_diagnosis.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
