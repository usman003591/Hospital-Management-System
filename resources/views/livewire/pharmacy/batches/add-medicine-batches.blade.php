<div>
    <button type="button" class="btn btn-success btn-sm" wire:click="showModal">
            <i class="fas fa-plus"></i> Add Medicine Batch
    </button>

    <!-- Bootstrap Modal -->
    <div wire:ignore.self class="modal fade" id="livewireModal" tabindex="-1" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="submit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Add Medicine {{ $medicineName }} Batch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Show the investigation ID if you want -->
                        <div class="mb-3">
                            <label class="form-label">Batch Number</label>
                            <input type="text" class="form-control" wire:model.defer="batch_number" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Barcode</label>
                            <input type="text" class="form-control" wire:model.defer="barcode" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Medicine Batch Number</label>
                            <input type="text" class="form-control" wire:model.defer="medicine_batch_number" placeholder="Add Medicine Box batch number here" value="{{$medicine_batch_number}}" >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Manufacturing Date</label>
                            <input type="date" class="form-control" wire:model.defer="manufacturing_date" value="{{$manufacturing_date}}" >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" wire:model.defer="expiry_date"  value="{{$expiry_date}}" >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="text" wire:model.defer="quantity" placeholder="Enter quantity" class="form-control" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 9)">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Minimum Quantity</label>
                            <input type="text" wire:model.defer="medicine_minimum_quantity" placeholder="Enter minimum quantity" class="form-control" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 9)">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Packet Price</label>
                            <input type="text" wire:model.defer="packet_price" placeholder="Enter packet price" class="form-control" value=""
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 9)">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Packet Items</label>
                            <input type="text" wire:model.defer="packet_items" placeholder="Enter packet items" class="form-control" value=""
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').substring(0, 9)">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        window.addEventListener('show-bootstrap-modal', () => {
            var myModal = new bootstrap.Modal(document.getElementById('livewireModal'));
            myModal.show();
        });

        window.addEventListener('hide-bootstrap-modal', () => {
            var modalEl = document.getElementById('livewireModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {
        window.Livewire.on('show-toast', ({type, message}) => {
            if(type === 'success') {
                document.getElementById('successToastBody').textContent = message;
                var toast = new bootstrap.Toast(document.getElementById('successToast'));
                toast.show();
            }
            if(type === 'error') {
                document.getElementById('errorToastBody').textContent = message;
                var toast = new bootstrap.Toast(document.getElementById('errorToast'));
                toast.show();
            }
        });

        // Show first validation error as a toast (optional)
        window.addEventListener('livewire:error', (event) => {
            let detail = event.detail.errors;
            if(detail) {
                let firstKey = Object.keys(detail)[0];
                let firstError = detail[firstKey][0];
                document.getElementById('errorToastBody').textContent = firstError;
                var toast = new bootstrap.Toast(document.getElementById('errorToast'));
                toast.show();
            }
        });
    });
    </script>
    @endpush
</div>
