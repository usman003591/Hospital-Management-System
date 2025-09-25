<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>HMS</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('assets\media\logos\logo_without_background_1.png') }}" >
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="{{getAssetsURLs('plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{getAssetsURLs('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{getAssetsURLs('plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{getAssetsURLs('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        @yield('styles')
        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        {{-- @livewireStyles --}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            {{-- @include('layouts.navigation') --}}

            <!-- Page Heading -->
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-4">
                        <div class="app-sidebar-logo px-3" id="kt_app_sidebar_logo">
							<!--begin::Logo image-->
							<a href="{{url('/')}}">
								<img alt="Logo" src="{{ asset('assets\media\logos\logo_without_background_1.png') }}" class="h-50px app-sidebar-logo-default">
								<img alt="Logo" src="{{ asset('assets\media\logos\logo_without_background_1.png') }}" class="h-50px app-sidebar-logo-minimize">
							</a>
						</div>
                    </div>
                </header>

                <br>
                <br>
            <!-- Page Content -->
            <main>
                <div class="container">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
                {{-- {{ $slot }} --}}
            </main>
        </div>

        <script>var hostUrl = "assets/";</script>
		<script src="{{getAssetsURLs('plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{getAssetsURLs('js/scripts.bundle.js')}}"></script>
		<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		{{-- <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script> --}}
		<script src="{{getAssetsURLs('plugins/custom/datatables/datatables.bundle.js')}}"></script>
		<script src="{{getAssetsURLs('js/widgets.bundle.js')}}"></script>
		<script src="{{getAssetsURLs('js/custom/widgets.js')}}"></script>
		<script src="{{getAssetsURLs('js/custom/apps/chat/chat.js')}}"></script>
		<script src="{{getAssetsURLs('js/custom/utilities/modals/upgrade-plan.js')}}"></script>
		<script src="{{getAssetsURLs('js/custom/utilities/modals/create-app.js')}}"></script>
		<script src="{{getAssetsURLs('js/custom/utilities/modals/new-target.js')}}"></script>
		<script src="{{getAssetsURLs('js/custom/utilities/modals/users-search.js')}}"></script>
        {{-- @livewireScripts --}}
    </body>
</html>
