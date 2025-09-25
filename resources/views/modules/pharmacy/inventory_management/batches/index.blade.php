@php $page='inventory_management'; @endphp
@extends('layouts.master',['activeMenu' => 'pharmacy_management', 'activeSubMenu' => 'inventory_management','activeThirdMenu' => 'inventory_management'])
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack"
        data-select2-id="select2-data-kt_app_toolbar_container">
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
            @isset($medicine) {{$medicine->name}} Medicine Batches @endisset
           </h1>
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
                <a ><span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">@isset($medicine) {{$medicine->name}}  Batches @endisset</li>
                </a>
            </ul>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('include.messages')
            @include('modules.pharmacy.inventory_management.batches.include.navbar_partial')
            <livewire:pharmacy.batches.batches-listing :medicineId="$medicine->id" :medicineName="$medicine->name">
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{getAssetsURLs('js/custom/helper_scripts.js')}}"></script>
@endsection
