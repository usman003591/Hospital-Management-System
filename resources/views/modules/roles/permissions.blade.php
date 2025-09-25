@php $page='roles'; @endphp
@extends('layouts.master',['activeMenu' => 'users_management', 'activeSubMenu' => $page, 'activeThirdMenu' => $page])
@section('content')
  <!--begin::Content-->
        <!--begin::Content container-->
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="pt-6 border-0 card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                       Edit {{$role->name}} Role Permissions
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-users-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::Add users-->
                            <a href="{{route($page.".index")}}" type="button" class="btn btn-sm btn-primary"> &laquo; Back</a>
                            <!--end::Add users-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <!--end::Group actions-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="pt-0 card-body">
                    <!--begin::Table-->
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($module as $c)
                                <div class="pb-5" style="border-bottom:1px solid #e4e4e4">
                                    <div class="mt-5"><strong>{{$c->name}}</strong></div>
                                    @if($c->permission_data()->count() > 0)
                                        <div class="mb-5 row ">
                                        <div class="col-12">
                                            <div class="mb-3">Base Permissions</div>
                                            <div class="ml-5 d-flex fv-row ">
                                                <!--begin::Radio-->
                                                @foreach($c->permission_data() as $p)

                                                    <div class="form-check form-check-custom form-check-solid">
                                                    &nbsp;
                                                    <!--begin::Input-->
                                                    <input class="form-check-input permission_checkbox" data-right-id="{{$p->id}}"  data-value="{{$p->rights_slug}}" name="{{$p->rights_slug}}"
                                                           type="checkbox" value="0" id="id_{{$p->rights_slug}}" {{checkPersonPermissionforValidation($p->rights_slug, $role->permissions()) ? 'checked="checked"' : ''}}
                                                            data-category="{{$p->role_right_module_id}}" data-type="{{explode('_', $p->rights_slug)[0]}}"
                                                    />
                                                    &nbsp;
                                                    <!--end::Input-->
                                                    <!--begin::Label-->
                                                    <label class="mr-5 form-check-label" for="id_{{$p->rights_slug}}">
                                                        <div class="text-gray-800 fw-bolder">{{$p->name}}</div>
                                                    </label>
                                                    &nbsp;
                                                    <!--end::Label-->
                                                </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                    @endif
                                    @if($c->child_data()->count() > 0)
                                        <div class="row">
                                        <div class="mr-10 col-12">
                                            <div class="mb-3">Childrens</div>
                                            @foreach($c->child_data() as $cc)
                                                <div class="row ">
                                                    <div class="mb-5 ml-5 col-12">
                                                        <div class="mt-5"><strong>{{$cc->name}}</strong></div>
                                                        @if($cc->permission_data()->count() > 0)
                                                            <div class="mb-5 row ">
                                                                <div class="col-12">
                                                                    <div class="mb-3">Base Permissions</div>
                                                                    <div class="ml-5 d-flex fv-row ">
                                                                        <!--begin::Radio-->
                                                                        @foreach($cc->permission_data() as $p)

                                                                            <div class="form-check form-check-custom form-check-solid">
                                                                                &nbsp;
                                                                                <!--begin::Input-->
                                                                                <input class="form-check-input permission_checkbox"  data-right-id="{{$p->id}}" data-value="{{$p->rights_slug}}" name="{{$p->rights_slug}}"
                                                                                type="checkbox" value="0" id="id_{{$p->rights_slug}}" {{checkPersonPermissionforValidation($p->rights_slug, $role->permissions()) ? 'checked="checked"' : ''}}
                                                                                    data-category="{{$p->role_right_module_id}}" data-type="{{explode('_', $p->rights_slug)[0]}}"
                                                                                />
                                                                                &nbsp;
                                                                                <!--end::Input-->
                                                                                <!--begin::Label-->
                                                                                <label class="mr-5 form-check-label" for="id_{{$p->rights_slug}}">
                                                                                    <div class="text-gray-800 fw-bolder">{{$p->name}}</div>
                                                                                </label>
                                                                                &nbsp;
                                                                                <!--end::Label-->
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @endforeach
                            </div>
                         </div>
                     </div>
                </div>



                </div>
                    <!--end::Table-->

                    <br>

            <!--end::Card-->
        <!--end::Content container-->
    <!--begin role::Content-->
    <!--begin::List Widget 8-->
    <!--end::List Widget 8-->
    <!--end role::Content-->







@endsection
@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6" data-select2-id="select2-data-kt_app_toolbar">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack" data-select2-id="select2-data-kt_app_toolbar_container">
        <!--begin::Page title-->
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <!--begin::Title-->
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">{{titleFilter($page)}} List</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <a href="{{route('users.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">Users Management</li>
                </a>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <a href="{{route('roles.index')}}">
                    <span></span>
                    <li class="breadcrumb-item text-muted text-hover-primary">{{titleFilter($page)}}</li>
                </a>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="gap-2 d-flex align-items-center gap-lg-3" data-select2-id="select2-data-122-cw9r">
            <!--begin::Filter menu-->
            {{-- <div class="m-0" data-select2-id="select2-data-121-45f5">
                <!--begin::Menu toggle-->
                <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>Filter</a>
                <!--end::Menu toggle-->
                <!--begin::Menu 1-->
                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_6606384d61246" style="" data-select2-id="select2-data-kt_menu_6606384d61246">
                    <!--begin::Header-->
                    <div class="py-5 px-7">
                        <div class="text-gray-900 fs-5 fw-bold">Filter Options</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Menu separator-->
                    <div class="border-gray-200 separator"></div>
                    <!--end::Menu separator-->
                    <!--begin::Form-->
                    <div class="py-5 px-7" data-select2-id="select2-data-120-s3mi">
                        <!--begin::Input group-->
                        <div class="mb-10" data-select2-id="select2-data-119-md49">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Status:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div data-select2-id="select2-data-118-i4go">
                                <select class="form-select form-select-solid select2-hidden-accessible" multiple="" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_6606384d61246" data-allow-clear="true" data-select2-id="select2-data-7-19z1" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                    <option data-select2-id="select2-data-125-g7ns"></option>
                                    <option value="1" data-select2-id="select2-data-126-g09z">Approved</option>
                                    <option value="2" data-select2-id="select2-data-127-23ft">Pending</option>
                                    <option value="2" data-select2-id="select2-data-128-ql51">In Process</option>
                                    <option value="2" data-select2-id="select2-data-129-fwv5">Rejected</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5 select2-container--below" dir="ltr" data-select2-id="select2-data-8-x24w" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--multiple form-select form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false"><ul class="select2-selection__rendered" id="select2-fkxw-container"></ul><span class="select2-search select2-search--inline"><textarea class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-label="Search" aria-describedby="select2-fkxw-container" placeholder="Select option" style="width: 100%;"></textarea></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Member Type:</label>
                            <!--end::Label-->
                            <!--begin::Options-->
                            <div class="d-flex">
                                <!--begin::Options-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1">
                                    <span class="form-check-label">Author</span>
                                </label>
                                <!--end::Options-->
                                <!--begin::Options-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="2" checked="checked">
                                    <span class="form-check-label">Customer</span>
                                </label>
                                <!--end::Options-->
                            </div>
                            <!--end::Options-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Notifications:</label>
                            <!--end::Label-->
                            <!--begin::Switch-->
                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked">
                                <label class="form-check-label">Enabled</label>
                            </div>
                            <!--end::Switch-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                            <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Menu 1-->
            </div> --}}
            <!--end::Filter menu-->
            <!--begin::Secondary button-->
            <!--end::Secondary button-->
            <!--begin::Primary button-->
            {{-- <a href="{{route('roles.create')}}" class="btn btn-sm fw-bold btn-primary">Create</a> --}}
            <!--end::Primary button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>
@endsection
@section('styles')
<style>
    input.larger {
        width: 50px !important;
        height: 50px !important;
     }
    .form-check-input {
        /* background-color: #b5b5c3 !important; */
    }
    </style>
    <link href="{{getAssetsURLs('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{getAssetsURLs('plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{getAssetsURLs('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
    <script src="{{getAssetsURLs('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{getAssetsURLs('plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
    <script type="text/javascript">
        function initMCEexact(e){

            tinymce.init({
            selector : "textarea#"  +  e,
            height : "480",
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            },
            menubar: 'insert view code restoredraft insertdatetime toc',
            toolbar: 'undo redo | code | styleselect | fontselect |  alignleft aligncenter alignright alignjustify | bold italic underline |  image | media |  link | preview | code | fullscreen | numlist | bullist ',
            plugins: 'code table fullscreen lists advlist autosave image insertdatetime link preview toc visualblocks wordcount textpattern quickbars charmap directionality anchor autoresize media',

          });
        }

        initMCEexact("kt_docs_tinymce_basic_1");
    </script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{getAssetsURLs('js/custom/apps/user-management/users/list/table.js')}}"></script>
    <script src="{{getAssetsURLs('js/custom/apps/user-management/users/list/export-users.js')}}"></script>
    <script src="{{getAssetsURLs('js/modules/admins/add.js')}}"></script>
    <script src="{{getAssetsURLs('js/custom/widgets.js')}}"></script>
    <script src="{{getAssetsURLs('js/custom/apps/chat/chat.js')}}"></script>
    <script src="{{getAssetsURLs('js/custom/modals/create-app.js')}}"></script>
    <script src="{{getAssetsURLs('js/custom/modals/upgrade-plan.js')}}"></script>
    <script>
        $(function () {

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){

            $(document).on('change', '.permission_checkbox', function(){
                data = {
                    'value' : $(this).prop("checked"),
                    'slug' : $(this).data('value'),
                    'right_id' : $(this).data('right-id'),
                }

               console.log(data);

                $.ajax({
                    url: window.location.href,
                    data: data,
                    method: 'post',
                    success: function(result){
                        // show_message('success', 'Permission updated successfully');
                        toastr.success('Permission updated successfully');
                    },
                });

                type = $(this).data('type');
                category = $(this).data('category');

                if(type == 'add' || type == 'delete' || type == 'update') {
                    if($(this).prop("checked") == true)
                        $("#id_view_" + category).prop('checked', true).trigger('change');

                }

                if(type == 'view') {
                    if($(this).prop("checked") == false) {
                        $("#id_add_" + category).prop('checked', false).trigger('change');
                        $("#id_update_" + category).prop('checked', false).trigger('change');
                        $("#id_delete_" + category).prop('checked', false).trigger('change');
                    }
                }

            })

        })
    });

    </script>

@endsection
