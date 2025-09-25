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
            placeholder="Search Doctor" value="{{$search['q'] ?? ''}}" maxlength="50">
    </div>

    <div class="col-lg-3">
        <select id="status" class="form-select ajax_call_trigger form-select-solid bg-body-secondary"
            data-kt-select2="true" data-placeholder="Select Status" data-allow-clear="false">
            {{-- <option selected disabled> {{ __('Select Status')}}</option> --}}
            <option value="2" {{!isset($search['status']) || $search['status']==2}}>Select All Status</option>
            <option value="1" {{isset($search['status']) && $search['status']==1}}>Active</option>
            <option value="0" {{isset($search['status']) && $search['status']==0}}>Inactive</option>
        </select>
    </div>

    <div class="col-lg-3">
        <select id="department"
            class="form-select ajax_call_trigger form-select-solid bg-body-secondary" data-kt-select2="true"
            data-placeholder="Select Department" data-allow-clear="false">
            {{-- <option selected disabled> {{ __('Select All Department')}}</option> --}}
            <option selected value="0">All Departments</option>
            @foreach($departments as $department)
            <option value="{{ $department->id }}" {{ (isset($search['department']) &&
                $search['department']==$department->id)}}>
                {{ $department->name }}
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
