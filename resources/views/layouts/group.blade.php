<div
    class="group-form hidden bg-white fixed flex-col w-full h-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-30 lg:w-96 lg:h-auto lg:rounded-lg">
    <header class="relative py-2.5 border-b">
        <p class="text-center text-lg font-semibold">Create Group</p>
        <button class="popup-back-btn absolute top-0 flex text-stone-600 text-xs items-center h-full w-4 ml-2 lg:hidden">
            <x-icom.back-icon></x-icom.back-icon>
        </button>
        <button class="popup-close-btn hidden items-center absolute top-0 right-2 h-full lg:flex">
            <x-icom.close-icon width="20" height="20"></x-icom.close-icon>
        </button>
    </header>
    <form id="join-group-form" class="hidden flex-col p-2" action="{{ route('group.join') }}" method="post">
        @csrf
        @method('POST')
        <label for="join-key" class="mb-0.5">Join Key</label>
        <input type="text" name="join-key" class="rounded-md border-gray-300">
        <button name="join-btn" class="bg-black text-white h-10 mt-2 rounded-lg hover:bg-gray-400">Join</button>
    </form>

    <form id="create-group-form" class="flex-col p-2" action="{{ route('group.store') }}">
        @csrf
        @method('POST')
        <label for="name" class="mb-0.5">Group Name</label>
        <input type="text" name="name" class="rounded-md border-gray-300">
        <label for="description" class="mt-2 mb-0.5">Group Description</label>
        <textarea name="description" rows="6" class="rounded-md border-gray-300"></textarea>
        <button name="create-btn" class="bg-black text-white h-10 mt-2 rounded-lg hover:bg-gray-400">Create</button>
    </form>
</div>
