@php
    use Carbon\Carbon;
    $curUserWhoIsMember = null;
    $completedMembers = collect();
    $progress = '0';
    if (isset($item['members']) && count($item['members']) > 0) {
        foreach ($item['members'] as $member) {
            if ($member->id == auth()->user()->id) {
                $curUserWhoIsMember = $member;
                break;
            }
        }
        $completedMembers = $item['members']->filter(function ($item) {
            return $item->is_completed !== null;
        });
        $progress = strval(floor(($completedMembers->count() * 100) / $item['members']->count())) . '%';
    }
@endphp
@props(['item'])
<div {!! $attributes->merge([
    'class' => 'bg-white mt-2 mb-8 sm:rounded-xl lg:shadow-md overflow-x-hidden',
]) !!}>
    <!-- start progress bar -->
    <x-main.progress-bar :id="'progress-task-' . $item['task']->id" style="width: {{ $progress }};" :class="$progress == '100%' ? 'bg-green-400' : ''"
        aria-valuemin="{{ $completedMembers->count() }}"
        aria-valuemax="{{ $item['members']->count() }}"></x-main.progress-bar>
    <!-- end progress bar -->
    <!-- start post header -->
    <div class="flex flex-wrap items-center sm:flex-nowrap sm:justify-between">
        <!-- start task poster -->
        <div class="grow flex py-2 sm:order-1">
            <img src="{{ asset($item['task']->creator_avatar) }}" class="w-10 h-10 mx-1.5 object-cover">
            <div>
                <p class="font-semibold line-clamp-1 text-ellipsis">{{ $item['task']->creator_name }}</p>
                <p class="flex">
                    <span class="mr-1 text-xs text-stone-500 line-clamp-1 text-ellipsis">
                        {{ Carbon::parse($item['task']->created_at)->diffForHumans() }}
                    </span>
                    <span class="self-center">
                        @if ($item['task']->mode == 0)
                            <x-icom.public-icon></x-icom.public-icon>
                        @elseif ($item['task']->mode == 1)
                            <x-icom.group-icon></x-icom.group-icon>
                        @elseif ($item['task']->mode == 2)
                            <x-icom.private-icon></x-icom.private-icon>
                        @endif
                    </span>
                </p>
            </div>
        </div>
        <!-- end task poster -->
        <!-- start task options -->
        @cannot('view-task-option', $item['task']->task_creator)
            <div class="w-11 sm:order-3"></div>
        @endcannot
        @can('view-task-option', $item['task']->task_creator)
            <div class="flex justify-end pr-2 sm:order-3">
                <button class="task-more-option-btn p-1 rounded-full hover:bg-slate-200 relative">
                    <x-icom.more-icon></x-icom.more-icon>
                    <ul class="task-more-option-box hidden absolute top-full right-0 mt-1 rounded-lg shadow-md z-20">
                        <li value={{ $item['task']->id }}
                            class="task-more-edit-btn bg-white text-left text-xs px-2 py-1 rounded-t-lg hover:bg-slate-200">
                            Edit
                        </li>
                        <li value={{ $item['task']->id }}
                            class="task-more-delete-btn bg-white text-left text-xs px-2 py-1 rounded-b-lg hover:bg-slate-200">
                            Delete
                        </li>
                    </ul>
                </button>
            </div>
        @endcan
        <!-- end task options -->
        <!-- start task expiration date -->
        <div class="grow w-full sm:w-max sm:order-2">
            <span
                class="bg-slate-200 flex flex-wrap justify-center rounded-md text-sm text-slate-600 px-1 py-0.5 font-medium mx-2 mt-2 sm:justify-start sm:m-0 sm:bg-transparent sm:text-black sm:text-xs sm:leading-10 lg:font-normal lg:text-sm">
                <span>{{ Carbon::parse($item['task']->start)->format('H:i:s d/m/Y') }}</span>
                <span class="px-2 font-bold">&middot;</span>
                <span>{{ Carbon::parse($item['task']->end)->format('H:i:s d/m/Y') }}</span>
            </span>
        </div>
        <!-- end task expiration date -->
    </div>
    <!-- end post header -->
    <!-- start post body -->
    <div class="p-2 lg:max-h-[68vh] lg:overflow-y-auto">
        <p class="text-lg font-semibold">
            {{ $item['task']->title }}
        </p>
        <p class="text-sm indent-6 text-justify">
            {{ $item['task']->description }}
        </p>
        @isset($item['attachments'])
            <ul class="my-2">
                @foreach ($item['attachments'] as $attachment)
                    @if (strpos($attachment->type, 'image') === false)
                        <x-list.task-file :attachment="$attachment"></x-list.task-file>
                    @endif
                @endforeach
            </ul>
            <div class="image-grid grid grid-cols-2 sm:grid-cols-3 gap-0.5">
                @foreach ($item['attachments'] as $attachment)
                    @if (strpos($attachment->type, 'image') !== false)
                        <x-list.task-image :attachment="$attachment"></x-list.task-image>
                    @endif
                @endforeach
            </div>
        @endisset
    </div>
    @if (isset($item['members']) && count($item['members']) > 0)
        <ul class="h-auto overflow-x-auto py-2 flex border-t sm:p-0">
            @foreach ($item['members'] as $member)
                <x-list.task-member :avatar="asset($member->avatar)" :uid="$member->id" :name="$member->name" :isdone="$member->is_completed"
                    :tid="$item['task']->id"></x-list.task-member>
            @endforeach
        </ul>
    @endif
    <!-- end post body -->
    <!-- start task action -->
    <div class="flex justify-around border-t">
        <form action="{{ route('task.operate') }}" method="post" class="task-is-done-form grow flex justify-center">
            @csrf
            @method('POST')
            <input type="hidden" name="operation" value="done">
            <input type="hidden" name="task_id" value="{{ $item['task']->id }}">
            <button @unless ($curUserWhoIsMember)
                {{ 'disabled' }}
            @endunless
                type="submit"
                class="task-done-btn grow flex justify-center py-2 items-center text-xs font-medium lg:hover:bg-slate-200 lg:hover:rounded-bl-xl disabled:hover:bg-white disabled:text-stone-500 {{ isset($curUserWhoIsMember) && !is_null($curUserWhoIsMember->is_completed) ? 'text-green-400' : '' }}">
                <x-icom.done-icon class="mr-1"></x-icom.done-icon>
                Done
            </button>
        </form>
        <form action="{{ route('comment.index') }}" method="get" hidden>
            @csrf
            @method('GET')
            <input type="hidden" name="task_id" value="{{ $item['task']->id }}">
        </form>
        <button value="{{ $item['task']->id }}"
            class="task-comment-btn grow flex justify-center py-2 items-center text-xs font-medium lg:hover:bg-slate-200">
            <x-icom.comment-icon></x-icom.comment-icon>
            Comment
        </button>
        <form action="{{ route('task.operate') }}" method="post"
            class="task-is-important-form grow flex justify-center">
            @csrf
            @method('POST')
            <input type="hidden" name="operation" value="important">
            <input type="hidden" name="task_id" value="{{ $item['task']->id }}">
            <button @unless ($curUserWhoIsMember)
                {{ 'disabled' }}
            @endunless
                class="task-important-btn grow flex justify-center py-2 items-center text-xs font-medium lg:hover:bg-slate-200 lg:hover:rounded-br-xl disabled:hover:bg-white disabled:text-stone-500 {{ isset($curUserWhoIsMember) && !is_null($curUserWhoIsMember->is_important) ? 'text-red-400' : '' }}">
                <x-icom.important-icon></x-icom.important-icon>
                Important
            </button>
        </form>
    </div>
    <!-- end task action -->
</div>
