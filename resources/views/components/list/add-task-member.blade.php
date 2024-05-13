@props(['id'])
<li class="mx-1" onclick="$(this).remove()">
    <input type="text" name="members[]" value="{{ $id }}" hidden>
    <button class="inline-block min-w-max text-sm py-1 px-2 bg-slate-200 text-slate-700 font-semibold rounded-lg">
        {{ $slot }}
    </button>
</li>
