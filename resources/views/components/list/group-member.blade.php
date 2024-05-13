@props(['avatar', 'online' => false])
<li {!! $attributes->merge([
    'class' =>
        'inline-block max-h-14 sm:flex sm:items-center sm:w-full sm:rounded-xl hover:cursor-pointer sm:hover:bg-slate-200',
]) !!}>
    <div class="w-10 h-10 relative mx-1.5 sm:my-2">
        <img src="{{ $avatar }}" class="w-full h-full rounded-full object-cover">
        <div
            class="user-activity w-3 h-3 {{ $online ? 'bg-green-500' : 'bg-gray-500' }} rounded-full absolute bottom-0 right-0">
        </div>
    </div>
    <p class="hidden w-40 pr-2 sm:inline">
        <span class="line-clamp-1 grow">{{ $slot }}</span>
    </p>
</li>
