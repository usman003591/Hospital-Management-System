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
            placeholder="Search" value="{{$search['q']}}" maxlength="50">
    </div>

    <div class="col-lg-3">
        <select id="parent_id" class="form-select ajax_call_trigger form-select-solid bg-body-secondary"
            data-kt-select2="true" data-placeholder="Filter By Parent">
            <option value=" ">All Complaints</option>
            <option value="0" {{ isset($search['parent_id']) && $search['parent_id']==='0' ? 'selected' : '' }}>Parent
                Complaints Only</option>
            @foreach($parentComplaints as $complaint)
            <option value="{{ $complaint->id }}" {{ isset($search['parent_id']) &&
                (string)$search['parent_id']===(string)$complaint->id ? 'selected' : '' }}>
                {{ $complaint->name }}
            </option>
            @endforeach
        </select>
    </div>
    
    <div class="col-lg-3">
        <select class="form-select ajax_call_trigger form-select-solid bg-body-secondary" data-control="select2"
            id="verification_status" data-placeholder="Select verification status" data-hide-search="true">
            <option {{ !isset($search['verification_status']) || $search['verification_status']==2 ? 'selected' : '' }}
                value="2">All Verification Statuses</option>
            <option {{ isset($search['verification_status']) && $search['verification_status']=='approved' ? 'selected' : ''
                }} value="approved">Approved</option>
            <option {{ isset($search['verification_status']) && $search['verification_status']=='pending' ? 'selected' : ''
                }} value="pending">Pending</option>
            <option {{ isset($search['verification_status']) && $search['verification_status']=='rejected' ? 'selected' : ''
                }} value="rejected">Rejected</option>

        </select>
    </div>

    <div class="col-lg-2 mobile-space">
        <div class="mt-1 d-flex justify-content-end">
            <button type="button" id="normal_reset" class="px-6 btn btn-sm me-2">Reset</button>
            <button type="button" id="normal_search" class="btn btn-sm btn-primary">Search</button>
        </div>
    </div>

</div>
