<div class="mb-5 card mb-xl-10">
    <div class="pb-0 card-body pt-9">
        <!--begin::Details-->
        <div class="flex-wrap d-flex flex-sm-nowrap">
            <!--begin: Pic-->
            <div class="mb-4 me-7">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="@isset($medicine->image_path) {{ $medicine->image_path }} @endisset" alt="image">
                </div>
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
                                class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">@isset($medicine->name)
                                {{ $medicine->name }}
                                @endisset</a>
                        </div>
                        <!--end::Name-->
                        <!--begin::Info-->
                        <div class="flex-wrap mb-4 d-flex fw-semibold fs-6 pe-2">
                            <!-- Cost -->
                            @isset($medicine->number)
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                 <i class="ki-duotone ki-box fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>Medicine Number : {{ $medicine->number }}
                            </a>
                            @endisset

                            {{-- @isset($medicine->packet_price)
                            <!-- Packet Price -->
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary me-5">
                                <i class="ki-duotone ki-box fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>{{intval($medicine->packet_price)}} / Packet
                            </a>
                            @endisset

                             @isset($medicine->packet_items)
                            <!-- Packet Items -->
                            <a href="#" class="mb-2 text-gray-500 d-flex align-items-center text-hover-primary">
                                <i class="ki-duotone ki-element-11 fs-4 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>{{intval($medicine->packet_items)}} Items
                            </a>
                            @endisset --}}

                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                    <!--begin::Actions-->
                    <div class="my-4 d-flex">
                        {{-- <button type="button" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add Medicine Batch
                        </button> --}}
                        @if (checkPersonPermission('create_pharmacy_inventory_batches_72'))
                        <livewire:pharmacy.batches.add-medicine-batches :medicineId="$medicine->id" :medicineName="$medicine->name" />
                        @endif

                        &nbsp;
                        <!-- Back Button -->
                        <a href="{{ route('pharmacy.list_pharmacy_inventory') }}" type="button"
                            class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
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
                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                        data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1">
                                        @isset($inventory->quantity)
                                            {{ intval($inventory->quantity) }}
                                        @endisset
                                    </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Total Quantity</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="px-4 py-3 mb-3 border border-gray-300 border-dashed rounded min-w-125px me-6">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="80"
                                        data-kt-initialized="1">       @isset($inventory->reorder_number)
                                            {{ intval($inventory->reorder_number) }}
                                        @endisset</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="text-gray-500 fw-semibold fs-6">Reorder Number</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->

                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->
        <!--begin::Navs-->
        <ul class="border-transparent nav nav-stretch nav-line-tabs nav-line-tabs-2x fs-5 fw-bold">
            <!--begin::Nav item-->
            <li class="mt-2 nav-item">
                <a class="py-5 nav-link text-active-primary ms-0 me-10 active" href="{{ route('pharmacy.list_pharmacy_inventory_batches', $inventory->medicine_id) }}">Batches</a>
            </li>
            <!--end::Nav item-->
        </ul>
        <!--begin::Navs-->
    </div>
</div>
