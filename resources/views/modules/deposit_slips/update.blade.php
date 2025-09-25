@php $page='deposit_slips'; @endphp
@extends('layouts.master', ['activeMenu' => 'deposit_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])
@section('breadcrumbs')
    <div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
            data-select2-id="select2-data-kt_app_toolbar_container">
            <!--begin::Page title-->
            <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
                <!--begin::Title-->
                <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                    Update Deposit Slip</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bg-gray-500 bullet w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <a href="{{ route('deposit_slips.index') }}">
                        <span></span>
                        <li class="breadcrumb-item text-muted text-hover-primary">Deposit Slips</li>
                    </a>
                    <!--end::Item-->

                    <li class="breadcrumb-item">
                        <span class="bg-gray-500 bullet w-5px h-2px"></span>
                    </li>

                    <a href="{{ route('deposit_slips.edit', $obj->id) }}">
                        <span></span>
                        <li class="breadcrumb-item text-muted text-hover-primary">Update</li>
                    </a>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Toolbar container-->
    </div>
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="mb-5 card card-xl-stretch mb-xl-8">
            <form class="form" action="{{ route('deposit_slips.update', $obj->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $obj->id }}">
                <br>
                <div class="card-body">
                    <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. Deposit Slip Info</h3>
                    <div class="mb-15">
                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Hospital <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">

                                <label
                                    class="text-right col-form-label">{{ getActiveHospitalName($obj->hospital_id) }}</label>
                                <input type="hidden" name="hospital_id" value="{{ $obj->hospital_id }}">

                                <div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">User <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control form-select" name="user_id" data-live-search="true"
                                    id="kt_select2_1">
                                    <option disabled>{{ __('Select User') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id', $obj->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <br>

                        {{-- <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Hospital <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control form-select" name="hospital_id" data-live-search="true">
                                <option disabled>Select Hospital</option>
                                @foreach ($hospitals as $hospital)
                                <option value="{{ $hospital->id }}" {{ old('hospital_id', $obj->hospital_id) ==
                                    $hospital->id ? 'selected' : '' }}>
                                    {{ $hospital->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('hospital_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br> --}}

                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Counter Number <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="counter_number"
                                    value="{{ old('counter_number', $obj->counter_number) }}" maxlength="5">
                                @error('counter_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Amount in Figures <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="number" step="0.01" class="form-control" name="amount_in_figures"
                                    value="{{ old('amount_in_figures', $obj->amount_in_figures) }}" min="0"
                                    oninput="this.value = this.value.replace(/\D/g, '').substring(0, 9)">
                                @error('amount_in_figures')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Amount in Words <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="amount_in_words"
                                    value="{{ old('amount_in_words', $obj->amount_in_words) }}">
                                @error('amount_in_words')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Payment Purpose <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <textarea name="payment_purpose" class="form-control" rows="3" placeholder="Enter Payment Purpose"
                                    maxlength="125">{{ old('payment_purpose', $obj->payment_purpose) }}</textarea>
                                @error('payment_purpose')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-9"></div>
                        <div class="col-lg-3 text-end">
                            <button type="submit" class="mr-2 btn btn-sm btn-primary">Update</button>
                            <a href="{{ route('deposit_slips.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ getAssetsURLs('js/custom/select2_deposit_slips.js') }}" async></script>
@endsection
