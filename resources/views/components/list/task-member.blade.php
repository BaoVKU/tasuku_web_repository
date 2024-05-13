@props(['avatar', 'uid' => 0, 'name' => '', 'isdone' => false, 'tid' => 0])
<li class="flex items-center hover:cursor-pointer relative group">
    <input type="hidden" name="{{ $uid }}" value="{{ $name }}">
    <img src="{{ $avatar }}" aria-valuemin="{{ $uid }}" aria-valuemax="{{ $tid }}"
        class="task-member-avatar w-8 h-8 object-cover mx-1.5 sm:my-1 rounded-full ring-2 {{ $isdone ? 'ring-green-400' : 'ring-red-400' }} ">
</li>
