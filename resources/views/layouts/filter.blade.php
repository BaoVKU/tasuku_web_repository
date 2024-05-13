<div
    class="hidden bg-white fixed top-0 left-0 w-full h-full z-20 lg:block lg:w-80 lg:h-auto lg:top-20 lg:right-4 lg:left-auto lg:rounded-xl lg:py-2 lg:z-0 lg:shadow-md">
    <div class="border-b relative py-2 lg:hidden">
        <button class="popup-back-btn flex text-stone-600 text-xs items-center absolute top-0 left-0 h-full w-4 ml-2">
            <x-icom.back-icon></x-icom.back-icon>
        </button>
        <p class="font-bold text-center text-xl">Filter Task</p>
    </div>
    <form class="p-2" id="task-filter">
        <div class="flex pb-2 border-b">
            <label for="creator-filter" class="font-semibold">Creator</label>
            <input type="text" name="creator-filter__name" placeholder="Enter creator name..."
                class="text-sm pl-2 ml-1 py-0.5 border-slate-200 rounded-md grow" />
        </div>
        <div class="pb-2 border-b">
            <label for="member-filter" class="font-semibold block">Member</label>
            <div class="grid grid-cols-3">
                <span class="flex items-center w-min">
                    <input class="ml-4 hover:cursor-pointer" type="radio" name="member-filter__radio"
                        value="your" />
                    <span class="text-sm inline-block w-max ml-1">Yours</span>
                </span>
                <span class="flex items-center w-min">
                    <input class="hover:cursor-pointer" type="radio" name="member-filter__radio" value="team" />
                    <span class="text-sm inline-block w-max ml-1">Your team</span>
                </span>
            </div>
            <div class="flex text-sm ml-4 mt-2">
                Tags
                <input type="text" name="member-filter__tag" placeholder="Use , to separate name..."
                    class="text-sm pl-2 ml-4 py-0.5 border-slate-200 rounded-md grow" />
            </div>
        </div>
        <div class="pb-2 border-b">
            <label for="expiration-date-filter" class="font-semibold block">Expiration Date</label>
            <div class="grid grid-cols-3">
                <span class="flex items-center w-min">
                    <input class="ml-4 hover:cursor-pointer" type="radio" name="expiration-date-filter__radio"
                        value="during" />
                    <span class="text-sm inline-block w-max ml-1">During</span>
                </span>
                <span class="flex items-center w-min">
                    <input class="hover:cursor-pointer" type="radio" name="expiration-date-filter__radio"
                        value="coming" />
                    <span class="text-sm inline-block w-max ml-1">Coming</span>
                </span>
                <span class="flex items-center w-min">
                    <input class="hover:cursor-pointer" type="radio" name="expiration-date-filter__radio"
                        value="expired" />
                    <span class="text-sm inline-block w-max ml-1">Expired</span>
                </span>
            </div>
            <div class="text-sm ml-4 mt-2">
                At
                <input type="date" name="expiration-date-filter__date"
                    class="text-sm pl-2 ml-6 py-0.5 border-slate-200 rounded-md hover:cursor-pointer" />
            </div>
        </div>
        <div class="pb-2 border-b">
            <label for="status-filter" class="font-semibold block">Status</label>
            <div class="grid grid-cols-3">
                <span class="flex items-center w-min">
                    <input class="ml-4 hover:cursor-pointer" type="radio" name="status-filter__radio"
                        value="new" />
                    <span class="text-sm inline-block w-max ml-1">New</span>
                </span>
                <span class="flex items-center w-min">
                    <input class="hover:cursor-pointer" type="radio" name="status-filter__radio" value="working" />
                    <span class="text-sm inline-block w-max ml-1">Working</span>
                </span>
                <span class="flex items-center w-min">
                    <input class="hover:cursor-pointer" type="radio" name="status-filter__radio" value="done" />
                    <span class="text-sm inline-block w-max ml-1">Done</span>
                </span>
            </div>
        </div>
        <div class="flex mt-2">
            <button type="submit" name="submit-filter-btn"
                class="bg-black text-white font-medium rounded-lg py-2 grow hover:bg-gray-400">
                Filter
            </button>
            <button type="reset" name="reset-filter-btn"
                class="flex justify-center items-center w-10 h-10 ml-2 bg-slate-100 rounded-full hover:bg-slate-200">

                <svg fill="#1C2033" width="16" height="16" version="1.1" id="lni_lni-brush"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 64 64" style="enable-background: new 0 0 64 64" xml:space="preserve"
                    class="rotate-180">
                    <g>
                        <path
                            d="M60.1,19.1L45,4c-2.9-2.9-7.5-2.9-10.4,0L20.1,18.5c-2.4,2.4-3.8,5.6-3.8,9.1c0,2.7,0.8,5.2,2.3,7.3L3.9,49.6
                                    c-1.4,1.4-2.2,3.2-2.2,5.1c0,2,0.8,3.9,2.2,5.3l0,0c1.4,1.4,3.3,2.1,5.2,2.1c1.9,0,3.8-0.7,5.2-2.1L29,45.3
                                    c2.2,1.6,4.8,2.4,7.4,2.4c3.3,0,6.6-1.2,9.1-3.7l14.5-14.5c1.4-1.4,2.1-3.2,2.1-5.2S61.5,20.5,60.1,19.1z M11.1,56.8
                                    c-1.1,1.1-2.9,1.1-4,0c-0.5-0.5-0.8-1.3-0.8-2c0-0.7,0.3-1.4,0.8-2l14.5-14.5l4,4L11.1,56.8z M30.6,40.8l-7.3-7.3
                                    c-1.6-1.6-2.4-3.7-2.4-5.9c0-2.2,0.9-4.3,2.4-5.9l2.5-2.5l19.1,19.1l-2.5,2.5C39.1,44,33.8,44,30.6,40.8z M56.9,26.3l-8.9,8.9
                                    L29,16.1l8.9-8.9c1.1-1.1,2.9-1.1,4,0l15.1,15.1c0.5,0.5,0.8,1.2,0.8,2S57.5,25.7,56.9,26.3z" />
                        <path d="M36.4,35.2c-0.9-0.9-2.3-0.9-3.2,0c-0.9,0.9-0.9,2.3,0,3.2c0.4,0.4,1,0.7,1.6,0.7s1.2-0.2,1.6-0.7
                                    C37.3,37.6,37.3,36.1,36.4,35.2L36.4,35.2z" />
                        <path d="M28.7,26.5c-0.9-0.9-2.3-0.9-3.2,0c-0.9,0.9-0.9,2.3,0,3.2c0.4,0.4,1,0.7,1.6,0.7s1.2-0.2,1.6-0.7
                            C29.6,28.9,29.6,27.4,28.7,26.5L28.7,26.5z" />
                    </g>
                </svg>
            </button>
        </div>
    </form>
</div>
