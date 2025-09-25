@php $page='pathology_invoices'; @endphp
@extends('layouts.master',['activeMenu' => 'finance_management', 'activeSubMenu' => 'verification', 'activeThirdMenu' => $page])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                {{titleFilter($page)}} List</h1>
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a>
                </li>

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a>
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Finance</li>
                </a>

                 <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a>
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Verification</li>
                </a>

                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>

                <a href="{{route('finance.pathology_invoices_verification')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{titleFilter($page)}}</li>
                </a>
            </ul>
        </div>

        <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
        </div>

    </div>
</div>
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('include.messages')
            @include('modules.finance.verification.pathology.include.nav_partial')
            @include('modules.finance.verification.pathology.include.audit_logs')
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="{{getAssetsURLs('js/custom/helper_scripts.js')}}"></script>
@endsection
