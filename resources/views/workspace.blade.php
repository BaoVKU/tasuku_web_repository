<x-app-layout>
    @isset($mailList)
        <script>
            GLOBAL_MAIL_LIST = @json($mailList);
        </script>
    @endisset
    @isset($chatList)
        <script>
            GLOBAL_CHAT_LIST = @json($chatList);
        </script>
    @endisset
    @isset($tasks)
        <script>
            const GLOBAL_TASKS = @json($tasks);
        </script>
    @endisset
    <script>
        let token = @json($jwt);
    </script>
    <script src="/js/video-call/receiving-call.js"></script>
    <div class="sm:ml-[20vw] lg:ml-[26vw]">
        <!-- start group member list -->
        <div class="group-member-list bg-white sm:fixed sm:left-2 sm:top-16 sm:w-56 sm:bg-transparent lg:top-20">
            <button
                class="pc-join-group-btn hidden w-full h-10 bg-black hover:bg-gray-400 text-white text-sm rounded-xl lg:block">
                Join group
            </button>
            <button
                class="pc-create-group-btn hidden w-full h-10 bg-slate-300 hover:bg-slate-400 text-black text-sm rounded-xl my-2 lg:block">
                Create group
            </button>
            <p class="text-sm font-bold pl-2 sm:w-56 sm:line-clamp-1 sm:text-ellipsis lg:text-base lg:border-t">
                {{ isset($group) ? $group->name : 'Not accessing any group' }}
            </p>
            @isset($groupMembers)
                <ul
                    class="h-auto overflow-x-auto overflow-y-hidden py-2 flex sm:flex-col sm:items-start sm:max-h-[74vh] sm:overflow-x-hidden sm:overflow-y-auto">
                    @foreach ($groupMembers as $member)
                        <x-list.group-member :value="$member->id" class="group-member" avatar="{{ asset($member->avatar) }}"
                            :online="in_array($member->id, $currentOnlineUsers)">{{ $member->name }}</x-list.group-member>
                    @endforeach
                </ul>
            @endisset
        </div>
        <!-- end group member list -->
        <!-- start to do list -->
        <div
            class="flex flex-col justify-stretch items-stretch sm:ml-20 sm:mr-2 sm:px-6 sm:py-2 sm:w-[70vw] lg:w-[40vw] lg:mx-0 lg:px-0">
            @isset($tasks)
                @foreach ($tasks as $item)
                    <div id="{{ 'todo-task-' . $item['task']->id }}" class="todo-task">
                        <x-main.task-component :item="$item"></x-main.task-component>
                        <!-- start task comment expansion -->
                        <x-main.task-comment :item="$item" class="task-comment-box">
                            <x-slot name="creator">Nguyễn Anh Dũng</x-slot>
                            <x-slot name="postedTime">2 hours ago</x-slot>
                            <x-slot name="expiration">00:00:00 14/06/2023 - 19:00:00 07/07/2023</x-slot>
                            <x-slot name="status">Working</x-slot>
                            <x-slot name="title">Sửa lại phần header</x-slot>
                            <x-slot name="description">Bernhard Staresina, giáo sư khoa học thần kinh
                                nhận thức tại Đại học Oxford, chia sẻ những bí
                                quyết giúp mọi người tăng cường trí nhớ và cải
                                thiện giấc ngủ của mình. Staresina cho biết giấc
                                ngủ ngon cực kỳ quan trọng với khả năng nhận
                                thức. Trong khoảng thời gian bộ não ở chế độ
                                "ngoại tuyến", nó tiếp tục hoạt động dựa trên ký
                                ức của con người. Ví dụ, những giấc ngủ ngắn là
                                một cách tăng cường trí nhớ tuyệt vời. Bernhard
                                Staresina, giáo sư khoa học thần kinh nhận thức
                                tại Đại học Oxford, chia sẻ những bí quyết giúp
                                mọi người tăng cường trí nhớ và cải thiện giấc
                                ngủ của mình. Staresina cho biết giấc ngủ ngon
                                cực kỳ quan trọng với khả năng nhận thức. Trong
                                khoảng thời gian bộ não ở chế độ "ngoại tuyến",
                                nó tiếp tục hoạt động dựa trên ký ức của con
                                người. Ví dụ, những giấc ngủ ngắn là một cách
                                tăng cường trí nhớ tuyệt vời. Bernhard
                                Staresina, giáo sư khoa học thần kinh nhận thức
                                tại Đại học Oxford, chia sẻ những bí quyết giúp
                                mọi người tăng cường trí nhớ và cải thiện giấc
                                ngủ của mình. Staresina cho biết giấc ngủ ngon
                                cực kỳ quan trọng với khả năng nhận thức. Trong
                                khoảng thời gian bộ não ở chế độ "ngoại tuyến",
                                nó tiếp tục hoạt động dựa trên ký ức của con
                                người. Ví dụ, những giấc ngủ ngắn là một cách
                                tăng cường trí nhớ tuyệt vời. Bernhard
                                Staresina, giáo sư khoa học thần kinh nhận thức
                                tại Đại học Oxford, chia sẻ những bí quyết giúp
                                mọi người tăng cường trí nhớ và cải thiện giấc
                                ngủ của mình. Staresina cho biết giấc ngủ ngon
                                cực kỳ quan trọng với khả năng nhận thức. Trong
                                khoảng thời gian bộ não ở chế độ "ngoại tuyến",
                                nó tiếp tục hoạt động dựa trên ký ức của con
                                người. Ví dụ, những giấc ngủ ngắn là một cách
                                tăng cường trí nhớ tuyệt vời.</x-slot>
                        </x-main.task-comment>
                        <!-- end task comment expansion -->
                    </div>
                @endforeach
                <script src="{{ asset('js/task-comment-form.js') }}" type="module"></script>
            @endisset
        </div>
        <!-- end to do list -->
    </div>
    @include('layouts.filter')
    <!-- start group list -->
    <div id="joined-group-list"
        class="fixed hidden top-0 left-0 p-2 w-full h-full bg-white z-20 lg:bg-transparent lg:top-[420px] lg:left-auto lg:right-4 lg:w-[320px] lg:block">
        <div class="border-b relative py-2 lg:hidden">
            <button
                class="popup-back-btn flex text-stone-600 text-xs items-center absolute top-0 left-0 h-full w-4 ml-2 lg:hidden">
                <x-icom.back-icon></x-icom.back-icon>
            </button>
            <p class="add-task-label font-bold text-center text-xl">Group List</p>
            <button class="popup-close-btn hidden items-center absolute top-0 right-2 h-full lg:flex">
                <x-icom.close-icon width="24" height="24"></x-icom.close-icon>
            </button>
        </div>
        <p class="hidden font-bold mb-2 lg:block lg:border-t">Groups</p>
        <ul class="h-full lg:max-h-[36vh] overflow-y-auto">
            @if (isset($joinedGroups))
                @foreach ($joinedGroups as $joinedGroup)
                    <x-list.joined-group joinKey="{{ $joinedGroup->join_key }}">
                        <x-slot name="name">{{ $joinedGroup->name }}</x-slot>
                    </x-list.joined-group>
                @endforeach
            @else
                Not in any group
            @endif
        </ul>
    </div>
    <!-- end group list -->
    <!-- start add task -->
    @include('layouts.add-task')
    <!-- end add task -->
    @include('layouts.mail-list')
    <x-main.mail-box id="mail-box"></x-main.mail-box>
    <!-- start chat -->
    @include('layouts.chat-list')
    <x-main.chat-box id="chat-box"></x-main.chat-box>
    <!-- end chat -->
    <!-- start notification -->
    @include('layouts.notification-list')
    <!-- end notification -->
    @include('layouts.group')
    <!-- start the opacity 70% background -->
    <div id="black-background" class="hidden fixed top-0 w-full h-full bg-black opacity-70 z-20"></div>
    <!-- end the opacity 70% background -->
    <div id="tooltip" class="hidden absolute bg-black p-2 text-white rounded-lg shadow-md z-50">This div
        follows the mouse</div>
    <form id="confirm-box" method="post"
        class="hidden bg-white fixed top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2  min-w-[200px] shadow-2xl rounded-lg outline outline-4 outline-offset-2 outline-black z-30">
        @csrf
        <p class="w-full text-center font-semibold border-b leading-8">Confirm Box</p>
        <p class="text grow text-center px-2 py-4">Confirm message</p>
        <div class="flex border-t divide-x">
            <button type="submit"
                class="yes-btn grow py-2 text-red-500 font-semibold rounded-bl-lg hover:bg-red-200">Yes</button>
            <button class="no-btn grow py-2 font-semibold rounded-br-lg  hover:bg-stone-200">No</button>
        </div>
    </form>
</x-app-layout>
