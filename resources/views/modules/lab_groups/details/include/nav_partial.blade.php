<div class="mb-5 card mb-xxl-8">
    <div class="pb-0 card-body pt-9">
        <!--begin::Details-->
        <div class="flex-wrap d-flex flex-sm-nowrap">
            <!--begin: Pic-->
            <div class="mb-4 me-7">
                {{-- <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="assets/media/avatars/300-1.jpg" alt="image">
                    <div
                        class="bottom-0 mb-6 border border-4 position-absolute translate-middle start-100 bg-success rounded-circle border-body h-20px w-20px">
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
                                class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">@isset($patient->name_of_patient)
                                {{$patient->name_of_patient}}
                                @endisset</a>
                        </div>
                        <!--end::Name-->
                        <!--begin::Info-->
                        <div class="flex-wrap mb-4 d-flex fw-semibold fs-6 pe-2">
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>@isset($patient->patient_category)
                                {{titleFilter($patient->patient_category)}}
                                @endisset</a>
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-geolocation fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>@isset($patient->address)
                                {{ucfirst($patient->address)}}
                                @endisset</a>
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary">
                                <i class="ki-duotone ki-sms fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>@isset($lab_group_data->hospital_name)
                                {{$lab_group_data->hospital_name}}
                                @endisset</a>
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                    <div>
                        <a href="{{route('lab_groups.index')}}" class="btn btn-sm btn-light-primary" >
                            <i class="ki-duotone ki-black-left fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>Back</a>
                    </div>

                </div>
                <!--end::Title-->
                <!--begin::Stats-->
                <div class="flex-wrap d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <!--begin::Stats-->
                        <div class="flex-wrap d-flex">

                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="80"
                                        data-kt-initialized="1">@isset($patient->patient_mr_number)
                                        {{$patient->patient_mr_number}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">MR Number</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">@isset($patient->cnic_number)
                                        {{$patient->cnic_number}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">CNIC</div>
                                <!--end::Label-->
                            </div>

                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">@isset($patient->gender)
                                        {{ucfirst($patient->gender)}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Gender</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->

                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60"
                                        data-kt-countup-prefix="%" data-kt-initialized="1">
                                        @isset($lab_group_data->lab_group_number)
                                        {{$lab_group_data->lab_group_number}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Lab Group Number</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {{-- <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> --}}
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                        data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1">
                                        @isset($lab_group_data->doctor_name)
                                        {{$lab_group_data->doctor_name}}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Doctor Name</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->

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

            <!--end::Nav item-->
            @if(checkPersonPermission('detail_lab_groups_55'))
            {{-- @if(checkPersonPermission('view_section_lab_group_detail_56')) --}}
            <li class="mt-2 nav-item">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @isset($tab) @if($tab == 'lab_tests') active @endif @endisset"
                    href="{{route('lab_groups.lab_tests',$obj->id)}}">Overview</a>
            </li>
            @endif
            <!--begin::Nav item-->

            <li class="mt-2 nav-item">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @isset($tab) @if($tab == 'overview') active @endif @endisset"
                    href="{{route('lab_groups.detail',$obj->id)}}">Stats</a>
            </li>


        </ul>
        <!--begin::Navs-->
    </div>
</div>
