@php
    $page = 'notification_categories';
    $sc = 'Notification categories';
@endphp

@extends('layouts.master', [
    'activeMenu' => 'notification_management',
    'activeSubMenu' => $page,
    'activeThirdMenu' => $page
])

@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Create {{ $sc }}
            </h1>
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted text-hover-primary">
                    <a href="{{ route('notification_categories.index') }}">{{ titlefilter($page) }}</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted text-hover-primary">Create</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-xl-12">
    <div class="mb-5 card card-xl-stretch mb-xl-8">
        <form class="form" action="{{ route('notification_categories.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">{{ $sc }} Info</h3>

                <div class="form-group row">
                    <label class="text-right col-lg-3 col-form-label">Category Name <span class="text-danger">*</span></label>
                    <div class="col-lg-6">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter name" maxlength="100" required>
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="form-group row">
                    <label class="text-right col-lg-3 col-form-label">Status <span class="text-danger">*</span></label>
                    <div class="col-lg-6">
                        <select name="status" class="form-control" required>
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3 text-end">
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        <a href="{{ route('notification_categories.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
