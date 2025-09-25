   @if(checkPersonPermission('search_all_49'))
<div class="mb-5">
 <input type="text" id="q" name="user_name"
    class="mb-5 ajax_call_trigger form-control form-control-solid mb-lg-0 bg-body-secondary"
   placeholder="Search with Patient Name , Doctor Name , Counter Name , Token Number" value="{{$search['q']}}">
  </div>
  @endif
<!--begin::Card-->



<div class="table-responsive">
	<table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5">
		<thead>
			<tr class="fw-semibold fs-6 text-muted">
				<th>Patient Name</th>
				<th>Doctor Name</th>
				<th>Counter/Token</th>
				<th>MR Number</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>

		</tfoot>
	</table>
</div>
