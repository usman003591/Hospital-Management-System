
                    @if (checkPersonPermission('view_section_settings_section_10'))
                    <!--begin::Menu settings-->
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item @isset($activeMenu)
                        {{ $activeMenu == 'settings_management' ? 'menu-accordion hover show' : 'menu-accordion' }}
                        @else
                        menu-accordion
                        @endisset">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-gear fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Settings</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion @isset($activeMenu)
                            {{ $activeMenu == 'settings_management' ? 'show' : '' }}
                            @endisset" @isset($activeMenu) {{ $activeMenu=='settings_management' ? 'style=""'
                                : 'style="display: none; overflow: hidden;"' }} @endisset>

                                @if (checkPersonPermission('list_service_categories_11'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'service_categories' ? 'active' : '' }}
                            @endisset" href="{{ route('service_categories.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Service Categories</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_medication_quantity_14'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'treatment_dosage' ? 'active' : '' }}
                            @endisset" href="{{ route('treatment_dosage.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Medication Quantity</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif
                                {{-- @if (checkPersonPermission('list_medication_frequency_15'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'treatment_duration' ? 'active' : '' }}
                            @endisset" href="{{ route('treatment_duration.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Medication Frequency</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif --}}
                                @if (checkPersonPermission('list_medication_dose_interval_16'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'treatment_dose_interval' ? 'active' : '' }}
                            @endisset" href="{{ route('treatment_dose_interval.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Medication Frequency</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_brands_17'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'brands' ? 'active' : '' }}
                            @endisset" href="{{ route('brands.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Brands</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_opd_counter_57'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                        {{ $activeSubMenu == 'opd_counter' ? 'active' : '' }}
                        @endisset" href="{{ route('opd_counter.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">OPD Counter</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                {{-- @if (checkPersonPermission('list_floors_11'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                        {{ $activeSubMenu == 'floors' ? 'active' : '' }}
                        @endisset" href="{{ route('floors.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Floors</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_wards_11'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'wards' ? 'active' : '' }}
                            @endisset" href="{{ route('wards.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Wards</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_beds_11'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'beds' ? 'active' : '' }}
                            @endisset" href="{{ route('beds.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Beds</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_rooms_11'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'rooms' ? 'active' : '' }}
                            @endisset" href="{{ route('rooms.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Rooms</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif --}}

                                @if (checkPersonPermission('list_admit_patients_18'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'admit_patients' ? 'active' : '' }}
                            @endisset" href="{{ route('admit_patients.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Admit Patients</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_medicine_routes_19'))
                                <!--end:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'medicine_routes' ? 'active' : '' }}
                            @endisset" href="{{ route('medicine_routes.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Medicine Routes</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif
                                {{-- @if (checkPersonPermission('list_medicine_routes_19')) --}}
                                <!--end:Menu item-->
                                @if (checkPersonPermission('list_medicine_durations_58'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                            {{ $activeSubMenu == 'medicine_durations' ? 'active' : '' }}
                            @endisset" href="{{ route('medicine_durations.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Medicine Durations</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif


                                {{--
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                        {{ $activeSubMenu == 'roles' ? 'active' : '' }}
                        @endisset" href="{{ route('roles.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Roles</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div> --}}


                                @if (checkPersonPermission('list_departments_12'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'departments' ? 'active' : '' }}
                    @endisset" href="{{ route('departments.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Departments</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif


                                @if (checkPersonPermission('list_invoice_payment_statuses_13'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'invoice_payment_statuses' ? 'active' : '' }}
                    @endisset" href="{{ route('invoice_payment_statuses.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Invoice Payment Status</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_complaints_20'))
                                {{-- @if (auth()->user()->role_id == 1) --}}
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'complaints' ? 'active' : '' }}
                    @endisset" href="{{ route('complaints.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Complaints</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif
                                {{-- @endif --}}
                                {{-- @if (auth()->user()->role_id == 1) --}}
                                @if (checkPersonPermission('list_general_physical_examination_21'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'general_physical_examinations' ? 'active' : '' }}
                    @endisset" href="{{ route('general_physical_examinations.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">GPEs</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif
                                {{-- @endif --}}

                                {{-- @if (auth()->user()->role_id == 1) --}}
                                @if (checkPersonPermission('list_systematic_physical_examination_22'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'systematic_physical_examinations' ? 'active' : '' }}
                    @endisset" href="{{ route('systematic_physical_examinations.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">SPEs</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                {{-- @endif --}}
                                {{-- @if (auth()->user()->role_id == 1) --}}
                                @if (checkPersonPermission('list_vitals_23'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'vitals' ? 'active' : '' }}
                    @endisset" href="{{ route('vitals.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Vitals</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif
                                {{-- @endif --}}


                                {{-- @if (auth()->user()->role_id == 1) --}}
                                @if (checkPersonPermission('list_medicines_24'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'medicines' ? 'active' : '' }}
                    @endisset" href="{{ route('medicines.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Medicines</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif



                                {{-- @if (auth()->user()->role_id == 1) --}}
                                @if (checkPersonPermission('list_diagnosis_25'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'diagnosis' ? 'active' : '' }}
                    @endisset" href="{{ route('diagnosis.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Diagnosis</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif



                                {{-- @if (auth()->user()->role_id == 1) --}}
                                @if (checkPersonPermission('list_investigations_26'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'investigations' ? 'active' : '' }}
                    @endisset" href="{{ route('investigations.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Investigations</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_investigations_custom_fields_59'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                        {{ $activeSubMenu == 'investigation_custom_fields' ? 'active' : '' }}
                                        @endisset" href="{{ route('investigation_custom_fields.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Custom Fields</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                {{-- @if (auth()->user()->role_id == 1) --}}
                                @if (checkPersonPermission('list_investigation_types_27'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'investigation_types' ? 'active' : '' }}
                    @endisset" href="{{ route('investigation_types.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Investigation Types</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_hospitals_28'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'hospitals' ? 'active' : '' }}
                    @endisset" href="{{ route('hospitals.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Hospitals</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkIfUserIsAdmin())
                                @if (checkPersonPermission('list_import_data_29'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                    {{ $activeSubMenu == 'import_opd_data' ? 'active' : '' }}
                    @endisset" href="{{ route('import_opd_data') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Import Data</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif
                                @endif


                                @if (checkPersonPermission('list_appointment_statuses_30'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                        {{ $activeSubMenu == 'appointment_statuses' ? 'active' : '' }}
                                        @endisset" href="{{ route('appointment_statuses.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Appointment Status</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_procedures_31'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                        {{ $activeSubMenu == 'procedures' ? 'active' : '' }}
                                        @endisset" href="{{ route('procedures.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Procedures</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif

                                @if (checkPersonPermission('list_dosage_forms_32'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link @isset($activeSubMenu)
                                        {{ $activeSubMenu == 'dosage_forms' ? 'active' : '' }}
                                        @endisset" href="{{ route('dosage_forms.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Dosage forms</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                @endif


                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    @endif
