<div>
    <a href="#" class="btn btn-icon btn-sm me-1" wire:click="openModal" data-bs-toggle="tooltip" title="Edit">
        <i class="bi bi-pencil text-primary fs-5"></i>
    </a>

    <!-- Modal -->
    @if($showModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="update">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Edit Medicine {{ $medicineName }} Batch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                            aria-label="Close"></button>
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
                            <label class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" wire:model.defer="expiry_date"
                                value="{{$expiry_date}}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Manufacturing Date</label>
                            <input type="date" class="form-control" wire:model.defer="manufacturing_date"
                                value="{{$manufacturing_date}}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" wire:model.defer="quantity" placeholder="Enter quantity"
                                class="form-control" value="">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Minimum Quantity</label>
                            <input type="number" wire:model.defer="medicine_minimum_quantity"
                                placeholder="Enter minimum quantity" class="form-control" value="">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Packet Price</label>
                            <input type="number" wire:model.defer="packet_price" placeholder="Enter packet price"
                                class="form-control" value="">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Packet Items</label>
                            <input type="number" wire:model.defer="packet_items" placeholder="Enter packet items"
                                class="form-control" value="">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" wire:click="closeModal"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
