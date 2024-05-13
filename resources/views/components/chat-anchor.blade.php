@props(['own' => false, 'url'])
<a class="py-1 px-2 rounded-full {{ $own ? 'bg-black text-white' : 'bg-slate-100' }} underline"
    href="{{ $url }}">
    {{ $slot }}
</a>
