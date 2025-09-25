<div class="mb-5 card mb-xxl-8">
    <div class="pb-0 card-body pt-9">
        <!--begin::Details-->
        <div class="flex-wrap d-flex flex-sm-nowrap">
            <!--begin: Pic-->
            <div class="mb-4 me-7">
                {{-- <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="assets/media/avatars/300-1.jpg" alt="image">
                    <div
                        class="bottom-0 mb-6 border-4 position-absolute translate-middle start-100 bg-success rounded-circle border-body h-20px w-20px">
                    </div>
                </div> --}}
            </div>
            <!--end::Pic-->
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="flex-wrap mb-2 d-flex justify-content-between align-items-start">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->

                        <div class="mb-2 d-flex align-items-center">
                            <a href="#"
                                class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">Name : @isset($investigation->name)
                                {{$investigation->name}}
                                @endisset</a>
                        </div>
                        <!--end::Name-->
                        <!--begin::Info-->
                        <div class="flex-wrap mb-4 d-flex fw-semibold fs-6 pe-2">
                            @isset($investigation->description)
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                               Description : {{$investigation->description}}
                            </a>@endisset
                            @isset($patient->address)
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-geolocation fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ucfirst($patient->address)}}
                                </a>@endisset
                                @isset($patient->email)
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary">
                                <i class="ki-duotone ki-sms fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{$patient->email}}
                                </a>@endisset
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                    <div class="d-flex my-4">
                           <livewire:investigations.add-investigation-price :investigation-id="$investigation->id" :investigation-name="$investigation->name" />
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Title-->
                <!--begin::Stats-->
                <div class="flex-wrap d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <!--begin::Stats-->
                        <div class="flex-wrap d-flex">
                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Progress-->
                    {{-- <div class="mt-3 d-flex align-items-center w-200px w-sm-300px flex-column">
                        <div class="mt-auto mb-2 d-flex justify-content-between w-100">
                            <span class="text-gray-500 fw-semibold fs-6">Profile Compleation</span>
                            <span class="fw-bold fs-6">50%</span>
                        </div>
                        <div class="mx-3 mb-3 h-5px w-100 bg-light">
                            <div class="rounded bg-success h-5px" role="progressbar" style="width: 50%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div> --}}
                    <!--end::Progress-->
                </div>
                <!--end::Stats-->
            </div>

            <!--end::Info-->
        </div>

        <!--end::Details-->
        <!--begin::Navs-->
        <br>
        <ul class="border-transparent nav nav-stretch nav-line-tabs nav-line-tabs-2x fs-5 fw-bold">
            <!--begin::Nav item-->
            <li class="mt-2 nav-item">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @isset($tab) @if($tab == 'prices') active @endif @endisset"
                    href="{{route('investigations.details',$investigation->id)}}">Prices</a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->

        </ul>
        <!--begin::Navs-->
    </div>
</div>
