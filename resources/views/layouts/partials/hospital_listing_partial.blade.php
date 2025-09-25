<div class="form-group">
    <div class="mb-6">
        <h4 class="text-gray-900 fw-bold">Select Hospital</h4>
    </div>
    <div class="col-lg-12">
        <select class="mb-2 form-control mb-md-0 selectComplaint" name="hospital_id"
            data-live-search="true" id="symptomSelect" placeholder="Select Hospital">
            <option selected disabled> {{ __('Select Hospital')}}</option>
            @isset($hospitals)
            @foreach ($hospitals as $item)
            <option value="{{$item->id}}" @if($preferences['preference']['hospital_id'] == $item->id) selected @endif> {{$item->name}} </option>
            @endforeach
            @endisset
        </select>
    </div>
</div>
