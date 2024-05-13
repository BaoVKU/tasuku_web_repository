@php
    use Carbon\Carbon;
    $curUserWhoIsMember = null;
    $completedMembers = collect();
    $progress = '0%';
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
    'class' =>
        'hidden bg-white fixed top-0 left-0 w-full h-full z-30 lg:top-1/2 lg:left-1/2 lg:-translate-x-1/2 lg:-translate-y-1/2 lg:w-[50vw] lg:max-h-[90vh] lg:rounded-lg',
]) !!}>
    <div class="border-b fixed top-0 left-0 w-full h-max z-40 py-2 bg-white lg:rounded-t-lg">
        <button
            class="popup-back-btn flex text-stone-600 text-xs items-center absolute top-0 left-0 h-full w-4 ml-2 lg:hidden">
            <x-icom.back-icon></x-icom.back-icon>
        </button>
        <p class="font-bold text-center text-xl">Comments</p>
        <button
            class="popup-close-btn hidden text-stone-600 text-xs items-center absolute top-0 right-2 h-full ml-2 lg:flex">
            <x-icom.close-icon width="24" height="24"></x-icom.close-icon>
        </button>
    </div>
    <div class="mt-12 mb-12 h-[88vh] lg:h-[76vh] overflow-y-auto">
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
            <div class="flex justify-end pr-2 sm:order-3">
                <span class="cmt-progress text-xs leading-10 lg:text-sm">{{ $progress }}</span>
            </div>
            <!-- end task options -->
            <!-- start task expiration date -->
            <div class="grow w-full sm:w-max sm:order-2">
                <span
                    class="bg-slate-200 flex flex-wrap rounded-md text-sm text-slate-600 px-1 py-0.5 font-medium ml-2 mt-2 sm:m-0 sm:bg-transparent sm:text-black sm:text-xs sm:leading-10 lg:font-normal lg:text-sm">
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
        <!-- start post action -->
        <div class="flex justify-around border-t border-b">
            <form action="{{ route('task.operate') }}" method="post"
                class="task-is-done-form grow flex justify-center">
                @csrf
                @method('POST')
                <input type="hidden" name="operation" value="done">
                <input type="hidden" name="task_id" value="{{ $item['task']->id }}">
                <button
                    @unless ($curUserWhoIsMember)
                    {{ 'disabled' }}
                @endunless
                    type="submit"
                    class="task-done-btn grow flex justify-center py-2 items-center text-xs font-medium lg:hover:bg-slate-200 disabled:hover:bg-white disabled:text-stone-500 {{ isset($curUserWhoIsMember) && !is_null($curUserWhoIsMember->is_completed) ? 'text-green-400' : '' }}">
                    <x-icom.done-icon class="mr-1"></x-icom.done-icon>
                    Done
                </button>
            </form>
            <button
                class="grow flex justify-center py-2 items-center text-xs text-sky-400 font-medium lg:hover:bg-slate-200">
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
                    class="task-important-btn grow flex justify-center py-2 items-center text-xs font-medium lg:hover:bg-slate-200 disabled:hover:bg-white disabled:text-stone-500 {{ isset($curUserWhoIsMember) && !is_null($curUserWhoIsMember->is_important) ? 'text-red-400' : '' }}">
                    <x-icom.important-icon></x-icom.important-icon>
                    Important
                </button>
            </form>
        </div>
        <!-- end post action -->
        <!-- start others comment -->
        <div id='cmt-area-{{ $item['task']->id }}'>
        </div>
        <!-- end others comment -->
    </div>
    <!-- start own comment -->
    <form enctype="multipart/form-data" action="{{ route('comment.store') }}" method="post"
        class="p-2 border-t fixed bottom-0 left-0 w-full h-max z-40 py-2 bg-white lg:rounded-b-lg"
        id='cmt-form-task-{{ $item['task']->id }}'>
        @csrf
        @method('POST')
        <input type="hidden" name="task_id" value="{{ $item['task']->id }}">
        <div class="cmt-image-preview-grid hidden pb-2 grid-cols-2 max-h-72 overflow-y-auto sm:grid-cols-4 gap-0.5">
        </div>
        <div class="cmt-file-preview-display pl-2 max-h-32 overflow-y-auto">
        </div>
        <div class="flex items-center">
            <button class="cmt-file-chooser p-2 rounded-full hover:bg-slate-200">
                <x-icom.image-icon width="16" height="16" class="lg:w-5 lg:h-5"></x-icom.image-icon>
            </button>
            <input type="file" name="cmt-choose-file" class="cmt-choose-file hidden" multiple>
            <input type="text" name="own-cmt" placeholder="Enter your comments..."
                class="bg-slate-100 text-sm border-none rounded-full px-3 py-1 mx-2 grow" />
            <button class="post-cmt-btn p-2 rounded-full hover:bg-slate-200" type="submit">
                <x-icom.send-icon width="16" height="16"></x-icom.send-icon>
            </button>
        </div>
    </form>
    <!-- end own comment -->
</div>
