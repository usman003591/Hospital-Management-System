<!DOCTYPE html>
<html lang="en" @if(isset($preferences) && $preferences['preference']['theme']==="light" ) data-bs-theme-mode="light"
    @endif @if(isset($preferences) && $preferences['preference']['theme']==="dark" ) data-bs-theme-mode="dark" @endif>
<!--begin::Head-->

<head>
    <title>HMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets\media\logos\logo_without_background_1.png') }}">
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{getAssetsURLs('plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{getAssetsURLs('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" /> --}}
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{getAssetsURLs('plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{getAssetsURLs('plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{getAssetsURLs('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/air-datepicker@3.2.1/air-datepicker.min.css">
    <style>
        <style>
    .custom-toast-body {
        font-size: 1.25rem;     /* Larger text */
        font-weight: bold;      /* Bolder text */
        padding: 1.5rem 1.5rem; /* More padding for height and comfort */
        min-height: 4rem;       /* Minimum height for visibility */
        color: #fff;            /* White text for success/error */
    }
    .toast.text-bg-success {
        background: #198754;    /* Slightly more vivid green */
    }
    .toast.text-bg-danger {
        background: #dc3545;    /* Vivid red */
    }
    </style>
<style>
.table tr {
    cursor: default !important;
    pointer-events: none;
}

.table td,
.table th,
.table .dropdown,
.table .dropdown * {
    pointer-events: auto; /* allow dropdowns/buttons/links to work */
}
</style>
    @livewireStyles
    @yield('styles')

    <style>
        #loader-wrapper{
            position:fixed;
            inset:0;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#ffffff;          /* page bg */
            z-index:9999;
            transition:opacity .3s ease;
        }
        #loader-wrapper.hidden{
            opacity:0;
            pointer-events:none;
        }

        /* Rotate ONLY the ring, not the logo */
        .spinner-ring{          /* <g> containing the circle */
            transform-origin:50% 50%;
            animation:rotate 1.4s linear infinite;
        }
        @keyframes rotate{
            100%{transform:rotate(360deg);}
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" @if(isset($preferences['preference']['layout']))
    @if($preferences['preference']['layout']=='dark_sidebar' ) data-kt-app-layout="dark-sidebar"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" @endif
    @if($preferences['preference']['layout']=='dark_header' ) data-kt-app-layout="dark-header"
    data-kt-app-header-fixed="true" data-kt-app-toolbar-enabled="true" @endif
    @if($preferences['preference']['layout']=='light_header' ) data-kt-app-layout="light-header"
    data-kt-app-header-fixed="true" data-kt-app-toolbar-enabled="true" @endif
    @if($preferences['preference']['layout']=='light_sidebar' ) data-kt-app-layout="light-sidebar"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" @endif @endif class="app-default">

        <div id="loader-wrapper">
            <div style="position: relative; width: 120px; height: 120px;">
                {{-- Animated SVG Loader --}}
                <img src="{{ asset('images/loader.svg') }}"
                    alt="Loading..."
                    style="width: 120px; height: 120px; display: block;">

                {{-- Centered Static Logo on Top --}}
                <img src="{{ asset('images/logo.png') }}"
                    alt="Logo"
                    style="position: absolute;
                            top: 50%; left: 50%;
                            width: 40px; height: 40px;
                            transform: translate(-50%, -50%);">
            </div>
        </div>

        <!--begin::Theme mode setup on page load-->
        <!--end::Theme mode setup on page load-->
        @include('layouts.include.theme_setup')

        @if(isset($preferences['preference']['layout']))
        @if($preferences['preference']['layout'] == 'dark_sidebar')
        @include('layouts.include.vertical_app_content')
        @endif

        @if($preferences['preference']['layout'] == 'dark_header')
        @include('layouts.include.horizontal_app')
        @endif

        @if($preferences['preference']['layout'] == 'light_header')
        @include('layouts.include.horizontal_app')
        @endif

        @if($preferences['preference']['layout'] == 'light_sidebar')
        <div id="app">
        @include('layouts.include.vertical_app_content')
        </div>
        @endif
        @endif


    <script>
    var hostUrl = "assets/";
    </script>
   <script>
        window.addEventListener('load', () => {
            const wrapper = document.getElementById('loader-wrapper');
            if (wrapper){
                wrapper.classList.add('hidden');
                setTimeout(()=>wrapper.remove(), 400);
            }
        });
    </script>
     <!-- Toast container (position it fixed, top right) -->
    @include('include.toaster_messages')
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
    {{-- <script src="{{getAssetsURLs('plugins/custom/datatables/datatables.bundle.js')}}"></script> --}}
    <script src="{{getAssetsURLs('js/widgets.bundle.js')}}"></script>
    <script src="{{getAssetsURLs('js/custom/widgets.js')}}"></script>
    <script src="{{getAssetsURLs('js/custom/apps/chat/chat.js')}}"></script>
    <script src="{{getAssetsURLs('js/custom/utilities/modals/upgrade-plan.js')}}"></script>
    <script src="{{getAssetsURLs('js/custom/utilities/modals/create-app.js')}}"></script>
    <script src="{{getAssetsURLs('js/custom/utilities/modals/new-target.js')}}"></script>
    <script src="{{getAssetsURLs('js/custom/utilities/modals/users-search.js')}}"></script>
    <script src="{{getAssetsURLs('plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.2.1/air-datepicker.min.js"></script>
    <script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('reload-page', () => {
            location.reload(); // 🔄 Reloads full page
        });
    });
</script>
    <script>
        var SITEURL = '{{URL::to('')}}';
                $(document).ready( function () {
                    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(document).ready(function() {
                    $.ajax({
                    url: "{{route('user_preference_hospitals')}}",
                    method: 'get',
                    success: function(result){
                        $('#HospitalsListingDiv').html(result.html);
                    },
                    error: function (data) {
                        console.log('Error:', data.responseText);
                        // var error = data.responseText
                        // Swal.fire("Error!", error, "error");
                    }
                    });
                });

                $('body').on('click', '#addLayoutOutOptions', function (event) {
                    event.preventDefault();
                    var form_data = new FormData(document.getElementById("addLayoutBuilderForm"));
                    $.ajax({
                            data: form_data,
                            url: "{{ route('user_preferences.change')}}",
                            type: "POST",
                            dataType: 'json',
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if(data.status === 200){
                                   var message = data.message
                                   Swal.fire("<span style='color: dimgray;'>Updated</span>", message, "success");
                                    setTimeout(function () {
                                        location.reload(true);
                                    }, 1000);
                                }
                            if(data.status === 400){
                                // var error = data.message
                                // var array = $.map(error, function(value, index) {  return [value]; });
                                // let list = '';
                                // for (var i = 0; i < array.length; i++)
                                // list += array[i] + '\n <br>';
                                // Swal.fire("Error!",list, "error");
                                // $("#domains-grid").load(location.href + " #domains-grid>*", "");
                            }
                            if(data.status === 409){
                                // var error = data.message
                                // Swal.fire("Error!", error, "error");
                            }
                            },
                           error: function (data) {
                               console.log('Error:', data.responseText);
                            //     var error = data.responseText
                            //     Swal.fire("Error!", error, "error");
                            }
                    });
                        //Ajax code ends here
                });

            });
</script>
@yield('scripts')
@livewireScripts
@stack('scripts')




<script>
    function reinitializeMetronicComponents() {
        // Reinitialize KTMenu
        if (typeof KTMenu !== 'undefined') {
            document.querySelectorAll('[data-kt-menu="true"]').forEach(el => {
                const instance = KTMenu.getInstance(el);
                if (instance) instance.destroy();
            });
            KTMenu.createInstances();
        }

        // Reinitialize Bootstrap Tooltips (if you're using them)
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Add any other plugin reinitializations here (e.g. flatpickr, select2, etc.)
    }

    // Livewire hook to refresh JS after render
    Livewire.hook('message.processed', () => {
        reinitializeMetronicComponents();
    });

    // Run on page load too
    document.addEventListener("DOMContentLoaded", reinitializeMetronicComponents);
</script>
<script>
    window.addEventListener('force-page-reload', function () {
        window.location.reload(); // Full browser reload (like F5)
    });
</script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}

</body>
<!--end::Body-->

</html>
