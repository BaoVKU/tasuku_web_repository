<div
    class="add-task-wrapper hidden bg-white fixed top-0 left-0 w-full h-full z-30 lg:top-1/2 lg:left-1/2 lg:-translate-x-1/2 lg:-translate-y-1/2 lg:w-[580px] lg:h-auto lg:rounded-lg">
    <div class="border-b relative py-2">
        <button
            class="popup-back-btn flex text-stone-600 text-xs items-center absolute top-0 left-0 h-full w-4 ml-2 lg:hidden">
            <x-icom.back-icon></x-icom.back-icon>
        </button>
        <p class="add-task-label font-bold text-center text-xl">Add To-Do Task</p>
        <button class="popup-close-btn hidden items-center absolute top-0 right-2 h-full lg:flex">
            <x-icom.close-icon width="24" height="24"></x-icom.close-icon>
        </button>
    </div>
    <form class="flex flex-col items-stretch" id="add-task-form" action="{{ route('task.store') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('POST')
        @isset($group)
            <input type="hidden" name="group-id" value="{{ $group->id }}">
        @endisset
        <div class="p-2 max-h-[76vh] overflow-y-auto">
            <div class="flex flex-col items-stretch sm:flex-row sm:justify-stretch">
                <div class="flex sm:flex-col sm:basis-36">
                    <div class="grow pr-2 sm:pr-0">
                        <select name="mode" id="mode"
                            class="w-full py-2 border-none rounded-lg text-sm bg-slate-200 sm:py-1">
                            @isset($group)
                                <option value="1">Group</option>
                                <option value="0" class="">Public</option>
                            @endisset
                            <option value="2">Private</option>
                        </select>
                    </div>
                    <div class="grow">
                        <label
                            class="inline-block w-full leading-9 text-sm text-center rounded-lg bg-slate-200 hover:bg-slate-300 sm:leading-7"
                            for="add-task-file">Images/Files</label>
                        <input type="file" name="files[]" id="add-task-file" multiple hidden />
                    </div>
                </div>
                <div class="flex flex-col items-stretch py-2 sm:pl-2 sm:py-0 sm:grow">
                    <div class="flex mb-2">
                        <label class="basis-9 mr-2 lg:font-normal" for="start">From</label>
                        <input type="date" name="start-day"
                            class="grow w-32 border-slate-200 py-1 px-2 text-sm rounded-lg " />
                        <input type="time" name="start-time"
                            class="grow w-28 border-slate-200 ml-2 py-1 px-2 text-sm rounded-lg ">
                    </div>
                    <div class="flex sm:mb-2">
                        <label class="basis-9 mr-2 lg:font-normal" for="end">To</label>
                        <input type="date" name="end-day"
                            class="grow w-32 border-slate-200 py-1 px-2 text-sm rounded-lg" />
                        <input type="time" name="end-time"
                            class="grow w-28 border-slate-200 ml-2 py-1 px-2 text-sm rounded-lg ">
                    </div>
                </div>
            </div>
            <div class="">
                <div class="relative">
                    <input {{ isset($group) ? '' : 'disabled' }} type="text" name="members"
                        placeholder="Enter member name..."
                        class="search-member w-full h-full border-slate-200 py-1 px-2 text-sm rounded-lg disabled:opacity-50" />
                    <div class="hidden absolute top-full left-0 w-full mt-2">
                        <button
                            class="close-add-task-member-btn flex bg-white p-1 w-full justify-end rounded-t-md shadow-md">
                            <x-icom.close-icon stroke-width="1" width="12" height="12"></x-icom.close-icon>
                        </button>
                        <ul
                            class="add-task-member-suggest w-full max-h-28 p-1 bg-white rounded-b-md overflow-y-auto z-20">
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="task-member-list hidden pt-1 flex-nowrap overflow-x-auto">
            </ul>
            <div class="files-display hidden mt-1 py-1 max-h-20 overflow-y-auto">
            </div>
            <input type="text" name="title" placeholder="Enter task title..."
                class="border-slate-200 w-full rounded-lg py-1 px-2 my-2 font-medium lg:text-lg" />
            <textarea name="description" placeholder="Enter task description..." rows="6"
                class="w-full py-1 px-2 text-sm border-none rounded-lg focus:outline-0 lg:text-base"></textarea>
            <div class="image-grid hidden grid-cols-3 gap-0.5 mt-2">
            </div>
        </div>
        <button id="add-task-btn" type="submit" class="border-0 rounded-lg py-2 m-2 bg-black text-white font-medium">
            Post
        </button>
        <button id="update-task-btn" class="hidden border-0 rounded-lg py-2 m-2 bg-black text-white font-medium">
            Update
        </button>
    </form>
    <!--live search form -->
    <form action="/task/member" method="get">
        @csrf
        @method('GET')
        @isset($group)
            <input type="hidden" name="group_id" value="{{ $group->id }}">
        @endisset
        <input type="text" name="keyword" hidden>
    </form>
</div>
