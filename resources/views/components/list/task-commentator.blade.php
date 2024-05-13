@props(['avatar'])
<div class="p-2 flex flex-col items-stretch">
    <div class="flex mb-2">
        <button class="w-8 h-8 bg-[url('{{ $avatar }}')] bg-contain relative mx-1.5"></button>
        <div>
            <p class="font-semibold text-sm">
                {{ $name }}
            </p>
            <p class="flex">
                <span class="mr-1 text-xs text-stone-500">{{ $time }}</span>
            </p>
        </div>
    </div>
    <div class="text-xs text-justify bg-stone-100 rounded-md p-2 lg:text-sm">
        {{-- {{ $content }} --}}
        <ul class="cmt-file-area">
            <x-list.comment-file></x-list.comment-file>
        </ul>
        <div class="cmt-img-area grid grid-cols-5 gap-0.5">
            <a class="h-32" target="_blank"
                href="https://media.istockphoto.com/id/1470130937/photo/young-plants-growing-in-a-crack-on-a-concrete-footpath-conquering-adversity-concept.webp?b=1&s=170667a&w=0&k=20&c=IRaA17rmaWOJkmjU_KD29jZo4E6ZtG0niRpIXQN17fc=">
                <img src="https://media.istockphoto.com/id/1470130937/photo/young-plants-growing-in-a-crack-on-a-concrete-footpath-conquering-adversity-concept.webp?b=1&s=170667a&w=0&k=20&c=IRaA17rmaWOJkmjU_KD29jZo4E6ZtG0niRpIXQN17fc="
                    alt="" class="w-full h-full object-cover rounded-md">
            </a>
        </div>
    </div>
    <form>
        @csrf
        @method('DELETE')
        <input type="hidden" name="comment_id" value="">
    </form>
    <button
        class="cmt-delete-btn text-red-600 bg-red-200 self-end text-[10px] font-bold px-2 mt-1 rounded-full hover:bg-red-300">
        Delete
    </button>
</div>
