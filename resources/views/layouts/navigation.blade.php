<!-- start header -->
<nav class="fixed top-0 z-10 w-full py-2 bg-white flex items-center">
    <script>
        $(function() {
            if (window.location.href.indexOf(GLOBAL_HOST + "workspace") == -1) {
                $('.mail-list-btn').hide()
                $('.add-task-show-btn').hide()
                $('.chat-box-show-btn').hide()
                $('.notification-list-btn').hide()
            }
        })
    </script>
    <!-- start upper nav for mobile -->
    <x-application-logo></x-application-logo>
    <!-- start search bar -->
    {{-- <form class="relative hover:cursor-pointerr sm:grow z-30">
        <input type="text" name="search-input-field" placeholder="Search..."
            class="search-bar-input border-none rounded-full bg-slate-100 w-8 h-8 text-xs pr-0 pl-8 flex justify-center items-center lg:w-12 lg:h-12 lg:pl-12 lg:text-sm" />
        <button class="search-bar-button absolute top-0 left-0 w-8 h-8 flex justify-center items-center lg:w-12 lg:h-12">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-search lg:w-5 lg:h-5">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </button>
    </form> --}}
    {{-- <div class="hidden bg-white fixed top-0 left-0 w-full h-full z-20">
        <form class="px-2 py-2 flex items-center relative border-b">
            <button class="popup-back-btn flex text-stone-600 text-xs items-center w-6 h-8">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-chevron-left stroke-stone-600">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
        </form>
        <div class="search-suggest-box"></div>
    </div> --}}
    <!-- end search bar -->
    <!-- pause upper nav for mobile -->
    <!-- start lower nav for mobile -->
    <nav class="fixed grow bottom-0 py-2 w-full flex bg-white sm:justify-end sm:static sm:w-auto sm:py-0">
        <button onclick="window.location.href = GLOBAL_HOST + 'calendar'"
            class="border-none inline-block w-full flex-col justify-center items-center sm:flex-row sm:ml-2 sm:rounded-full sm:bg-slate-100 sm:w-8 sm:h-8 sm:order-2 lg:w-12 lg:h-12 lg:flex-row lg:hover:bg-slate-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather block w-full feather-calendar lg:h-5">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span class="text-xs select-none sm:hidden">Calendar</span>
        </button>
        <button
            class="mail-list-btn border-none inline-block w-full flex-col justify-center items-center sm:flex-row sm:ml-2 sm:rounded-full sm:bg-slate-100 sm:w-8 sm:h-8 sm:order-3 lg:w-12 lg:h-12 lg:flex-row lg:hover:bg-slate-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather block w-full feather-mail lg:h-5">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
            <span class="text-xs select-none sm:hidden">Mail</span>
        </button>
        <button
            class="add-task-show-btn border-none inline-block w-full flex-col justify-center items-center sm:flex-row sm:ml-2 sm:rounded-full sm:bg-slate-100 sm:w-8 sm:h-8 sm:order-1 lg:w-12 lg:h-12 lg:flex-row lg:hover:bg-slate-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather block w-full feather-plus lg:h-5">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span class="text-xs select-none sm:hidden">Add</span>
        </button>
        <button
            class="chat-box-show-btn relative border-none inline-block w-full flex-col justify-center items-center sm:flex-row sm:ml-2 sm:rounded-full sm:bg-slate-100 sm:w-8 sm:h-8 sm:order-4 lg:w-12 lg:h-12 lg:flex-row lg:hover:bg-slate-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather block w-full feather-message-circle lg:h-5">
                <path
                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                </path>
            </svg>
            <div id="chat-notification"
                class="absolute hidden w-2 h-2 top-0 right-1/2 translate-x-3 bg-black rounded-full shadow-lg ring-white ring-4 sm:right-0 sm:translate-x-0 lg:w-3 lg:h-3">
            </div>
            <span class="text-xs select-none sm:hidden">Message</span>
        </button>
        <button
            class="filter-btn border-none inline-block w-full flex-col justify-center items-center sm:flex-row sm:ml-2 sm:rounded-full sm:bg-slate-100 sm:w-8 sm:h-8 sm:order-5 lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-filter block w-full">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
            </svg>

            <span class="text-xs select-none sm:hidden">Filter</span>
        </button>
    </nav>
    <!-- end lower nav for mobile -->
    <!-- continue upper nav for mobile -->
    <div class="grow sm:hidden"></div>
    <button
        class="notification-list-btn relative border-none rounded-full bg-slate-100 w-8 h-8 ml-2 flex justify-center items-center lg:w-12 lg:h-12 lg:hover:bg-slate-200">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather block w-full feather-bell lg:w-5 lg:h-5">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>
        <div id="notification-notification"
            class="hidden absolute w-2 h-2 top-0 right-1/2 translate-x-3 bg-black rounded-full shadow-lg ring-white ring-2 sm:right-0 sm:translate-x-0 lg:ring-4 lg:w-3 lg:h-3">
        </div>
    </button>
    <button class="flex justify-end items-center relative group hover:cursor-pointer">
        <img src="{{ asset(Auth::user()->avatar) }}" alt="avatar"
            class="block w-8 h-8 mx-2 rounded-full border object-cover object-center lg:w-12 lg:h-12">
        <ul class="hidden group-hover:block absolute top-full right-0 w-max shadow-xl bg-white rounded-xl z-40">
            <li class="px-4 py-2 font-medium text-center rounded-t-lg border-b">
                {{ Auth::user()->name }}
            </li>
            <li class="lg:hover:bg-slate-200">
                <a href="{{ route('profile.edit') }}" class="flex px-4 py-2 justify-start items-center"
                    id="show-profile-btn">
                    <svg fill="#1C2033" width="16" height="16" version="1.1" id="lni_lni-pencil-alt"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve"
                        class="mr-1">
                        <path d="M62.2,11.9c0-0.8-0.3-1.6-0.9-2.2c-1.2-1.2-2.4-2.4-3.5-3.6c-1.1-1.1-2.1-2.2-3.2-3.2c-0.5-0.6-1.1-1-1.9-1.1
                            c-0.9-0.1-1.7,0.1-2.4,0.7l-6.8,6.8H8.1c-3.4,0-6.3,2.8-6.3,6.3V56c0,3.4,2.8,6.3,6.3,6.3h40.5c3.4,0,6.3-2.8,6.3-6.3V20.5l6.5-6.5
                            C61.9,13.4,62.2,12.7,62.2,11.9z M32.8,36c-0.1,0.1-0.1,0.1-0.2,0.1l-7.2,2.4l2.4-7.2c0-0.1,0.1-0.1,0.1-0.2l18-18l5,4.9L32.8,36z
                            M50.3,56c0,1-0.8,1.8-1.8,1.8H8.1c-1,0-1.8-0.8-1.8-1.8V15.5c0-1,0.8-1.8,1.8-1.8h30.8L24.7,28c-0.5,0.5-1,1.2-1.2,2l-3.7,11.2
                            c-0.3,0.8-0.1,1.5,0.3,2.2c0.3,0.4,0.9,1,2,1h0.4l11.5-3.8c0.7-0.2,1.4-0.7,1.9-1.2L50.3,25V56z M54,14.9L49,10l3.1-3.1
                            c0.8,0.8,4.1,4.1,4.9,5L54,14.9z" />

                    </svg>
                    <span>Profile</span>
                </a>
            </li>
            <li class="lg:hover:bg-slate-200">
                <a href="{{ route('group-manager.index') }}" class="flex px-4 py-2 justify-start items-center"
                    id="show-profile-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-pie-chart mr-1">
                        <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                        <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                    </svg>
                    <span>Group manager</span>
                </a>
            </li>
            <li
                class="mobile-show-group-btn flex px-4 py-2 justify-start items-center lg:hover:bg-slate-200 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="feather feather-file-text mr-1">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span>Group list</span>
            </li>
            <li
                class="mobile-join-group-btn flex px-4 py-2 justify-start items-center lg:hover:bg-slate-200 lg:hidden">

                <svg fill="#1C2033" width="16" height="16" stroke-width="2" version="1.1"
                    id="lni_lni-shift-right" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64"
                    style="enable-background: new 0 0 64 64" xml:space="preserve" class="mr-1">
                    <g>
                        <path
                            d="M56.9,1.8c-1.2,0-2.2,1-2.2,2.2v56c0,1.2,1,2.2,2.2,2.2s2.2-1,2.2-2.2V4C59.2,2.8,58.2,1.8,56.9,1.8z" />
                        <path
                            d="M33.3,22c-0.9-0.9-2.3-0.9-3.2,0c-0.9,0.9-0.9,2.3,0,3.2l6.9,7h-30c-1.2,0-2.2,1-2.2,2.2s1,2.2,2.2,2.2H37l-6.8,7
                        c-0.9,0.9-0.9,2.3,0,3.2c0.4,0.4,1,0.6,1.6,0.6c0.6,0,1.2-0.2,1.6-0.7L44,36c0.9-0.9,0.9-2.3,0-3.2L33.3,22z" />
                    </g>
                </svg>

                <span>Join group</span>
            </li>
            <li
                class="mobile-create-group-btn flex px-4 py-2 justify-start items-center lg:hover:bg-slate-200 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="feather feather-plus-square mr-1">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                <span>Create group</span>
            </li>
            <li class="border-t rounded-b-lg lg:hover:bg-slate-200">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @method('post')
                    <a class="flex px-4 py-2 justify-start items-center"
                        onclick="event.preventDefault();$(this).parent().next().submit();$(this).parent().submit()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-log-out mr-1 stroke-red-500">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span class="text-red-500 font-medium">Log out</span>
                    </a>
                </form>
                <form action="{{ route('activity.disconnect') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                </form>
            </li>
        </ul>
    </button>
    <!-- end upper nav for mobile -->
</nav>
<!-- end header -->
