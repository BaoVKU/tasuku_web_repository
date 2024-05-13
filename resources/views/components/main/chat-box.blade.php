<div {!! $attributes->merge([
    'class' =>
        'flex bg-white fixed top-0 left-0 w-full h-full flex-col z-20 lg:top-auto lg:left-auto lg:bottom-0 lg:right-6 lg:w-96 lg:h-[60vh] lg:rounded-lg',
    'style' => 'display: none;',
]) !!}>
    <div class="bg-white border-b flex items-center py-2 lg:bg-black lg:text-white lg:rounded-t-lg">
        <button class="popup-back-btn flex text-stone-600 text-xs items-center h-full w-4 ml-2 lg:hidden">
            <x-icom.back-icon></x-icom.back-icon>
        </button>
        <button class="grow flex items-center justify-start" id="chat-box-profile-btn" value="">
            <img src="" class="w-10 h-10 object-cover mx-1.5" id="chat-box-partner-avatar" />
            <span class="grow text-left text-sm font-semibold line-clamp-1 overflow-y-hidden"
                id="chat-box-partner-name"></span>
        </button>
        <button class="video-call-btn p-2 rounded-full hover:bg-stone-800">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-video">
                <polygon points="23 7 16 12 23 17 23 7"></polygon>
                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
            </svg>
        </button>
        <button class="popup-close-btn hidden p-2 mr-2 rounded-full hover:bg-stone-800 lg:block">
            <x-icom.close-icon width="20" height="20"></x-icom.close-icon>
        </button>
    </div>
    <ul class="p-2 text-sm overflow-y-auto overscroll-contain grow" id="chat-display">
    </ul>
    <form class="bg-white p-2 flex justify-around items-center" id="chat-form" action="{{ route('chat.store') }}"
        method="post">
        @csrf
        @method('POST')
        <input type="hidden" name="channel-id" value="">
        <label class="block p-1 rounded-full hover:bg-slate-200" for="chat-choose-file">
            <x-icom.image-icon width="20" height="20"></x-icom.image-icon>
        </label>
        <input type="file" name="chat-choose-file" id="chat-choose-file" hidden>
        <div class="grow px-2 relative">
            <input type="text" name="send-message-field" placeholder="Your messages..."
                class="bg-slate-200 text-sm border-none rounded-full py-1 pl-2 pr-8 w-full" />
            <button class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2" id="chat-send-btn" type="submit">
                <x-icom.send-icon width="18" height="18"></x-icom.send-icon>
            </button>
        </div>
    </form>
</div>
