<div style="display: none;" id="notification-list"
    class="bg-white fixed p-2 top-0 left-0 w-full h-full z-20 lg:w-96 lg:h-min lg:top-16 lg:left-auto lg:right-2 lg:rounded-lg lg:shadow-lg">
    <div class="border-b relative py-2">
        <button
            class="popup-back-btn flex text-stone-600 text-xs items-center absolute top-0 left-0 h-full w-4 ml-2 lg:hidden">
            <x-icom.back-icon></x-icom.back-icon>
        </button>
        <p class="font-bold text-center text-xl">Notifications</p>
    </div>
    <ul id="notification-list-list" class="max-h-[80vh] overflow-y-auto">
        @isset($notifications)
            @foreach ($notifications as $notification)
                <li class="relative my-2 hover:bg-slate-200 rounded-lg">
                    <button class="w-full px-2 py-1" value="{{ $notification->url }}"
                        onclick="window.location.href = GLOBAL_HOST+this.value">
                        <p class="text-left text-xs text-stone-600">{{ $notification->created_at }}</p>
                        <p class="text-left text-sm line-clamp-1 text-ellipsis break-words">{{ $notification->content }}</p>
                        <p class="text-left text-lg font-medium line-clamp-1 text-ellipsis break-words">
                            {{ $notification->title }}</p>
                    </button>
                </li>
            @endforeach
        @endisset

    </ul>
</div>
