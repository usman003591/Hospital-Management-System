<div class="card card-flush mb-10">
    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
            <h3 class="fw-bold mb-0">Finance Verification Audit Logs</h3>
        </div>
    </div>
    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>#</th>
                    <th>Ip Address</th>
                    <th>Changed By</th>
                    <th>Changed At</th>
                    <th>Old Value</th>
                    <th>New Value</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($logs as $index => $log)
                @php
                    $today = \Carbon\Carbon::now();
                    $changed_at = \Carbon\Carbon::parse($log->changed_at);
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->changed_by_name }}</td>
                    <td>{{ $changed_at->format('d-m-Y h:i A') }}</td>
                    <td>{!!  getFinanceApprovalStatusLabel($log->old_value)  !!}</td>
                    <td>{!!  getFinanceApprovalStatusLabel($log->new_value)  !!}</td>
                    <td>{{ $log->remarks }}</td>
                    <!-- Actions can be added here if needed -->
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

