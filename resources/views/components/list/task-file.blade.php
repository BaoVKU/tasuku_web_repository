@props(['attachment'])
<li class="flex items-center justify-start"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
        stroke-linejoin="round" class="feather feather-folder">
        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
    </svg><a href="{{ asset($attachment->url) }}" download="{{ $attachment->name . '.' . $attachment->extension }}"
        class="ml-1 py-0.5 px-1 text-sm rounded-md hover:bg-slate-300">{{ $attachment->name . '.' . $attachment->extension }}</a>
</li>
