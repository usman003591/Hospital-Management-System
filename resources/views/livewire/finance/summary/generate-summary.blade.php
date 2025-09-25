<div>
    <!-- Filter Form -->
    <form wire:submit.prevent="generateSummary">
        <div class="mb-5 shadow-sm card">
            <div class="py-4 card-body">
                <div class="row g-3 align-items-center">

                    <!-- Invoice Type -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold">
                            Invoice Type <span class="text-danger">*</span>
                        </label>
                        <select wire:model="invoice_type" class="form-select form-select-solid bg-body-secondary"
                            required>
                            <option value="">Select Invoice Type</option>
                            <option value="pharmacy">Pharmacy</option>
                            <option value="pathology">Pathology</option>
                            <option value="services">Services</option>
                        </select>
                        @error('invoice_type') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <!-- Hospital -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold">
                            Hospital <span class="text-danger">*</span>
                        </label>
                        <select wire:model="hospital_id" class="form-select form-select-solid bg-body-secondary"
                            required>
                            <option value="">All Hospitals</option>
                            @foreach($hospitals as $hospital)
                            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                        @error('hospital_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <!-- Summary Year -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold">
                            Summary Year <span class="text-danger">*</span>
                        </label>
                        <select wire:model="summary_year" class="form-select form-select-solid bg-body-secondary"
                            required>
                            <option value="">Select Summary Year</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                        @error('summary_year') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <!-- Generate Button -->
                    <div class="mt-10 col-lg-3 col-md-6 d-flex justify-content-end">
                        <button type="submit" class="btn btn-light-primary text-end">
                            <i class="bi bi-graph-up-arrow me-2"></i> Generate Summary
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- Yearly Summary Table -->
    @if($summaryData)
    <div class="shadow-sm card">
        <div class="pt-6 border-0 card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Yearly Summary ({{ $summary_year }})</h3>
            <!-- Print Button -->
            @if(checkPersonPermission('generate_summary_pdf_summary_70'))
          <button wire:click="exportPdf" class="btn btn-sm btn-light-primary">
                <i class="bi bi-printer fs-5 me-1"></i> Print
            </button>
            @endif
        </div>
        <div class="py-4 card-body">
            <div class="table-responsive">
                <table class="table align-middle table-bordered table-row-dashed fs-6 gy-3">
                    <thead class="bg-light">
                        <tr class="text-center fw-bold text-muted">
                            <th class="text-start">Category</th>
                            <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Apr</th>
                            <th>May</th>
                            <th>Jun</th>
                            <th>Jul</th>
                            <th>Aug</th>
                            <th>Sep</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dec</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold text-start">Total Amount</td>
                            @foreach($summaryData['receivable'] as $receivable_amount)
                            <td class="text-end text-danger">{{ $receivable_amount }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="fw-bold text-start">Discount </td>
                            @foreach($summaryData['discount'] as $amount)
                            <td class="text-end">{{ $amount }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="fw-bold text-start">Net Amount</td>
                            @foreach($summaryData['net'] as $amount)
                            <td class="text-end">{{ $amount }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="fw-bold text-start">Received Amount</td>
                            @foreach($summaryData['received'] as $amount)
                            <td class="text-end text-success">{{ $amount }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @else

    <div class="shadow-sm card">
        <div class="pt-6 border-0 card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Yearly Summary </h3>
            <!-- Print Button -->
            {{-- <button class="btn btn-sm btn-light-primary" onclick="window.print()">
                <i class="bi bi-printer fs-5 me-1"></i> Print
            </button> --}}
        </div>
        <div class="py-4 card-body">
            <div class="table-responsive">
                <table class="table align-middle table-bordered table-row-dashed fs-6 gy-3">
                    <thead class="bg-light">
                        <tr class="text-center fw-bold text-muted">
                            <th class="text-start">Category</th>
                            <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Apr</th>
                            <th>May</th>
                            <th>Jun</th>
                            <th>Jul</th>
                            <th>Aug</th>
                            <th>Sep</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dec</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold text-start">Total Amount</td>
                            <td class="text-end text-danger">0</td>
                            <td class="text-end text-danger">0</td>
                            <td class="text-end text-danger">0</td>
                            <td class="text-end text-danger">0</td>
                            <td class="text-end text-danger">0</td>
                            <td class="text-end text-danger">0</td>
                            <td class="text-end text-danger">0</td>
                            <td class="text-end text-danger">0</td>
                            <td class="text-end text-danger">0</td>
                            <td class="text-end text-danger">0</td>
                            <td class="text-end text-danger">0</td>
                            <td class="text-end text-danger">0</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-start">Discount</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-start">Net Amount</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                            <td class="text-end">0</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-start">Received Amount</td>
                            <td class="text-end text-success">0</td>
                            <td class="text-end text-success">0</td>
                            <td class="text-end text-success">0</td>
                            <td class="text-end text-success">0</td>
                            <td class="text-end text-success">0</td>
                            <td class="text-end text-success">0</td>
                            <td class="text-end text-success">0</td>
                            <td class="text-end text-success">0</td>
                            <td class="text-end text-success">0</td>
                            <td class="text-end text-success">0</td>
                            <td class="text-end text-success">0</td>
                            <td class="text-end text-success">0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @endif
</div>
