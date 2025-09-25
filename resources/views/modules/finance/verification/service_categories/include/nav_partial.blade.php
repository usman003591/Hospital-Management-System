<div class="card mb-6 mb-xl-9">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <!--begin::Image-->
            <!--end::Image-->
            <!--begin::Wrapper-->
            <div class="flex-grow-1">
                <!--begin::Head-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::Details-->
                    <div class="d-flex flex-column">
                        <!--begin::Status-->
                        <div class="d-flex align-items-center mb-1">
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">Invoice#
                                @isset($obj->invoice_sequence) {{$obj->invoice_sequence}} @endisset</a>
                            <span class="me-auto">{!! getFinanceApprovalStatusLabel($obj->is_finance_verified)
                                !!}</span>
                        </div>
                        <!--end::Status-->
                        <!--begin::Description-->
                        <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-500"></div>
                        <!--end::Description-->
                    </div>
                    <!--end::Details-->
                    <!--begin::Actions-->
                    <div class="d-flex mb-4">

                        <livewire:finance.change-status.change-status-services :invoiceId="$obj->id" />&nbsp;
                        @if(checkPersonPermission('download_service_invoices_verification_62'))
                        <a title="Download Receipt" target="_blank" class="btn btn-sm btn-info me-3"
                            href="{{ route('finance.download_service_category_invoice', $obj->id) }}"
                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <i class="ki-duotone ki-down-square fs-2">
                                <span class="path1"></span><span class="path2"></span>
                            </i> Download Receipt
                        </a>
                        @endif
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Head-->
                <!--begin::Info-->
                <div class="d-flex flex-wrap justify-content-start">
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap">
                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">{{ $obj->date_issued ?
                                    \Carbon\Carbon::parse($obj->date_issued)->format('Y-m-d') : '' }}</div>
                            </div>
                            <!--end::Number-->
                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-500">Date Issued</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->
                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold counted" data-kt-countup="true" data-kt-countup-value="75"
                                    data-kt-initialized="1"> @isset($obj->discount_amount )
                                    {{ $obj->discount_amount }}
                                    @endif</div>
                            </div>
                            <!--end::Number-->
                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-500">Discount Amount</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->
                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold counted" data-kt-countup="true" data-kt-countup-value="15000"
                                    data-kt-countup-prefix="$" data-kt-initialized="1"> @isset($obj->total_amount) {{
                                    $obj->net_amount }} @endisset </div>
                            </div>
                            <!--end::Number-->
                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-500">Net Amount</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->
                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold counted" data-kt-countup="true" data-kt-countup-value="15000"
                                    data-kt-countup-prefix="$" data-kt-initialized="1"> @isset($obj->total_amount) {{
                                    $obj->total_amount }} @endisset</div>
                            </div>
                            <!--end::Number-->
                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-500">Total Amount</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                    </div>
                    <!--end::Stats-->

                </div>
                <!--end::Info-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Details-->
        <div class="separator"></div>
        <!--begin::Nav-->
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <!--begin::Nav item-->
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item ">
                <a class="nav-link active text-active-primary py-5 me-6"
                    href="{{route('finance.service_categories_invoices_verification_detail', ['id' => $obj->id])}}"
                    target="_blank">Logs</a>
            </li>
            <!--end::Nav item-->

        </ul>
        <!--end::Nav-->
    </div>
</div>
