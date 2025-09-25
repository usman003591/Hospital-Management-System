@if(checkPersonPermission('search_invoices_section_8'))
<div class="mb-5">
 <input type="text" id="q" name="user_name"
    class="mb-5 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
    placeholder="Search with Patient Name and Receipt Number" value="{{$search['q']}}">
  </div>
  @endif
<!--begin::Card-->

<div class="card card-flush">
    <!--begin::Card body-->
    <div class="pt-0 card-body">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                <div  class="table-responsive">
                    <table id="invoices-datatable"
                        class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable"
                        style="width: 100%;">
                        <colgroup>
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                        </colgroup>
                        <thead class="text-gray-500 fs-7 text-uppercase">
                            <tr role="row" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                    data-dt-column="0" rowspan="1" colspan="1" aria-label="Receipt number: Activate to sort"
                                    tabindex="0" style="min-width: 90px">
                                    <span class="dt-column-title">Receipt number</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="2" rowspan="1"
                                    colspan="1" aria-label="Hospital: Activate to sort" tabindex="0"
                                    style="min-width: 150px">
                                    <span class="dt-column-title">Hospital Receipt#</span><span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                    colspan="1" aria-label="Patient Name: Activate to sort" tabindex="0"
                                    style="min-width: 150px">
                                    <span class="dt-column-title">Patient Name</span><span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="4" rowspan="1"
                                colspan="1" aria-label="Created at: Activate to sort" tabindex="0"
                                style="min-width: 150px">
                                <span class="dt-column-title">Date Issued</span><span class="dt-column-order"></span>
                            </th>
                            <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1"
                                colspan="1" aria-label="Date Issued: Activate to sort" tabindex="0"
                                style="min-width: 150px">
                                <span class="dt-column-title">Net Amount</span><span class="dt-column-order"></span>
                            </th>
                                <th class="min-w-90px dt-orderable-asc dt-orderable-desc" data-dt-column="5" rowspan="1"
                                    colspan="1" aria-label="Status: Activate to sort" tabindex="0"><span
                                        class="dt-column-title" role="button">Status</span><span
                                        class="dt-column-order"></span></th>
                                <th class="text-center min-w-50px dt-orderable-none" data-dt-column="6" rowspan="1"
                                    colspan="1" aria-label="Details"><span class="dt-column-title">Actions</span><span
                                        class="dt-column-order"></span></th>
                            </tr>
                        </thead>
                        <tbody class="fs-6">

                        </tbody>
                    </table>
                </div>

            </div>

            <!--end::Table-->
        </div>

        <!--end::Table container-->
    </div>
    <!--end::Card body-->
</div>
