   <div class="py-5">
                    <div class="p-10 rorder-0 ounded b d-flex flex-column flex-md-row">
                        <ul class="flex-row mb-3 border-0 nav nav-tabs nav-pills flex-md-column me-5 mb-md-0 fs-6 min-w-lg-200px"
                            role="tablist">
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link
                                @isset($tab)
                                  @if ($tab === 'complaints')
                                    active
                                  @endif
                                @endisset w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    id="kt_vtab_pane_4_link" href="#kt_vtab_pane_4" aria-selected="false" tabindex="-1"
                                    role="tab">
                                    <i class="ki-duotone ki-information-4 fs-1">
                                        <i class="path1"></i>
                                        <i class="path2"></i>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">Complaints</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link @isset($tab)
                                  @if ($tab === 'vitals')
                                    active
                                  @endif
                                @endisset  w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_5" id="kt_vtab_pane_5_link" aria-selected="false" tabindex="-1"
                                    role="tab">
                                    <i class="ki-duotone ki-thermometer fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">Vitals</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_6" id="kt_vtab_pane_6_link" aria-selected="false" tabindex="-1"
                                    role="tab">
                                    <i class="ki-duotone ki-burger-menu-5 fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">Brief History</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_7" id="kt_vtab_pane_7_link" aria-selected="false" tabindex="-1"
                                    role="tab">
                                    <i class="ki-duotone ki-magnifier fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">GPE</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_8" id="kt_vtab_pane_8_link" aria-selected="false" tabindex="-1"
                                    role="tab">
                                    <i class="ki-duotone ki-pulse fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">SPE</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_9" id="kt_vtab_pane_9_link" aria-selected="false" tabindex="-1"
                                    role="tab">
                                    <i class="ki-duotone ki-test-tubes fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">Investigations</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_10" id="kt_vtab_pane_10_link" aria-selected="false"
                                    tabindex="-1" role="tab">
                                    <i class="ki-duotone ki-virus fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">Diagnosis</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_14" id="kt_vtab_pane_14_link" aria-selected="false"
                                    tabindex="-1" role="tab">
                                    <i class="ki-duotone ki-mask fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">Procedures</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_11" id="kt_vtab_pane_11_link" aria-selected="false"
                                    tabindex="-1" role="tab">
                                    <i class="ki-duotone ki-syringe fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">Medication</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_12" id="kt_vtab_pane_12_link" aria-selected="false"
                                    tabindex="-1" role="tab">
                                    <i class="ki-duotone ki-exit-left fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">Disposal</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li>
                            {{-- <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_13" id="kt_vtab_pane_13_link" aria-selected="false"
                                    tabindex="-1" role="tab">
                                    <i class="ki-duotone ki-printer fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    &nbsp;
                                    <span class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">Snapshot</span>
                                        <span class="fs-7"></span>
                                    </span>
                                </a>
                            </li> --}}
                        </ul>

                        <div class="tab-content" id="myTabContent">

                            {{-- Complaints tab content starts here --}}
                            <div class="tab-pane fade
                                @isset($tab)
                                  @if ($tab === 'complaints')
                                      show active
                                  @endif
                                @endisset" id="kt_vtab_pane_4" role="tabpanel">
                                @include('modules.clinical_diagnosis.detail.simple.complaints_tab')
                            </div>
                            {{-- Complaints tab content ends here --}}

                            <div class="tab-pane fade
                                @isset($tab)
                                  @if ($tab === 'vitals')
                                      show active
                                  @endif
                                @endisset" id="kt_vtab_pane_5" role="tabpanel">
                                @include('modules.clinical_diagnosis.detail.simple.vitals_tab')
                            </div>

                            <div class="tab-pane fade" id="kt_vtab_pane_6" role="tabpanel">
                                @include('modules.clinical_diagnosis.detail.simple.brief_history')
                            </div>

                            <div class="tab-pane fade" id="kt_vtab_pane_7" role="tabpanel">
                                @include('modules.clinical_diagnosis.detail.simple.gpe_tab')
                            </div>

                            <div class="tab-pane fade" id="kt_vtab_pane_8" role="tabpanel">
                                @include('modules.clinical_diagnosis.detail.simple.spe_tab')
                            </div>

                            <div class="tab-pane fade" id="kt_vtab_pane_9" role="tabpanel">
                                @include('modules.clinical_diagnosis.detail.simple.investigations_tab')
                            </div>

                            <div class="tab-pane fade" id="kt_vtab_pane_10" role="tabpanel">
                                @include('modules.clinical_diagnosis.detail.simple.diagnosis_tab')
                            </div>

                            <div class="tab-pane fade" id="kt_vtab_pane_14" role="tabpanel">
                                @include('modules.clinical_diagnosis.detail.simple.procedure_tab')
                            </div>

                            <div class="tab-pane fade" id="kt_vtab_pane_11" role="tabpanel">
                                @include('modules.clinical_diagnosis.detail.simple.treatment_tab')
                            </div>

                            <div class="tab-pane fade" id="kt_vtab_pane_12" role="tabpanel">
                                @include('modules.clinical_diagnosis.detail.simple.disposal_tab')
                            </div>


                            {{-- <div class="tab-pane fade" id="kt_vtab_pane_13" role="tabpanel">

                                @include('modules.clinical_diagnosis.detail.include.snapshot') --}}

                                {{-- <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-center">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-print fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>


                                        </div>
                                    </div>
                                </div>
                                Sint sit mollit irure quis est nostrud cillum consequat Lorem esse do quis dolor
                                esse fugiat sunt do.
                                Eu ex commodo veniam Lorem aliquip laborum occaecat qui Lorem esse mollit dolore anim
                                cupidatat.
                                eserunt officia id Lorem nostrud aute id commodo elit eiusmod enim irure amet eiusmod
                                qui reprehenderit nostrud tempor.
                                Fugiat ipsum excepteur in aliqua non et quis aliquip ad irure in labore cillum elit
                                enim. Consequat aliquip incididunt
                                ipsum et minim laborum laborum laborum et cillum labore. Deserunt adipisicing cillum id
                                nulla minim nostrud labore eiusmod et amet. --}}


                                {{-- </div> --}}


                        </div>
                    </div>
                </div>
