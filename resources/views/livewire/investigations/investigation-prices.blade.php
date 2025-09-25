
<div>
<div class="card card-flush mb-10">
    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
            <h3 class="fw-bold mb-0">Investigation Prices List</h3>
        </div>
        {{-- You can add toolbar actions here if needed --}}
    </div>
    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>#</th>
                    <th>Investigation Name</th>
                    <th>Price</th>
                    <th>Valid From</th>
                    <th>Valid To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($investigationPrices as $index => $price)
                @php
                    $today = \Carbon\Carbon::now();
                    $from = \Carbon\Carbon::parse($price->valid_from);
                    $to = \Carbon\Carbon::parse($price->valid_to);
                    $isValid = $today->between($from, $to);
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $price->investigation_name }}</td>
                    <td>{{ number_format($price->price, 2) }}</td>
                    <td>{{ $price->valid_from }}</td>
                    <td>{{ $price->valid_to }}</td>
                    <td>
                        @if ($isValid)
                            <span class="badge badge-light-success">Valid</span>
                        @else
                            <span class="badge badge-light-danger">Invalid</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-danger"
                            wire:click="confirmDelete({{ $price->id }})">
                            <i class="bi bi-trash fs-4 text-danger"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

    <!-- Delete Confirmation Modal -->
<div wire:ignore.self class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteConfirmLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this price?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
      </div>
    </div>
  </div>
</div>

</div>
@push('scripts')
<script>
    window.addEventListener('show-delete-modal', () => {
        let modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        modal.show();
    });
    window.addEventListener('hide-delete-modal', () => {
        let modalEl = document.getElementById('deleteConfirmModal');
        let modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    });
</script>
@endpush
