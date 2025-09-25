<div>
    <button type="button" class="btn btn-sm btn-primary" wire:click="showModal">
        Change Status Lab Invoice
    </button>

    <!-- Bootstrap Modal -->
    <div wire:ignore.self class="modal fade" id="livewireModal" tabindex="-1" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="submit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Change finance status for Lab Invoice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <input type="datetime-local" wire:model.defer="changed_at" class="form-control"
                                placeholder="Status Change Date" disabled>
                            @error('changed_at') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <textarea wire:model.defer="remarks" class="form-control"
                                placeholder="Status change remarks"></textarea>
                            @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                        <select wire:model.defer="verification_status" class="form-control">
                            <option value="">Select Verification Status</option>
                            <option value="1">Verified</option>
                            <option value="0">Unverified</option>
                        </select>
                        @error('verification_status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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

    {{-- @if (session()->has('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif --}}

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
