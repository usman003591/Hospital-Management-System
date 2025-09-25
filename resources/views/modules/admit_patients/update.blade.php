@php $page='admit_patients';
$sc = 'Admit Patient';
@endphp
@extends('layouts.master',['activeMenu' => 'settings_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Update {{ $sc }}</h1>
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <a href="{{route('admit_patients.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{ titlefilter($page) }}</li>
                </a>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <a href="{{route('admit_patients.edit', $obj->id)}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Update</li>
                </a>
            </ul>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="col-xl-12">
    <div class="mb-5 card card-xl-stretch mb-xl-8">
        <form class="form" action="{{route($page.'.update',$obj->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="card-body">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">{{ $sc }} Info</h3>
                <div class="mb-15">
                    <!-- Ward, Room, Bed, Department selections remain unchanged -->
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Ward <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select name="ward_id" class="form-control" required>
                                <option value="">Select Ward</option>
                                @foreach($wards as $ward)
                                    <option value="{{ $ward->id }}" {{ $obj->ward_id == $ward->id ? 'selected' : '' }}>
                                        {{ $ward->ward_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ward_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Room <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select name="room_id" class="form-control" required>
                                <option value="">Select Room</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ $obj->room_id == $room->id ? 'selected' : '' }}>
                                        {{ $room->room_number }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Bed <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select name="bed_id" class="form-control" required>
                                <option value="">Select Bed</option>
                                @foreach($beds as $bed)
                                    <option value="{{ $bed->id }}" {{ $obj->bed_id == $bed->id ? 'selected' : '' }}>
                                        {{ $bed->bed_number }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bed_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Department <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select name="department_id" class="form-control" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ $obj->department_id == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <!-- Updated date fields -->
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Admission Date <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" name="admission_date" id="admissionDate" class="form-control datetimepicker"
                                value="{{ $obj->admission_date ? \Carbon\Carbon::parse($obj->admission_date)->format('d/m/Y H:i') : '' }}"
                                required placeholder="DD/MM/YYYY HH:mm"/>
                            @error('admission_date')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Discharge Date</label>
                        <div class="col-lg-6">
                            <input type="text" name="discharge_date" id="dischargeDate" class="form-control datetimepicker"
                                value="{{ $obj->discharge_date ? \Carbon\Carbon::parse($obj->discharge_date)->format('d/m/Y H:i') : '' }}"
                                placeholder="DD/MM/YYYY HH:mm" />
                            @error('discharge_date')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Remarks</label>
                        <div class="col-lg-6">
                            <textarea name="remarks" class="form-control" rows="5"
                                placeholder="Enter remarks">{{ $obj->remarks }}</textarea>
                            @error('remarks')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Status <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control form-select" name="status" data-live-search="true">
                                <option selected disabled>{{ __('Select Status')}}</option>
                                <option value="1" {{ $obj->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $obj->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3 text-end">
                        <button type="submit" class="mr-2 btn btn-sm btn-primary">Submit</button>
                        <a href="{{route($page.'.index')}}" class="btn btn-sm btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<!-- Include flatpickr CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     flatpickr(".datetimepicker", {
    //         enableTime: true,
    //         dateFormat: "d-m-Y H:i:S",
    //         time_24hr: true
    //     });
    // });

    $(document).ready(function() {
        function loadRooms(wardId, selectedRoomId = null) {
            if (wardId) {
                $.ajax({
                    url: "{{ route('beds.getRooms') }}",
                    type: "GET",
                    data: {
                        ward_id: wardId,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: "json",
                    success: function(data) {
                        var roomSelect = $('select[name="room_id"]');
                        roomSelect.empty();
                        roomSelect.append('<option value="">Select Room</option>');
                        $.each(data, function(key, value) {
                            var selected = (selectedRoomId && selectedRoomId == value.id) ? 'selected' : '';
                            roomSelect.append('<option value="' + value.id + '" ' + selected + '>' + value.room_number + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="room_id"]').empty();
                $('select[name="room_id"]').append('<option value="">Select Room</option>');
            }
        }

        // Ward selection change event
        $('select[name="ward_id"]').on('change', function() {
            var wardId = $(this).val();
            loadRooms(wardId);
        });

        // Load rooms for pre-selected ward on page load
        var initialWardId = $('select[name="ward_id"]').val();
        var initialRoomId = {{ $obj->room_id }};
        if (initialWardId) {
            loadRooms(initialWardId, initialRoomId);
        }
    });
</script>
<script>
    new AirDatepicker('#admissionDate', {
    dateFormat: 'dd/MM/yyyy',
    timepicker: true,
    timeFormat: 'HH:mm', // Use 'hh:mm AA' for AM/PM format
    autoClose: true,
    minDate: new Date(1900, 0, 1),
    maxDate: new Date(),
    locale: {
        days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        today: 'Today',
        clear: 'Clear',
        dateFormat: 'dd/MM/yyyy',
        timeFormat: 'hh:mm aa',
        firstDay: 0
    }
});
new AirDatepicker('#dischargeDate', {
    dateFormat: 'dd/MM/yyyy',
    timepicker: true,
    timeFormat: 'HH:mm', // Use 'hh:mm AA' for AM/PM format
    autoClose: true,
    minDate: new Date(),
    maxDate: new Date(2200, 0, 1),
    locale: {
        days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        today: 'Today',
        clear: 'Clear',
        dateFormat: 'dd/MM/yyyy',
        timeFormat: 'hh:mm aa',
        firstDay: 0
    }
});

</script>
@endsection
