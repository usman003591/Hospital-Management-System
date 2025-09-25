            @if(checkPersonPermission('search_lab_groups_55'))
<div class="mb-5">
 <input type="text"  id="q" name="user_name"
    class="mb-5 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
    placeholder="Search with Patient Name and MR Number" >
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
                    <table id="lab-groups-datatable"
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
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                    colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                    style="min-width: 15rem"><span class="dt-column-title">Lab Group Number</span><span
                                        class="dt-column-order"></span>
                                </th>
                                <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                    data-dt-column="0" rowspan="1" colspan="1" aria-label="Manager: Activate to sort"
                                    tabindex="0" style="min-width: 18rem"><span class="dt-column-title ms-5">Patient
                                        Name</span><span class="dt-column-order"></span></th>

                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1"
                                    colspan="1" aria-label="Status: Activate to sort" tabindex="0"
                                    style="min-width: 15rem"><span class="dt-column-title">Status</span><span
                                        class="dt-column-order"></span></th>

                              
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                    colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                    style="min-width: 15rem"><span class="dt-column-title">MR Number</span><span
                                        class="dt-column-order"></span>
                                </th>
                                <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                    colspan="1" aria-label="Date: Activate to sort" tabindex="0"
                                    style="min-width: 15rem"><span class="dt-column-title">Created at</span><span
                                        class="dt-column-order"></span>
                                </th>
                                <th class="text-center dt-orderable-none" data-dt-column="4" rowspan="1" colspan="1"
                                    aria-label="Details" style="min-width: 7rem"><span
                                        class="dt-column-title">Actions</span><span class="dt-column-order"></span>
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

