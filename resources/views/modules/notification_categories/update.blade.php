@php
    $page = 'notification_categories';
    $sc = 'Notification Category';
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
                Update {{ $sc }}
            </h1>
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item"><span class="bg-gray-500 bullet w-5px h-2px"></span></li>
                <a href="{{ route($page . '.index') }}">
                    <li class="breadcrumb-item text-muted text-hover-primary">{{ titlefilter($page) }}</li>
                </a>
                <li class="breadcrumb-item"><span class="bg-gray-500 bullet w-5px h-2px"></span></li>
                <a href="{{ route($page . '.edit', $obj->id) }}">
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
<form class="form" action="{{ route('notification_categories.update', $obj->id) }}" method="POST">
            @csrf
              @method('PATCH')

            <input type="hidden" name="id" value="{{ $obj->id }}">

            <div class="card-body">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">{{ $sc }} Info</h3>
                <div class="mb-15">

                    {{-- Category Name --}}
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Category Name <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $obj->name) }}" placeholder="Enter category name" maxlength="100" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <br>

                    {{-- Status --}}
                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Status <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control form-select" name="status" required>
                                <option disabled {{ is_null($obj->status) ? 'selected' : '' }}>Select Status</option>
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

            {{-- Buttons --}}
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3 text-end">
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        <a href="{{ route($page . '.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
