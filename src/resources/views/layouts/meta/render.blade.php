@if ($meta->name == 'title' && !$meta->property)
    <title>{{ $meta->content }}</title>
@else
    <meta content="{{ $meta->content }}" @if ($meta->property) property="{{ $meta->property }}"  @elseif ($meta->name) name="{{ $meta->name }}" @endif>
@endif
