@props(['online' => false, 'chat' => null])
<li {!! $attributes->merge(['class' => 'grow flex p-2 rounded-xl hover:bg-slate-200 hover:cursor-pointer']) !!}>
    <div class="relative">
        <img src="{{ asset($chat['chat_partner']->avatar) }}" class="w-10 h-10 object-cover relative mr-2"
            id="chat-partner-avatar" />
        <div
            class="user-activity w-3 h-3 {{ $online ? 'bg-green-500' : 'bg-stone-500' }} rounded-full absolute bottom-0 right-2">
        </div>
    </div>
    <div class="grow w-72">
        <p class="flex max-h-5 items-center">
            <span class="text-sm font-semibold grow line-clamp-1 overflow-y-hidden"
                id="chat-partner-name">{{ $chat['chat_partner']->partner_name }}</span>
            <span class="text-xs min-w-max" id="chat-last-sent">
                @isset($chat['last_message'])
                    {{ $chat['last_message']->created_at }}
                @endisset
            </span>
        </p>
        <p>
            <span class="text-xs text-stone-500 line-clamp-1 break-words text-ellipsis grow" id="chat-last-message">
                @isset($chat['last_message'])
                    @if (is_null($chat['last_message']->message))
                        {{ $chat['last_message']->name . '.' . $chat['last_message']->extension }}
                    @else
                        {{ $chat['last_message']->message }}
                    @endif
                @endisset
            </span>
        </p>
    </div>
</li>
