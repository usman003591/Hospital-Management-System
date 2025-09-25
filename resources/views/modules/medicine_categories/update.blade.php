@php $page='medicine_categories'; @endphp
@extends('layouts.master',['activeMenu' => 'pharmacy_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Update Medicine Category
            </h1>
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <a href="{{route('medicine_categories.index')}}">
                    <li class="breadcrumb-item text-muted text-hover-primary">{{titleFilter($page)}}</li>
                </a>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <a href="{{route('medicine_categories.edit', $obj->id)}}">
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
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. Medicine Category Info</h3>
                <div class="mb-15">

                    <!-- Category Name -->
                    <div class="mb-6 form-group row">
                        <label class="text-right col-lg-3 col-form-label">Medicine Category Name <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" name="name" class="form-control" value="{{ $obj->name }}"
                                   maxlength="50" />
                            @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-6 form-group row">
                        <label class="text-right col-lg-3 col-form-label">Status <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select name="status" class="form-select" data-control="select2" data-placeholder="Select Status">
                                <option value="1" {{ $obj->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $obj->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-6 form-group row">
                        <label class="text-right col-lg-3 col-form-label">Image</label>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                @if($obj->hasImage())
                                    <div class="mb-3">
                                        <img src="{{ $obj->getImageUrlAttribute() }}" alt="Current Image" class="img-fluid" style="max-height: 150px;">
                                    </div>
                                @endif
                            </div>
                            <input type="file" name="image" class="form-control" accept="image/*"/>
                            <small class="text-muted">Supported formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                            @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3 text-end">
                        <button type="submit" class="mr-2 btn btn-sm btn-primary">Update</button>
                        <a href="{{route($page.'.index')}}" class="btn btn-sm btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.form-select').select2({
            minimumResultsForSearch: 10
        });
    });
</script>
@endsection
