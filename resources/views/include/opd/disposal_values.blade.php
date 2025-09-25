<div class="col-md-10">
    <label class="form-label">{{ $label }} <span class="text-danger">*</span></label>
    <select class="mb-2 form-control form-select mb-md-0 selectComplaint"
            name="disposal_type_id"
            data-live-search="true"
            placeholder="{{ $placeholder }}">
        <option selected disabled>{{ __($placeholder) }}</option>
        @foreach ($data as $item)
            <option value="{{ $item['id'] ?? $item->id }}">
                {{ $item['name'] ?? $item->name }}
            </option>
        @endforeach
    </select>
</div>
<br><br>
