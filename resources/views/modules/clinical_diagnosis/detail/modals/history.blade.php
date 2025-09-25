<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Patient History</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"
                    data-kt-users-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body px-5 my-7">
                <div class="col-xl-12">
                    <!--begin::Table widget 13-->
                    <div class="card card-flush h-xl-100">
                        <!--begin::Header-->
                        <div class="card-header pt-7">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Name</span>
                                {{-- <span class="text-gray-500 mt-1 fw-semibold fs-6">Total 424,567 deliveries</span>
                                --}}
                            </h3>
                            <!--end::Title-->
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-3 pb-4">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fs-7 fw-bold text-gray-500">
                                            <th class="px-0 pt-0 pb-2 min-w-200px">Patient Name</th>
                                            <th class="px-0 pt-0 pb-2 min-w-150px">Doctor Name</th>
                                            <th class="px-0 pt-0 pb-2 min-w-150px">Date & Time</th>
                                            <th class="px-0 pt-0 pb-2 min-w-150px">Counter/Token</th>
                                            <th class="px-0 pt-0 pb-2 min-w-125px">Hospital</th>
                                            <th class="px-0 pt-0 pb-2 min-w-150px">Mr Number</th>
                                            {{-- <th class="p-0 min-w-150px">Status</th> --}}
                                            <th class="px-0 pt-0 pb-2 min-w-50px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody id="OPDPatientHistoryListingDiv">
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--end: Card Body-->
                    </div>
                    <!--end::Table widget 13-->
                </div>

            </div>
            <div class="modal-footer">
                <div class="text-center pt-10">
                    <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3"
                        data-kt-users-modal-action="cancel">Close</button>
                    {{-- <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button> --}}
                </div>
            </div>
        </div>
    </div>
</div>
