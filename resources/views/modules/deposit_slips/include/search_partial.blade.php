<style>
    #normal_reset {
        background-color: #e9f3ff;
        color: #1b84ff
    }

    #normal_reset:hover {
        background-color: #1b84ff;
        color: white;
    }
</style>
<div class="mb-5 form-group row bg-search">

    <div class="col-lg-7">
        <input type="text" id="q" name="user_name"
            class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
            placeholder="Search Deposit Slip with Name or Slip Number" value="{{$search['q']}}" maxlength="50">
    </div>

    <div class="col-lg-3">
        <select id="hospital" class="form-select ajax_call_trigger form-select-solid bg-body-secondary"
            data-kt-select2="true" data-placeholder="Select Hospital" data-allow-clear="false">
            {{-- <option disabled> {{ __('Select Hospital')}}</option> --}}
            <option selected value="0">Select All Hospital</option>
            @foreach ($hospitals as $item)
            <option value="{{ $item->id }}" {{ (isset($search['hospital']) && $search['hospital']==$item->id)}}>
                {{ $item->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-2 mobile-space">
        <div class="d-flex justify-content-end">
            <button type="button" id="normal_reset" class="px-6 btn btn-sm me-2">Reset</button>
            <button type="button" id="normal_search" class="btn btn-sm btn-primary">Search</button>
        </div>
    </div>

</div>
