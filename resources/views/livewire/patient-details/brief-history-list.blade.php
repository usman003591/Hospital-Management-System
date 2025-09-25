<div>

    @if ($briefHistories->isEmpty())
    <p class="text-muted">No brief history records found.</p>
    @else
    @foreach ($briefHistories as $history)
    <div class="card card-bordered mb-3">
        <div class="card-body">
            <p>{{ $history->description }}</p>
            <br>
            <small class="text-muted">{{ $history->created_at->format('d M Y H:i') }}</small>
        </div>
        {{-- <div class="card-footer">
            {{ $history->created_at->format('d M Y') }}
        </div> --}}
    </div>
    @endforeach
    @endif
</div>
