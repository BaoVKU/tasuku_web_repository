<div id="chat-list" style="display: none;"
    class="bg-white fixed top-0 left-0 w-full h-full p-2 z-20 overflow-y-auto lg:w-96 lg:h-auto lg:max-h-[70vh] lg:left-auto lg:top-16 lg:right-12 lg:shadow-lg lg:rounded-xl">
    <div class="border-b relative py-2">
        <button
            class="popup-back-btn flex text-stone-600 text-xs items-center absolute top-0 left-0 h-full w-4 ml-2 lg:hidden">
            <x-icom.back-icon></x-icom.back-icon>
        </button>
        <p class="font-bold text-center text-xl">Chat</p>
    </div>
    <form class="relative flex w-full h-auto items-center py-2" id="chat-search-form">
        <input type="text" name="chat-box-search" placeholder="Search chatting partner..."
            class="grow px-3 py-1 bg-slate-100 text-sm border-none rounded-full" />
        <button type="reset" class="absolute right-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-x-circle">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
        </button>
    </form>
    <ul class="flex flex-col" id="chat-list-list">
        @isset($chatList)
            @foreach ($chatList as $chat)
                <x-list.chat-partner :online="in_array($chat['chat_partner']->partner_id, $currentOnlineUsers)" :chat="$chat" class="chat-partner" :name="$chat['chat_partner']->channel_name"
                    :value="$chat['chat_partner']->channel_id" :aria-valuenow="$chat['chat_partner']->partner_id">
                </x-list.chat-partner>
            @endforeach
        @endisset
    </ul>
</div>
