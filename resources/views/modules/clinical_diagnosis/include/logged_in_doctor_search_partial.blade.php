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
    <div class="col-lg-6">
        <input type="text" id="q" name="user_name"
            class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
            placeholder="Search Patient Name or MR Number or Mobile Number" value="{{$search['q']}}" maxlength="50">
    </div>

    <div class="col-lg-3">
        <select id="status" class="ajax_call_trigger form-select form-select-solid bg-body-secondary"
            data-kt-select2="true" data-placeholder="Select Status" data-allow-clear="false">
            {{-- <option disabled > {{ __('Select Status')}}</option> --}}
            <option selected value="2" {{!isset($search['status']) || $search['status']==2}}>Select All Status</option>
            <option value="pending" {{isset($search['status']) && $search['status']=='pending' }}>Pending</option>
            <option value="referred" {{isset($search['status']) && $search['status']=='referred' }}>Referred</option>
            <option value="completed" {{isset($search['status']) && $search['status']=='completed' }}>Completed</option>
            <option value="cancelled" {{isset($search['status']) && $search['status']=='cancelled' }}>Cancelled</option>
        </select>
    </div>

    <div class="col-lg-1">
    </div>

    <div class="col-lg-2 mobile-space">
        <div class="mt-1 d-flex justify-content-end">
            <button type="button" id="normal_reset" class="px-6 btn btn-sm me-2">Reset</button>
            <button type="button" id="normal_search" class="btn btn-sm btn-primary">Search</button>
        </div>
    </div>
</div>
