@php $page='investigations';
$sc = 'Investigations';
@endphp
@extends('layouts.master',['activeMenu' => 'settings_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <!--begin::Page title-->
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <!--begin::Title-->
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Create {{ $sc }}</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <a href="{{route('investigations.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Investigations</li>
                </a>
                <!--end::Item-->

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{route('investigations.create')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Create</li>
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

    <!--begin::List Widget 8-->
    <div class="mb-5 card card-xl-stretch mb-xl-8">
        <!--begin::Header-->

        <!--end::Header-->


        <!--begin::Body-->
        <form class="form" action="{{route($page.'.store')}}" method="POST" enctype="multipart/form-data"
            class="needs-validation" novalidate>
            @csrf
            <div class="card-body">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. {{ $sc }} Info</h3>
                <div class="mb-15">

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label"> Name <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Enter investigation name" maxlength="200"
                                oninput="this.value = this.value.replace(/[^a-zA-Z\s.{,-/}{0-9}]/g, '');" />
                            <div>
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Description</label>
                        <div class="col-lg-6">
                            <textarea name="description" class="form-control" id="description" cols="30" rows="5"
                                maxlength="250" placeholder="Enter description"></textarea>
                            <div>
                                @error('description')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>


                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Investigation Types <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="mb-2 form-control mb-md-0 selectComplaint" name="type_id"
                                data-live-search="true" id="symptomSelect" placeholder="Select Type"
                                value="{{ old('type_id') }}">
                                <option selected disabled> {{ __('Select Type')}}</option>
                                @isset($types)
                                @foreach ($types as $item)
                                <option value="{{$item->id}}"> {{$item->name}} </option>
                                @endforeach
                                @endisset
                            </select>
                            <div>
                                @error('type_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label"> Price <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}"
                                placeholder="Enter investigation price" maxlength="200"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                            <div>
                                @error('price')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br> --}}

                    {{-- <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label"> Price Valid from <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="date" name="valid_from" class="form-control" value="{{ old('valid_from') }}"
                                placeholder="Select Investigation From date" maxlength="200"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                            <div>
                                @error('price')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br> --}}


                    {{-- <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label"> Price Valid till <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="date" name="valid_to" class="form-control" value="{{ old('valid_to') }}"
                                placeholder="Select Investigation till date" maxlength="200"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                            <div>
                                @error('valid_to')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br> --}}

                    <div class="form-group row">
                        <label class="text-right col-lg-3 col-form-label">Is Lab Test Available In House <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control form-select" name="is_in_house" data-live-search="true"
                                id="deviceSelect">
                                <option selected disabled> {{ __('Select Status')}}</option>
                                <option value="1"> Available </option>
                                <option value="0"> Not Available </option>
                            </select>
                            <div>
                                @error('is_in_house')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
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
                        <a href="{{route($page.'.index')}}" class="btn btn-sm btn-secondary">Cancel</a>
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
{{-- <script>
    function capitalizeWords(input) {
        let words = input.value.toLowerCase().split(' ');
        for (let i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
        }
        input.value = words.join(' ');
    }
</script> --}}
@endsection
