@php $page='inventory_management'; @endphp
@extends('layouts.master',['activeMenu' => 'pharmacy_management', 'activeSubMenu' =>
'inventory_management','activeThirdMenu' => 'inventory_management'])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <!--begin::Page title-->
           <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <!--begin::Title-->
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Pharmacy Inventory Management</h1>
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <li class="breadcrumb-item text-muted">
                    <a href="" class="text-muted text-hover-primary">Pharmacy</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <a href="{{route('pharmacy.list_pharmacy_inventory')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary"> Pharmacy Inventory</li>
                </a>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <a href="{{ route('pharmacy.create_pharmacy_inventory') }}">
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
        <form class="form" action="{{route('pharmacy.update_pharmacy_inventory', $obj->id)}}" method="POST"
            enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('patch')
            <div class="card-body">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. Pharmacy Inventory Info</h3>
                <div class="mb-15">

                     <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Hospital <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">

                            <label class="text-right col-form-label">{{getActiveHospitalName($obj->hospital_id)}}</label>
                            <input type="hidden" name="hospital_id" value="{{$obj->hospital_id}}">

                            <div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Medicine<span
                                class="text-danger">*</span></label>
                              <div class="col-lg-6">
                                <select class="form-control form-select" name="medicine_id" data-live-search="true"
                                    id="medicineSelect">
                                    <option selected disabled> {{ __('Select Medicine') }}</option>
                                    @isset($medicines)
                                        @foreach ($medicines as $medicine)
                                            <option value="{{ $medicine->id }}" @if($obj->medicine_id == $medicine->id) selected @endif
                                                {{ in_array($medicine->id, old('medicine_id', [])) ? 'selected' : '' }}>
                                                {{ $medicine->name }} </option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('medicine_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                    </div>
                    <br>
                   <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Inventory Status<span
                                class="text-danger">*</span></label>
                              <div class="col-lg-6">
                                <select class="form-control form-select" name="medicine_inventory_status_id" data-live-search="true"
                                    id="medicineSelect">
                                    <option selected disabled> {{ __('Select Inventory Status') }}</option>
                                    @isset($inventory_statuses)
                                        @foreach ($inventory_statuses as $status)
                                            <option value="{{ $status->id }}" @if($obj->medicine_inventory_status_id == $status->id) selected @endif
                                                {{ in_array($status->id, old('medicine_inventory_status_id', [])) ? 'selected' : '' }}>
                                                {{ $status->name }} </option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('medicine_inventory_status_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                    </div>
                    <br>

                    <div class="form-group row">
                    <label class="text-right col-lg-3 col-form-label">Reorder Number<span
                                class="text-danger">*</span></label>
                    <div class="col-lg-6">
                        <input type="number" name="reorder_number"  placeholder="Enter Medicine Reorder Number" class="form-control" id="reorder_number" required oninput="this.value = this.value.replace(/\D/g, '').substring(0, 9)"
                           value="{{ old('reorder_number', $obj->reorder_number) }}">
                        @error('reorder_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <br>




                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3 text-end">
                        <button type="submit" class="mr-2 btn btn-sm btn-primary">Submit</button>
                        <a href="{{route('pharmacy.list_pharmacy_inventory')}}"
                            class="btn btn-sm btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Body-->
    </div>
    <!--end::List Widget 8-->
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
  <script>
$(document).ready(function() {
    $('#medicineSelect').select2({
        placeholder: "Select a medicine",
        allowClear: true
    });
});
    </script>
<script>
    (function () {
    'use strict'

    var forms = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()
</script>
@endsection
