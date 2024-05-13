@props(['attachment'])
<a href="{{ asset($attachment->url) }}" target="_blank" class="h-32"><img src="{{ asset($attachment->url) }}"
        class="w-full h-full object-cover rounded-lg border shadow-md"></a>
