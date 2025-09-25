@php $page='deposit_slips'; @endphp
@extends('layouts.master', ['activeMenu' => 'deposit_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])
@section('breadcrumbs')
    <div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center me-3">
                <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                    Create Deposit Slip</h1>
                <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bg-gray-500 bullet w-5px h-2px"></span>
                    </li>
                    <a href="{{ route('deposit_slips.index') }}">
                        <span></span>
                        <li class="breadcrumb-item text-muted text-hover-primary">Deposit Slips</li>
                    </a>
                    <li class="breadcrumb-item">
                        <span class="bg-gray-500 bullet w-5px h-2px"></span>
                    </li>
                    <a href="{{ route('deposit_slips.create') }}">
                        <span></span>
                        <li class="breadcrumb-item text-muted text-hover-primary">Create</li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="mb-5 card card-xl-stretch mb-xl-8">
            <form class="form" action="{{ route($page . '.store') }}" method="POST" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                @csrf
                <div class="card-body">
                    <h3 class="mb-6 font-size-lg text-dark font-weight-bold">Deposit Slip Information</h3>
                    <div class="mb-15">
                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Hospital <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">

                                <label
                                    class="text-right col-form-label">{{ getActiveHospitalName($preferences['preference']['hospital_id']) }}</label>
                                <input type="hidden" name="hospital_id"
                                    value="{{ $preferences['preference']['hospital_id'] }}">

                                <div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="mb-6 form-group row">
                            <label class="text-right col-lg-3 col-form-label">User <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select class="form-control form-select" name="user_id" data-control="select2"
                                    data-placeholder="Select user">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ "$user->id" === old('user_id') ? 'selected' : '' }}>
                                            {{ $user->name }}

                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="mb-6 form-group row">
                        <label class="text-right col-lg-3 col-form-label">Hospital <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control form-select" name="hospital_id" data-control="select2"
                                data-placeholder="Select Hospital">
                                <option value="">Select Hospital</option>
                                @foreach ($hospitals as $hospital)
                                <option value="{{$hospital->id}}">{{$hospital->name}}</option>
                                @endforeach
                            </select>
                            @error('hospital_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}

                        <div class="mb-6 form-group row">
                            <label class="text-right col-lg-3 col-form-label">Counter Number <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="counter_number" class="form-control"
                                    placeholder="Enter counter number" value="{{ old('counter_number') }}"
                                    maxlength="5" />
                                @error('counter_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6 form-group row">
                            <label class="text-right col-lg-3 col-form-label">Amount in Figures <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="number" name="amount_in_figures" class="form-control"
                                    placeholder="Enter amount in figures" value="{{ old('amount_in_figures') }}"
                                    min="0" oninput="this.value = this.value.replace(/\D/g, '').substring(0, 9)" />
                                @error('amount_in_figures')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="mb-6 form-group row">
                        <label class="text-right col-lg-3 col-form-label">Amount in Words <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" name="amount_in_words" class="form-control"
                                placeholder="Enter Amount in Words" value="{{ old('amount_in_words') }}" />
                            @error('amount_in_words')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}

                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Payment Purpose <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <textarea name="payment_purpose" class="form-control" rows="3" placeholder="Enter payment purpose"
                                    maxlength="125">{{ old('payment_purpose') }}</textarea>
                                @error('payment_purpose')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-9"></div>
                        <div class="col-lg-3 text-end">
                            <button type="submit" class="mr-2 btn btn-primary btn-sm">Generate Slip</button>
                            <a href="{{ route($page . '.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
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
            // Initialize select2
            $('[data-control="select2"]').select2({
                placeholder: $(this).data('placeholder'),
                allowClear: true
            });

            // Auto-generate amount in words when amount in figures changes
            $('input[name="amount_in_figures"]').on('change', function() {
                let amount = $(this).val();
                // You can add a function here to convert number to words
                // or make an AJAX call to backend to get the conversion
            });
        });
    </script>
@endsection
