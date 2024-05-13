export const mailFileHTML = function (index, name, url) {
    return `<li class="flex items-center">
    <button class="mail-file-delete-btn p-1 mx-1 rounded-full hover:bg-stone-300" data-index="${index}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
    <a
    href="${url}" download="${name}"
    class="grow w-full underline text-sky-600 line-clamp-1 text-ellipsis break-words">${name}</a>
</li>`;
};
