<div>
    <button type="button" class="btn btn-sm btn-primary" wire:click="showModal">
        Create Investigation Price
    </button>

    <!-- Bootstrap Modal -->
    <div wire:ignore.self class="modal fade" id="livewireModal" tabindex="-1" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="submit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Add Investigation Price</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Show the investigation ID if you want -->
                        <div class="mb-3">
                            <label class="form-label">Investigation Name</label>
                            <input type="text" class="form-control" value="{{ $investigationName }}" disabled>
                        </div>
                        <div class="mb-3">
                            <input type="number" wire:model.defer="price" class="form-control"
                                placeholder="Investigation Price">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <input type="date" wire:model.defer="valid_from" class="form-control"
                                placeholder="Investigation Valid from">
                            @error('valid_from') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <input type="date" wire:model.defer="valid_to" class="form-control"
                                placeholder="Investigation Valid to">
                            @error('valid_to') <span class="text-danger">{{ $message }}</span> @enderror
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
