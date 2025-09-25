
@if(session()->has('info'))
<div class="msg">
    <!--begin::Alert-->
    <div class="p-5 alert alert-info d-flex align-items-center">
        <!--begin::Icon-->
        <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span
                class="path2"></span></i>
        <!--end::Icon-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            {{-- <h4 class="mb-1 text-dark">This is an alert</h4> --}}
            <!--end::Title-->
            <!--begin::Content-->
            <span> {{ session()->get('info') }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
</div>
@endif

@if(session()->has('warning'))
<div class="msg">
    <!--begin::Alert-->
    <div class="p-5 alert alert-warning d-flex align-items-center">
        <!--begin::Icon-->
        <i class="ki-duotone ki-shield-tick fs-2hx text-warning me-4"><span class="path1"></span><span
                class="path2"></span></i>
        <!--end::Icon-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            {{-- <h4 class="mb-1 text-dark">This is an alert</h4> --}}
            <!--end::Title-->
            <!--begin::Content-->
            <span> {{ session()->get('warning') }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
</div>
@endif

@if(session()->has('success'))
<div class="msg">
    <!--begin::Alert-->
    <div class="p-5 alert alert-success d-flex align-items-center">
        <!--begin::Icon-->
        <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span
                class="path2"></span></i>
        <!--end::Icon-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            {{-- <h4 class="mb-1 text-dark">This is an alert</h4> --}}
            <!--end::Title-->
            <!--begin::Content-->
            <span> {{ session()->get('success') }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
</div>
@endif

{{-- @if(session()->has('error'))
<div class="alert alert-danger" role="alert">
    {{ session()->get('error') }}
</div>
@endif --}}

@if(session()->has('error'))
<div class="msg">
    <!--begin::Alert-->
    <div class="p-5 alert alert-danger d-flex align-items-center">
        <!--begin::Icon-->
        <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span
                class="path2"></span></i>
        <!--end::Icon-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            {{-- <h4 class="mb-1 text-dark">This is an alert</h4> --}}
            <!--end::Title-->
            <!--begin::Content-->
            <span> {{ session()->get('error') }}.</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
</div>
@endif

<script>
    setTimeout(function() {
    $('.msg').fadeOut('fast');
    }, 2000);
</script>
