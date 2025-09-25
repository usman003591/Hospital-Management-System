<div class="col-xl-12" wire:poll.5s>
    <div class="mb-5 card card-xl-stretch mb-xl-8">
        <div class="card-body">

            @forelse($notifications as $notification)
            <div class="d-flex flex-stack notification_item {{ $notification->is_read ? '' : 'bg-primary-subtle' }} rounded" style="padding:10px; border-bottom:1px solid #eee; margin-bottom:2px;">
                <button class="text-start py-2 btn btn-link p-0 m-0 " wire:click="changeStatus({{ $notification->id }})">

                    <div class="flex-grow-1 me-2">
                        <span class="text-gray-800 fw-bold text-hover-primary fs-6">
                            {{ $notification->notification_title }}
                        </span>
                        <span class="text fw-normal text-gray-700 d-block pt-2">
                            {!! $notification->notification_message !!}
                        </span>
                        <small class="text-muted d-block">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                </button>
            </div>
            @empty
                <div class="text-center py-5">No notifications found.</div>
            @endforelse

            <div class="row mt-4">
                <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                    <div>
                        @if($notifications->total() > 0)
                            Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }} of {{ $notifications->total() }} records
                        @else
                            No records found
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 d-flex align-items-start justify-content-start justify-content-md-end">
                    <div class="dt-paging paging_simple_numbers">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
