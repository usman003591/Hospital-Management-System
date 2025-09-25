<!--begin::App layout builder-->
<div id="kt_app_layout_builder" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="app-settings"
    data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '380px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_layout_builder_toggle"
    data-kt-drawer-close="#kt_app_layout_builder_close">
    <!--begin::Card-->
    <div class="border-0 shadow-none card rounded-0 w-100">
        <!--begin::Form-->
        <form id="addLayoutBuilderForm" method="post" enctype="multipart/form-data">
            @csrf
            <!--begin::Card header-->
            <div class="py-4 border-0 card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0"
                id="kt_app_layout_builder_header"
                style="background-image:url('{{ getAssetsURLs('media/misc/layout/customizer-header-bg.jpg')}}')">
                <!--begin::Card title-->
                <h3 class="m-0 text-white card-title fs-3 fw-bold flex-column">
                    Change Layout
                    <small class="pt-1 text-white opacity-50 fs-7 fw-semibold">
                        Customize CMS according to your requirements
                    </small>
                </h3>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="p-0 btn btn-sm btn-icon btn-color-white w-20px h-20px rounded-1"
                        id="kt_app_layout_builder_close">
                        <i class="ki-duotone ki-cross-square fs-2"><span class="path1"></span><span
                                class="path2"></span></i>
                    </button>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body position-relative" id="kt_app_layout_builder_body">
                <!--begin::Content-->
                <div id="kt_app_settings_content" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true"
                    data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_app_layout_builder_body"
                    data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer"
                    data-kt-scroll-offset="5px">

                    <!--begin::Card body-->
                    <div class="p-0 card-body">
                        <!--begin::Form group-->
                        <div class="form-group">
                            <!--begin::Heading-->
                            <div class="mb-6">
                                <h4 class="text-gray-900 fw-bold">Theme Mode</h4>
                            </div>
                            <!--end::Heading-->
                            <!--begin::Options-->
                            <div class="row " data-kt-buttons="true"
                                data-kt-buttons-target=".form-check-image,.form-check-input">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <label class="form-check-image form-check-success @if($preferences['preference']['theme'] === "light") active @endif">
                                        <!--begin::Image-->
                                        <div class="border-2 border-gray-200 form-check-wrapper">
                                            <img src="{{url('documents/preview/light-ltr.png')}}"
                                                class="form-check-rounded mw-100" alt="" />
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Check-->
                                        <div
                                            class="form-check form-check-custom form-check-solid form-check-sm form-check-success">
                                            <input class="form-check-input" type="radio" value="light" name="theme"
                                                @if($preferences['preference']['theme']==="light" ) checked @endif />
                                            <!--begin::Label-->
                                            <div class="text-gray-700 form-check-label">
                                                Light
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Check-->
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <label class="form-check-image form-check-success @if($preferences['preference']['theme'] === "dark") active @endif">
                                        <!--begin::Image-->
                                        <div class="border-2 border-gray-200 form-check-wrapper">
                                            <img src="{{url('documents/preview/dark-ltr.png')}}"
                                                class="form-check-rounded mw-100" alt="" />
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Check-->
                                        <div
                                            class="form-check form-check-custom form-check-solid form-check-sm form-check-success">
                                            <input class="form-check-input" type="radio" value="dark" name="theme"
                                                @if($preferences['preference']['theme']==="dark" ) checked @endif />
                                            <!--begin::Label-->
                                            <div class="text-gray-700 form-check-label">
                                                Dark
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Check-->
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Options-->
                        </div>
                        <!--end::Form group-->
                        <div class="my-5 separator separator-dashed"></div>

                        <div id="HospitalsListingDiv">
                        </div>

                        <!--begin::Form group-->
                        {{-- <div class="form-group d-flex flex-stack">
                            <!--begin::Heading-->
                            <div class="d-flex flex-column">
                                <h4 class="text-gray-900 fw-bold">RTL Mode</h4>
                            </div>
                            <!--end::Heading-->
                            <!--begin::Option-->
                            <div class="d-flex justify-content-end">
                                <!--begin::Check-->
                                <div
                                    class="form-check form-check-custom form-check-solid form-check-success form-switch">
                                    <input @if($preferences['preference']['rtl_mode']===0) checked @endif type="hidden"
                                        value="false" name="rtl_mode" />
                                    <input @if($preferences['preference']['rtl_mode']===1) checked @endif
                                        class="form-check-input w-45px h-30px" type="checkbox" value="true"
                                        name="rtl_mode" />
                                </div>
                                <!--end::Check-->
                            </div>
                            <!--end::Option-->
                        </div> --}}
                        <!--end::Form group-->
                        {{-- <div class="my-5 separator separator-dashed"></div> --}}
                        <!--begin::Form group-->
                        <!--end::Form group-->
                        {{--
                        <!--begin::Form group-->
                        <div class="form-group">
                            <!--begin::Heading-->
                            <div class="mb-6">
                                <h4 class="text-gray-900 fw-bold">Layouts</h4>
                                <span class="fw-semibold text-muted fs-7 lh-1">
                                    4 main layouts.
                                </span>
                            </div>
                            <!--end::Heading-->
                            <!--begin::Options-->
                            <div class="row gy-3" data-kt-buttons="true"
                                data-kt-buttons-target=".form-check-image:not(.disabled),.form-check-input:not([disabled])">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <label class="form-check-image form-check-success active">
                                        <!--begin::Image-->
                                        <div class="border-2 border-gray-200 form-check-wrapper">
                                            <img src="{{getAssetsURLs('media/preview/layouts/dark-sidebar.png')}}"
                                                class="form-check-rounded mw-100" alt="" />
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Check-->
                                        <div
                                            class="form-check form-check-custom form-check-success form-check-sm form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                @if($preferences['preference']['layout']==="dark_sidebar" ) checked
                                                @endif value="dark_sidebar" name="layout" />
                                            <!--begin::Label-->
                                            <div class="text-gray-700 form-check-label">
                                                Dark Sidebar
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Check-->
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <label class="form-check-image form-check-success ">
                                        <!--begin::Image-->
                                        <div class="border-2 border-gray-200 form-check-wrapper">
                                            <img src="{{getAssetsURLs('media/preview/layouts/light-sidebar.png')}}"
                                                class="form-check-rounded mw-100" alt="" />
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Check-->
                                        <div
                                            class="form-check form-check-custom form-check-success form-check-sm form-check-solid">
                                            <input @if($preferences['preference']['layout']==="light_sidebar" ) checked
                                                @endif class="form-check-input" type="radio" value="light_sidebar"
                                                name="layout" />

                                            <!--begin::Label-->
                                            <div class="text-gray-700 form-check-label">
                                                Light Sidebar
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Check-->
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <label class="form-check-image form-check-success ">
                                        <!--begin::Image-->
                                        <div class="border-2 border-gray-200 form-check-wrapper">
                                            <img src="{{getAssetsURLs('media/preview/layouts/dark-header.png')}}"
                                                class="form-check-rounded mw-100" alt="" />
                                        </div>
                                        <!--end::Image-->

                                        <!--begin::Check-->
                                        <div
                                            class="form-check form-check-custom form-check-success form-check-sm form-check-solid">
                                            <input @if($preferences['preference']['layout']==="dark_header" ) checked
                                                @endif class="form-check-input" type="radio" value="dark_header"
                                                name="layout" />
                                            <!--begin::Label-->
                                            <div class="text-gray-700 form-check-label">
                                                Dark Header
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Check-->
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <label class="form-check-image form-check-success ">
                                        <!--begin::Image-->
                                        <div class="border-2 border-gray-200 form-check-wrapper">
                                            <img src="{{getAssetsURLs('media/preview/layouts/light-header.png')}}"
                                                class="form-check-rounded mw-100" alt="" />
                                        </div>
                                        <!--end::Image-->

                                        <!--begin::Check-->
                                        <div
                                            class="form-check form-check-custom form-check-success form-check-sm form-check-solid">
                                            <input @if($preferences['preference']['layout']==="light_header" ) checked
                                                @endif class="form-check-input" type="radio" value="light_header"
                                                name="layout" />
                                            <!--begin::Label-->
                                            <div class="text-gray-700 form-check-label">
                                                Light Header
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Check-->
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Options-->
                        </div> --}}
                        <!--end::Form group-->
                        {{-- <div class="my-5 separator separator-dashed"></div> --}}

                        <!--begin::Form group-->
                        {{-- <div class="form-group">
                            <!--begin::Heading-->
                            <div class="mb-6">
                                <h4 class="text-gray-900 fw-bold">Languages</h4>
                                <span class="fw-semibold text-muted fs-7 lh-1">
                                    2 main languages.
                                </span>
                            </div>
                            <!--end::Heading-->

                            <!--begin::Options-->
                            <div class="row gy-3" data-kt-buttons="true"
                                data-kt-buttons-target=".form-check-image:not(.disabled),.form-check-input:not([disabled])">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <label class="form-check-image form-check-success active">
                                        <!--end::Image-->
                                        <!--begin::Check-->
                                        <div
                                            class="form-check form-check-custom form-check-success form-check-sm form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                @if($preferences['preference']['system_language']==="english" ) checked
                                                @endif value="english" name="system_language" />
                                            <!--begin::Label-->
                                            <div class="text-gray-700 form-check-label">
                                                English
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Check-->
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <label class="form-check-image form-check-success">
                                        <!--begin::Check-->
                                        <div
                                            class="form-check form-check-custom form-check-success form-check-sm form-check-solid">
                                            <input @if($preferences['preference']['system_language']==="arabic" )
                                                checked @endif class="form-check-input" type="radio" value="arabic"
                                                name="system_language" />
                                            <!--begin::Label-->
                                            <div class="text-gray-700 form-check-label">
                                                Arabic
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Check-->
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <!--end::Col-->
                                <!--begin::Col-->
                                <!--end::Col-->
                            </div>
                            <!--end::Options-->
                        </div> --}}
                        <!--end::Form group-->
                        {{-- <br> --}}

                        <!--begin::Form group-->
                        {{-- <div class="form-group">
                            <!--begin::Heading-->
                            <div class="mb-6">
                                <h4 class="text-gray-900 fw-bold">Data View</h4>
                                <span class="fw-semibold text-muted fs-7 lh-1">
                                </span>
                            </div>
                            <!--end::Heading-->

                            <!--begin::Options-->
                            <div class="row gy-3" data-kt-buttons="true"
                                data-kt-buttons-target=".form-check-image:not(.disabled),.form-check-input:not([disabled])">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <label class="form-check-image form-check-success active">
                                        <!--end::Image-->
                                        <!--begin::Check-->
                                        <div
                                            class="form-check form-check-custom form-check-success form-check-sm form-check-solid">
                                            <input class="form-check-input" type="radio"
                                                @if($preferences['preference']['data_view']==="list" ) checked @endif
                                                value="list" name="data_view" />
                                            <!--begin::Label-->
                                            <div class="text-gray-700 form-check-label">
                                                List
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Check-->
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <label class="form-check-image form-check-success ">
                                        <!--begin::Check-->
                                        <div
                                            class="form-check form-check-custom form-check-success form-check-sm form-check-solid">
                                            <input @if($preferences['preference']['data_view']==="grid" ) checked @endif
                                                class="form-check-input" type="radio" value="grid" name="data_view" />
                                            <!--begin::Label-->
                                            <div class="text-gray-700 form-check-label">
                                                Grid
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Check-->
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <!--end::Col-->
                                <!--begin::Col-->
                                <!--end::Col-->
                            </div>
                            <!--end::Options-->
                        </div> --}}
                        <!--end::Form group-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Card body-->
            <!--begin::Card footer-->
            <div class="gap-3 pt-0 border-0 card-footer d-flex pb-9" id="kt_app_layout_builder_footer">
                <button type="button" type="submit" id="addLayoutOutOptions"
                    class="btn btn-primary flex-grow-1 fw-semibold">Save</button>
                <button type="button" type="reset" class="btn btn-light flex-grow-1 fw-semibold">Reset</button>
            </div>
            <!--end::Card footer-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
<!--end::App layout builder-->
@section('scripts')

@endsection
