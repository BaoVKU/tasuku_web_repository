@props(['item' => null])
<li class="flex my-2 rounded-lg hover:bg-slate-100 hover:cursor-pointer">
    <button class="mail-sent-item grow flex flex-col p-1" value="{{ $item['mail']->id }}">
        <p class="text-xs text-stone-600">{{ Carbon\Carbon::parse($item['mail']->created_at)->format('H:i:s d/m/Y') }}
        </p>
        <p class="text-sm text-stone-700 line-clamp-1 text-ellipsis break-words">To:
            @isset($item['receivers'])
                {{ $item['receivers']->pluck('email')->implode(', ') }}
            @endisset
        </p>
        <p class="text-lg font-medium line-clamp-1 text-ellipsis break-words">{{ $item['mail']->title }}</p>
    </button>
    <button class="mail-delete-btn px-2 text-red-500 hover:bg-red-200 rounded-r-lg" value="{{ $item['mail']->id }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-trash-2">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            <line x1="10" y1="11" x2="10" y2="17"></line>
            <line x1="14" y1="11" x2="14" y2="17"></line>
        </svg>
    </button>
</li>
