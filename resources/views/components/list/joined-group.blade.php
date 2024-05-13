@props(['joinKey'])
<li class="h-10 rounded-lg hover:bg-slate-200 my-1 relative group" id="{{ $joinKey }}">
    <button class="joined-group-btn w-full h-full text-left pl-2">
        {{ $name }}
    </button>
    <button
        class="group-share-btn lg:hidden absolute top-1/2 right-2 -translate-y-1/2 p-1 pr-1.5 rounded-full lg:group-hover:block hover:bg-slate-300"
        onclick="alert('Join key was copied to clipboard')"><svg xmlns="http://www.w3.org/2000/svg" width="16"
            height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="feather feather-share-2">
            <circle cx="18" cy="5" r="3"></circle>
            <circle cx="6" cy="12" r="3"></circle>
            <circle cx="18" cy="19" r="3"></circle>
            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
        </svg></button>
</li>
