@props(['own' => false])
<p class="py-1 px-2 {{ $own ? 'bg-black text-white' : 'bg-slate-100' }} rounded-full">{{ $slot }}</p>
