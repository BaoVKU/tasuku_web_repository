<div style="display: none;" id="mail-list"
    class="bg-white fixed p-2 top-0 left-0 w-full h-full z-20 lg:w-[40vw] lg:h-min lg:top-16 lg:left-auto lg:right-20 lg:rounded-lg lg:shadow-lg">
    <div class="border-b relative py-2">
        <button
            class="popup-back-btn flex text-stone-600 text-xs items-center absolute top-0 left-0 h-full w-4 ml-2 lg:hidden">
            <x-icom.back-icon></x-icom.back-icon>
        </button>
        <p class="font-bold text-center text-xl">Mail</p>
    </div>
    <div class="w-full flex">
        <button id="mail-received-btn" class="grow mx-1 py-2 text-sm border-b-2 border-black">Received</button>
        <button id="mail-sent-btn"class="grow mx-1 py-2 text-sm text-slate-500">Sent</button>
    </div>
    @isset($mailList)

        <ul class="max-h-[94vh] overflow-y-auto lg:max-h-[70vh]" id="mail-list-received">
            @foreach ($mailList as $item)
                @if ($item['mail']->sender_id != auth()->user()->id)
                    <x-list.mail-received :item="$item"></x-list.mail-received>
                @endif
            @endforeach
        </ul>
        <ul class="hidden max-h-[94vh] overflow-y-auto lg:max-h-[70vh]" id="mail-list-sent">
            @foreach ($mailList as $item)
                @if ($item['mail']->sender_id == auth()->user()->id)
                    <x-list.mail-sent :item="$item"></x-list.mail-sent>
                @endif
            @endforeach
        </ul>
    @endisset
    <button
        class="mail-box-btn w-full bg-black text-white text-lg font-medium mt-2 py-1 rounded-lg uppercase hover:bg-gray-400">New</button>
</div>
