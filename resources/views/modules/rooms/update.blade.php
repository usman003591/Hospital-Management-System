@php $page='rooms';
$sc = 'Room';
@endphp
@extends('layouts.master',['activeMenu' => 'hospital_setups_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])
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
                <a href="{{route('rooms.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{ titlefilter($page) }}</li>
                </a>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <a href="{{route('rooms.edit', $obj->id)}}">
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
                        <label class="text-right col-lg-3 col-form-label">Room Number <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="number" name="room_number" class="form-control" value="{{ $obj->room_number }}"
                                placeholder="Enter room number"/>
                            {{-- <span class="form-text text-muted">Please enter your full name</span> --}}
                            <div>
                                @error('room_number')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>



                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Description <span
                                    class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea name="room_description" class="form-control" rows="5"
                                placeholder="Enter description">{{ $obj->room_description }}</textarea>
                            @error('room_description')
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
