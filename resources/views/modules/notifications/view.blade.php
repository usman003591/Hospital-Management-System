@php
$page = 'notifications';
$sc = 'Notifications';
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
                {{ $sc }}
            </h1>
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted text-hover-primary">
                    <a href="{{ route('notifications.index') }}">{{ titlefilter($page) }}</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted text-hover-primary">All Notifications</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('content')

<livewire:notifications.view-all-notifications />
@endsection

