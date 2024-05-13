@props(['own' => false])
<li class="my-1 w-full flex {{ $own ? 'justify-end' : 'justify-start' }}">
    {{ $slot }}
</li>
