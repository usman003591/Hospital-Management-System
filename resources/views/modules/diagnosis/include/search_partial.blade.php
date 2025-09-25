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

    <div class="col-lg-4">
        <input type="text" id="q" name="user_name"
            class="mb-3 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
            placeholder="Search " value="{{$search['q']}}" maxlength="50">
    </div>


    <div class="col-lg-3">
        <select id="status" class="form-select ajax_call_trigger form-select-solid bg-body-secondary"
            data-kt-select2="true" data-placeholder="Select Status" data-allow-clear="false">
            <option selected disabled> {{ __('Select Status')}}</option>
            <option value="2" {{!isset($search['status']) || $search['status']==2}}>All Statuses</option>
            <option value="1" {{isset($search['status']) && $search['status']==1}}>Active</option>
            <option value="0" {{isset($search['status']) && $search['status']==0}}>Inactive</option>
        </select>
    </div>

    <div class="col-lg-3">
        <select class="form-select ajax_call_trigger form-select-solid bg-body-secondary" data-control="select2"
            id="verification_status" data-placeholder="Select verification status" data-hide-search="true">
            <option {{ !isset($search['verification_status']) || $search['verification_status']==2 ? 'selected' : '' }}
                value="2">All Verification Statuses</option>
            <option {{ isset($search['verification_status']) && $search['verification_status']=='approved' ? 'selected'
                : '' }} value="approved">Approved</option>
            <option {{ isset($search['verification_status']) && $search['verification_status']=='pending' ? 'selected'
                : '' }} value="pending">Pending</option>
            <option {{ isset($search['verification_status']) && $search['verification_status']=='rejected' ? 'selected'
                : '' }} value="rejected">Rejected</option>

        </select>
    </div>


    <div class="col-lg-2 mobile-space">
        <div class="d-flex justify-content-end">
            <button type="button" id="normal_reset" class="px-6 btn btn-sm me-2">Reset</button>
            <button type="button" id="normal_search" class="btn btn-sm btn-primary">Search</button>
        </div>
    </div>

</div>
