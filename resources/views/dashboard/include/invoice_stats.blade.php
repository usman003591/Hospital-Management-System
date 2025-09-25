<div class="mb-5 row g-5 gx-xl-10 mb-xl-10">
    <!--begin::Col-->
<div class="col-xl-4">
    <a href="{{route('invoices.index')}}">

        <!--begin::Card widget 3-->
<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-60" style="background-color: #01a54e;background-image:url('/metronic8/demo1/assets/media/svg/shapes/wave-bg-red.svg')">
    <!--begin::Header-->
    <div class="pt-5 mb-3 card-header">
        <h1 class="text-white fw-bold fs-2hx"> Daily  </h1>
        <!--begin::Icon-->
        {{-- <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #F1416C">
            <i class="text-white ki-duotone ki-call fs-2qx lh-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></i>
        </div> --}}
        <!--end::Icon-->
    </div>
    <!--end::Header-->

    <!--begin::Card body-->

    <div class="mb-3 card-body d-flex align-items-end">
        <!--begin::Info-->
        <div class="d-flex align-items-center">
            <span class="text-white fs-3hx fw-bold me-6"> {{ $stats['daily']['total_amount'] }} RS</span>
            <div class="text-white fw-bold fs-6">
                <span class="d-block">Total</span>
                <span class="">Amount</span>
            </div>
        </div>
        <!--end::Info-->
    </div>
    <!--end::Card body-->

    <!--begin::Card footer-->
    <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
        <!--begin::Progress-->

        <div class="container">
        <div class="row">
        <div class="col-md-6">
            <div class="py-2 text-white fw-bold">
                <span class="fs-1 d-block">{{ $stats['daily']['discount_amount'] }}</span>
                <span class="opacity-50">Discount Amount</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="py-2 text-white fw-bold">
                <span class="fs-1 d-block">{{ $stats['daily']['received_amount'] }}</span>
                <span class="opacity-50">Received Amount</span>
            </div>
        </div>

        </div>
        </div>



        <!--end::Progress-->
    </div>
    <!--end::Card footer-->
</div>
<!--end::Card widget 3-->
    </a>
</div>
<!--end::Col-->

<!--begin::Col-->
<div class="col-xl-4">
    <a href="{{route('invoices.index')}}">

<!--begin::Card widget 3-->
<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-60" style="background-color: #c31318;background-image:url('/metronic8/demo1/assets/media/svg/shapes/wave-bg-red.svg')">
<!--begin::Header-->
<div class="pt-5 mb-3 card-header">
    <h1 class="text-white fw-bold fs-2hx"> Weekly </h1>
    <!--begin::Icon-->
    {{-- <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #F1416C">
        <i class="text-white ki-duotone ki-call fs-2qx lh-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></i>
    </div> --}}
    <!--end::Icon-->
</div>
<!--end::Header-->

    <!--begin::Card body-->

    <div class="mb-3 card-body d-flex align-items-end">
        <!--begin::Info-->
        <div class="d-flex align-items-center">
            <span class="text-white fs-3hx fw-bold me-6">{{ $stats['weekly']['total_amount'] }} RS</span>
            <div class="text-white fw-bold fs-6">
                <span class="d-block">Total</span>
                <span class="">Amount</span>
            </div>
        </div>
        <!--end::Info-->
    </div>
    <!--end::Card body-->

    <!--begin::Card footer-->
    <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
        <!--begin::Progress-->

        <div class="container">
        <div class="row">
        <div class="col-md-6">
            <div class="py-2 text-white fw-bold">
                <span class="fs-1 d-block">{{ $stats['weekly']['discount_amount'] }}</span>
                <span class="opacity-50">Discount Amount</span>
    </div>
</div>

<div class="col-md-6">
    <div class="py-2 text-white fw-bold">
        <span class="fs-1 d-block">{{ $stats['weekly']['received_amount'] }}</span>
        <span class="opacity-50">Received Amount</span>
    </div>
</div>

</div>
</div>

        <!--end::Progress-->
    </div>
    <!--end::Card footer-->
</div>
<!--end::Card widget 3-->
    </a>
</div>
    <!--end::Col-->

<!--begin::Col-->
<div class="col-xl-4">
    <a href="{{route('invoices.index')}}">
        <!--begin::Card widget 3-->
<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-60" style="background-color: #f5811e;background-image:url('/metronic8/demo1/assets/media/svg/shapes/wave-bg-red.svg')">
    <!--begin::Header-->
    <div class="pt-5 mb-3 card-header">
        <h1 class="text-white fw-bold fs-2hx"> Monthly  </h1>
        <!--begin::Icon-->
        {{-- <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #F1416C">
            <i class="text-white ki-duotone ki-call fs-2qx lh-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></i>
        </div> --}}
        <!--end::Icon-->
    </div>
    <!--end::Header-->

    <!--begin::Card body-->

    <div class="mb-3 card-body d-flex align-items-end">
        <!--begin::Info-->
        <div class="d-flex align-items-center">
            <span class="text-white fs-3hx fw-bold me-6">{{ $stats['monthly']['total_amount'] }} RS</span>
            <div class="text-white fw-bold fs-6">
                <span class="d-block">Total</span>
                <span class="">Amount</span>
            </div>
        </div>
        <!--end::Info-->
    </div>
    <!--end::Card body-->

    <!--begin::Card footer-->
    <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
        <!--begin::Progress-->

        <div class="container">
        <div class="row">
        <div class="col-md-6">
            <div class="py-2 text-white fw-bold">
                <span class="fs-1 d-block">{{ $stats['monthly']['discount_amount'] }}</span>
                <span class="opacity-50">Discount Amount</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="py-2 text-white fw-bold">
                <span class="fs-1 d-block">{{ $stats['monthly']['received_amount'] }}</span>
                <span class="opacity-50">Received Amount</span>
            </div>
        </div>

        </div>
        </div>



        <!--end::Progress-->
    </div>
    <!--end::Card footer-->
</div>
    </a>
<!--end::Card widget 3-->
</div>
    <!--end::Col-->

</div>
@section('scripts')
@endsection
