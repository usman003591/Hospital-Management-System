@if(checkPersonPermission('search_deposit_slips_section_51'))
 <div class="mb-5">
  <input type="text" id="q" name="search"
         class="mb-5 form-control form-control-solid mb-lg-0 bg-body-secondary"
         placeholder="Search deposit slip with Name or Slip Number">
</div>
@endif

<div class="card card-flush">
    <!--begin::Card body-->
    <div class="pt-0 card-body">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                <div  class="table-responsive">
                    <table id="deposit_slips_datatable" class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable">
                        <colgroup>
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: auto;">
                        </colgroup>
                        <thead class="text-gray-500 fs-7 text-uppercase">
                            <tr role="row" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom" data-dt-column="0">
                                    <span class="dt-column-title">Slip Number</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1">
                                    <span class="dt-column-title">User</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="2">
                                    <span class="dt-column-title">Hospital</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-type-numeric dt-orderable-asc dt-orderable-desc" data-dt-column="3">
                                    <span class="dt-column-title">Amount</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="4">
                                    <span class="dt-column-title">Date Issued</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="5">
                                    <span class="dt-column-title">Counter</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="6">
                                    <span class="dt-column-title">Purpose</span>
                                    <span class="dt-column-order"></span>
                                </th>
                                <th class="text-center min-w-50px dt-orderable-none" data-dt-column="7">
                                    <span class="dt-column-title">Actions</span>
                                    <span class="dt-column-order"></span>
                                </th>
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
