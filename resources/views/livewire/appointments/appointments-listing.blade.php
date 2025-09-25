<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-5 form-group row bg-search">
                <div class="col-lg-5">
                    <input type="text" wire:model.live.debounce.500ms="q" id="q" name="q"
                           class="mb-3 form-control form-control-solid mb-lg-0 bg-body-secondary"
                           placeholder="Search by Patient Name, MR Number, Mobile Number, Doctor Name" value="" maxlength="50">
                </div>
                <div class="col-lg-3">
                    <select wire:model.live="hospital_id" id="hospital"
                            class="form-select form-select-solid bg-body-secondary">
                        @foreach($hospitals as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2">
                    <select wire:model.live="appointment_status_id" id="appointment_status_id"
                            class="form-select form-select-solid bg-body-secondary">
                        @foreach($appointmentStatuses as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 d-flex justify-content-end">
                    <button type="button" wire:click="resetFilters" class="btn btn-sm btn-light-primary">Reset</button>
                </div>
            </div>

            <div class="card card-flush">
                <div class="pt-0 card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-bordered table-row-dashed gy-4 fw-bold dataTable">
                            <thead class="text-gray-500 fs-7 text-uppercase">
                                <tr role="row" class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                    <th class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom"
                                        data-dt-column="0" rowspan="1" colspan="1" aria-label="Hospital: Activate to sort"
                                        tabindex="0" style="min-width: 10rem"><span class="dt-column-title">Hospital</span><span class="dt-column-order"></span></th>
                                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="1" rowspan="1"
                                        colspan="1" aria-label="Doctor: Activate to sort" tabindex="0"
                                        style="min-width: 10rem"><span class="dt-column-title">Doctor</span><span
                                            class="dt-column-order"></span></th>
                                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="2" rowspan="1" colspan="1"
                                        aria-label="Patient: Activate to sort" tabindex="0" style="min-width: 10rem"><span
                                            class="dt-column-title">Patient</span><span class="dt-column-order"></span></th>
                                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="3" rowspan="1" colspan="1"
                                        aria-label="Date: Activate to sort" tabindex="0" style="min-width: 10rem"><span
                                            class="dt-column-title">Date</span><span class="dt-column-order"></span></th>
                                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="4" rowspan="1" colspan="1"
                                        aria-label="Time: Activate to sort" tabindex="0" style="min-width: 8rem"><span
                                            class="dt-column-title">Time</span><span class="dt-column-order"></span></th>
                                    <th class="dt-orderable-asc dt-orderable-desc" data-dt-column="5" rowspan="1" colspan="1"
                                        aria-label="Status: Activate to sort" tabindex="0" style="min-width: 8rem"><span
                                            class="dt-column-title">Status</span><span class="dt-column-order"></span></th>
                                    <th class="text-center min-w-30px dt-orderable-none" data-dt-column="6" rowspan="1"
                                        colspan="1" aria-label="Actions"><span class="dt-column-title">Actions</span><span
                                            class="dt-column-order"></span></th>
                                </tr>
                            </thead>
                            <tbody class="fs-6">
                                @if (count($data) > 0)
                                    @foreach ($data as $d)
                                        <tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
                                            <td>{{ $d->hospital->name ?? 'N/A' }}</td>
                                            {{-- <td>{{ $d->doctor_name ?? 'N/A' }}</td> --}}
                                            <td>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <a href="" class="mb-1 text-gray-800 text-hover-primary">
                                                        @isset($d->doctor->doctor_name)
                                                            {{ $d->doctor->doctor_name }}
                                                        @endisset
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                            <td>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <a href="" class="mb-1 text-gray-800 text-hover-primary">
                                                        @isset($d->patient->name_of_patient)
                                                            {{ $d->patient->name_of_patient }} 
                                                        @endisset
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                            <td>{{ $d->date ? date('Y-m-d', strtotime($d->date)) : 'N/A' }}</td>
                                            {{-- <td>{{ $d->time ?? 'N/A' }}</td> --}}
                                            <td>{{ $d->time ? \Carbon\Carbon::parse($d->time)->format('g:i A') : 'N/A' }}</td>

                                            <td>{{ $d->appointmentStatus->name ?? 'N/A' }}</td>
                                            
                                            <td class="align-middle text-end">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    @if(checkPersonPermission('update_appointments_40'))
                                                        <a title="Edit" href="{{ route('appointments.edit', $d->id) }}">
                                                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                                <i class="ki-duotone ki-pencil fs-3 text-primary">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                    @if(checkPersonPermission('delete_appointments_40'))
                                                        <a title="Delete" href="{{ route('appointments.delete', ['id' => $d->id]) }}"
                                                           data-id="{{ $d->id }}"
                                                           class="btn btn-icon btn-active-light-primary w-30px h-30px delete-{{ $page }}"
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
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No records found @if($q || $hospital_id || $appointment_status_id) for the applied filters @endif</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar">
                                <div>
                                    @if($data->total() > 0)
                                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} records
                                    @else
                                        No records found @if($q || $hospital_id || $appointment_status_id) for the applied filters @endif
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.options = {
                "progressBar": true,
                "timeOut": "3000"
            };

            window.Livewire.on('show-toast', ({ type, message }) => {
                if (['success', 'info', 'warning', 'error'].includes(type)) {
                    toastr[type](message);
                } else {
                    toastr.info(message);
                }
            });
        });
    </script>
</div>