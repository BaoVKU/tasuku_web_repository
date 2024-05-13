<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>
    <aside id="default-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 sm:top-12 lg:top-16"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                @isset($groups)
                    @foreach ($groups as $group)
                        <li>
                            <a href="{{ asset('group-manager/' . $group->join_key) }}"
                                class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                                <span class="ms-3">{{ $group->name }}</span>
                            </a>
                        </li>
                    @endforeach
                    @isset($curGroup)
                        <li>
                            <a onclick="$('#group-manager-update-form').submit()"
                                class="flex items-center justify-center bg-black text-white text-sm p-2  rounded-lg  hover:bg-gray-600  group">
                                <span class="ms-3">Update group</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ asset('group-manager/destroy/' . $curGroup->id) }}"
                                class="flex items-center justify-center text-red-500 underline text-sm p-2  rounded-lg  hover:text-red-600 group">
                                <span class="ms-3">Delete group</span>
                            </a>
                        </li>
                    @endisset
                @endisset
            </ul>
        </div>
    </aside>
    @isset($curGroup)
        <section class="ml-4 sm:ml-72 mr-4 sm:mt-12 lg:mt-16">
            <form class="w-full px-2 pt-4 mx-auto grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3"
                id="group-manager-update-form" action="{{ route('group-manager.update') }}" method="post">
                @csrf
                @method('POST')
                <input type="hidden" name="id" value="{{ $curGroup->id }}">
                <div class="w-full">
                    <div class="mb-5">
                        <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Join
                            Key</label>
                        <input type="text" id="base-input" value={{ $curGroup->join_key }}
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="">
                        <label for="base-input"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" id="base-input" value="{{ $curGroup->name }} " name="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                </div>
                <div class="w-full mb-5">
                    <label for="message"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea id="message" name="description"
                        class="block p-2.5 w-full h-[132px] text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $curGroup->description }}</textarea>
                </div>
                <div class="w-full flex justify-around pt-7 pb-5 sm:col-span-2 lg:col-span-1">
                    <div
                        class="flex flex-col items-center justify-center w-full p-2 mb-4 mr-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 lg:mb-0">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-user mr-2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <h6 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $totalMembers }}
                            </h6>
                        </div>
                        <p class="font-bold text-xl">Members</p>
                    </div>
                    <div
                        class="flex flex-col items-center justify-center w-full p-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-edit-3 mr-2">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                            <h6 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $totalTasks }}
                            </h6>
                        </div>
                        <p class="font-bold text-xl">Tasks</p>
                    </div>
                </div>
            </form>
            <div class="bg-white relative overflow-x-auto shadow-md sm:rounded-lg">
                @if (isset($members))
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Join date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <img class="w-10 h-10 rounded-full" src="{{ asset($member->avatar) }}">
                                        <div class="ps-3">
                                            <div class="text-base font-semibold">{{ $member->name }}</div>
                                            <div class="font-normal text-gray-500">{{ $member->email }}</div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ Carbon\Carbon::parse($member->created_at)->format('H:i:s d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <!-- Modal toggle -->
                                        <a href="{{ asset('group-manager/kick/' . $curGroup->id . '/' . $member->id) }}"
                                            type="button" class="font-medium text-red-500 hover:underline">Kick</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="bg-white p-2"> {{ $members->links('pagination::tailwind') }}</div>
                @else
                    <center>There is no member join this group</center>
                @endif
            </div>
        </section>
    @endisset
</x-app-layout>
