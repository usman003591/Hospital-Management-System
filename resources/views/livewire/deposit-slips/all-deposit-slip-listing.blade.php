<div class="container">
  <div class="row">
    <div class="col-md-12">
      {{-- @include('include.messages') --}}
      <style>
        #normal_reset {
          background-color: #e9f3ff;
          color: #1b84ff;
        }
        #normal_reset:hover {
          background-color: #1b84ff;
          color: white;
        }
      </style>

          <div class="mb-5 form-group row bg-search align-items-end">
              <!-- Search Input -->
              <div class="col-lg-4 mb-3 mb-lg-0">
                  <input type="text" wire:model.live.debounce.500ms="q" id="q" name="user_name"
                      class="ajax_call_trigger form-control form-control-solid bg-body-secondary"
                      placeholder="Search Deposit Slip with Name or Slip Number" maxlength="50">
              </div>

              <!-- Hospital Select -->
              <div class="col-lg-3 mb-3 mb-lg-0">
                  <select wire:model.live="hospital" class="form-select form-select-solid bg-body-secondary"
                      data-placeholder="Select Hospital" data-allow-clear="false">
                      <option value="">Select All Hospital</option>
                      @foreach($hospitals as $hospital)
                          <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                      @endforeach
                  </select>
              </div>

              <!-- Reset Button -->
              <div class="col-lg-2 col-12 ms-lg-auto">
                  <div class="d-flex justify-content-lg-end justify-content-start mt-2 mt-lg-0">
                      <button type="button" wire:click="resetFilters" id="normal_reset" class="btn btn-sm px-6">
                          Reset
                      </button>
                  </div>
              </div>
          </div>


      <div class="card card-flush">
        <div class="pt-0 card-body">
          <div class="table-responsive">
            <div id="kt_project_users_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
              <div class="table-responsive">
                <table id="kt_project_users_table"
                  class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable"
                  style="width: 0px;">
                  <thead class="text-gray-500 fs-7 text-uppercase">
                    <tr role="row" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                      <th data-dt-column="0" rowspan="1" colspan="1" aria-label="Slip Number" tabindex="0"
                        style="min-width: 10rem"><span class="dt-column-title">Slip Number</span></th>
                      <th data-dt-column="1" rowspan="1" colspan="1" aria-label="User" tabindex="0"
                        style="min-width: 12rem"><span class="dt-column-title">User</span></th>
                      <th data-dt-column="2" rowspan="1" colspan="1" aria-label="Hospital" tabindex="0"
                        style="min-width: 12rem"><span class="dt-column-title">Hospital</span></th>
                      <th data-dt-column="3" rowspan="1" colspan="1" aria-label="Amount" tabindex="0"
                        style="min-width: 10rem"><span class="dt-column-title">Amount</span></th>
                      <th data-dt-column="4" rowspan="1" colspan="1" aria-label="Date Issued" tabindex="0"
                        style="min-width: 10rem"><span class="dt-column-title">Date Issued</span></th>
                      <th data-dt-column="5" rowspan="1" colspan="1" aria-label="Counter" tabindex="0"
                        style="min-width: 7rem"><span class="dt-column-title">Counter</span></th>
                      <th data-dt-column="6" rowspan="1" colspan="1" aria-label="Purpose" tabindex="0"
                        style="min-width: 10rem"><span class="dt-column-title">Purpose</span></th>
                      <th data-dt-column="7" rowspan="1" colspan="1" aria-label="Actions" style="min-width: 7rem"
                        class="text-center"><span class="dt-column-title">Actions</span></th>
                    </tr>
                  </thead>
                  <tbody class="fs-6">
                    @if($data->count() > 0)
                      @foreach ($data as $d)
                        <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                          <td>{{ $d->deposit_slip_number }}</td>
                          <td>{{ $d->user_name }}</td>
                          <td>{{ $d->hospital_name }}</td>
                          <td class="dt-type-numeric">{{ number_format($d->amount_in_figures, 2) }}</td>
                          <td>{{ \Carbon\Carbon::parse($d->date_issued)->format('d M, Y') }}</td>
                          <td>{{ $d->counter_number }}</td>
                          <td title="{{ $d->payment_purpose }}">{{ \Str::limit($d->payment_purpose, 25, '...') }}</td>

                          <td class="d-flex justify-content-center align-items-center">

                            @if(checkPersonPermission('download_deposit_slips_section_51'))
                            <a title="Download Slip" target="_blank" href="{{ route($page.'.download', $d->id) }}">
                              
                                <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                    <i class="ki-duotone ki-folder-down fs-3 text-warning">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </button>
                            </a>
                            @endif

                              @if(checkPersonPermission('update_deposit_slips_section_51'))
                            <a title="Edit" href="{{ route($page.'.edit', $d->id) }}">
                                <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                    <i class="ki-duotone ki-pencil fs-3 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </button>
                            </a>
                            @endif

                            @if(checkPersonPermission('delete_deposit_slips_section_51'))
                            <a title="Delete" href="{{ route($page.'.delete', ['id' => $d->id]) }}"
                                data-id="{{ $d->id }}"
                                class="btn btn-icon btn-active-light-primary w-30px h-30px delete-{{$page}}"
                                data-kt-permissions-table-filter="delete_row">
                                <i class="ki-duotone ki-trash fs-3 text-danger">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                            </a>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    @else
                      <tr>
                        <td colspan="8">
                          No records found
                          @if(request()->has('q') || request()->has('hospital')) for the applied filters @endif
                        </td>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                  <div>
                    @if($data->total() > 0)
                      Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
                    @else
                      No records found
                      @if(request()->has('q') || request()->has('hospital'))
                        for the applied filters
                      @endif
                    @endif
                  </div>
                </div>
                <div class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
                  <div class="dt-paging paging_simple_numbers">
                    {!! $data->links('pagination::bootstrap-4') !!}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>