@props(['messages'])

@if ($messages)
<p {{ $attributes->merge(['class' => 'text-danger dark:text-danger']) }}>
    @foreach ((array) $messages as $message)
    <small>{{ $message }}</small>
    @endforeach
</p>
@endif