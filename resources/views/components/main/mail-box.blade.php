<div {!! $attributes->merge([
    'class' =>
        'flex bg-white fixed top-0 left-0 w-full h-full flex-col z-20 lg:top-auto lg:left-auto lg:bottom-0 lg:right-6 lg:w-[40vw] lg:h-[66vh] lg:rounded-lg',
    'style' => 'display: none;',
]) !!}>
    @vite(['resources/js/mail.js'])
    <div class="bg-white border-b flex items-center py-2 lg:bg-black lg:text-white lg:rounded-t-lg">
        <button class="popup-back-btn flex text-stone-600 text-xs items-center h-full w-4 ml-2 lg:hidden">
            <x-icom.back-icon></x-icom.back-icon>
        </button>
        <span class="grow ml-2 text-center text-sm font-semibold line-clamp-1 overflow-y-hidden lg:text-left">New
            mail</span>
        <button class="popup-close-btn hidden p-2 mr-2 rounded-full hover:bg-stone-800 lg:block">
            <x-icom.close-icon width="20" height="20"></x-icom.close-icon>
        </button>
    </div>
    <form class="bg-white p-2 flex flex-col h-full justify-stretch" id="mail-form" action="{{ route('mail.store') }}"
        method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="flex items-center">
            <label for="mail-to" class="w-16">To:</label>
            <input type="text" name="mail-to" id="mail-to" class="w-full ml-2 text-sm border-none rounded-md"
                placeholder="Use , to separate receivers...">
        </div>
        <div class="flex my-2 items-center">
            <label for="mail-subject" class="w-16">Subject:</label>
            <input type="text" name="mail-subject" id="mail-subject"
                class="w-full text-lg font-medium ml-2 border-none rounded-md" placeholder="Enter mail subject...">
        </div>
        <div class="grow w-full h-full">
            <textarea name="mail-content" id="mail-content" class="w-full h-full border-none rounded-md"
                placeholder="Mail content..."></textarea>
        </div>
        <ul id="mail-file-display" class="min-h-max max-h-20 overflow-y-auto">
        </ul>
        <div class="flex w-full items-center justify-end mt-2">
            <label for="mail_file"
                class="h-full w-10 p-1 rounded-full flex items-center justify-center hover:bg-stone-300 hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-link stroke-stone-600">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                </svg>
            </label>
            <input type="file" name="mail_file[]" id="mail_file" hidden multiple>
            <button type="submit"
                class="bg-black text-white font-medium rounded-full py-2 px-4 mx-2 hover:bg-gray-700">Send</button>
            <input type="hidden">
            <button id="send-gmail-btn"
                class="bg-black text-white font-medium rounded-full py-2 px-4 flex items-center justify-center hover:bg-gray-700">
                <img src="{{ asset('storage/ico/gmail-icon.png') }}" alt="" width="20" height="20"
                    class="mr-1">
                Send by Gmail
            </button>
        </div>
    </form>
</div>
