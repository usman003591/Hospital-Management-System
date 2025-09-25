<div class="col-xl-12">
											<!--begin::Card widget 19-->
											<div class="card card-flush h-lg-100">
												<!--begin::Header-->
												<div class="pt-5 card-header">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column">
														<span class="text-gray-900 card-label fw-bold">Lab Group #@isset($lab_group_data->lab_group_number) {{$lab_group_data->lab_group_number}} @endisset Stats</span>
													</h3>
													<!--end::Title-->
													<!--begin::Toolbar-->
													<!--end::Toolbar-->
												</div>
												<!--end::Header-->
												<!--begin::Card body-->
												<div class="pt-6 card-body d-flex align-items-end">
													<!--begin::Row-->
													<div class="mx-0 row align-items-center w-100">
														<!--begin::Col-->
														<div class="px-0 col-7">
															<!--begin::Labels-->
															<div class="d-flex flex-column content-justify-center">
																<!--begin::Label-->
																<div class="d-flex fs-6 fw-semibold align-items-center">
																	<!--begin::Bullet-->
																	<div class="bullet bg-info me-3" style="border-radius: 3px;width: 12px;height: 12px"></div>
																	<!--end::Bullet-->
																	<!--begin::Label-->
																	<div class="text-gray-600 fs-5 fw-bold me-5">Total :</div>
																	<!--end::Label-->
																	<!--begin::Stats-->
																	<div class="text-gray-700 ms-auto fw-bolder text-end">{{$lab_group_stats['total']}}</div>
																	<!--end::Stats-->
																</div>
																<!--end::Label-->
																<!--begin::Label-->
																<div class="my-4 d-flex fs-6 fw-semibold align-items-center">
																	<!--begin::Bullet-->
																	<div class="bullet bg-primary me-3" style="border-radius: 3px;width: 12px;height: 12px"></div>
																	<!--end::Bullet-->
																	<!--begin::Label-->
																	<div class="text-gray-600 fs-5 fw-bold me-5">Pending:</div>
																	<!--end::Label-->
																	<!--begin::Stats-->
																	<div class="text-gray-700 ms-auto fw-bolder text-end">{{$lab_group_stats['pending']}}</div>
																	<!--end::Stats-->
																</div>
																<!--end::Label-->
																<!--begin::Label-->
																<div class="d-flex fs-6 fw-semibold align-items-center">
																	<!--begin::Bullet-->
																	<div class="bullet bg-success me-3" style="border-radius: 3px;background-color: #E4E6EF;width: 12px;height: 12px"></div>
																	<!--end::Bullet-->
																	<!--begin::Label-->
																	<div class="text-gray-600 fs-5 fw-bold me-5">Collected:</div>
																	<!--end::Label-->
																	<!--begin::Stats-->
																	<div class="text-gray-700 ms-auto fw-bolder text-end">{{$lab_group_stats['collected']}}</div>
																	<!--end::Stats-->
																</div>
																<!--end::Label-->
															</div>
															<!--end::Labels-->
														</div>
														<!--end::Col-->
														<!--begin::Col-->
														{{-- <div class="px-0 col-5 d-flex justify-content-end">
															<!--begin::Chart-->
															<div id="kt_card_widget_19_chart" class="min-h-auto h-150px w-150px" data-kt-size="150" data-kt-line="25"><span></span><canvas height="150" width="150"></canvas></div>
															<!--end::Chart-->
														</div> --}}
														<!--end::Col-->
													</div>
													<!--end::Row-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card widget 19-->
										</div>
