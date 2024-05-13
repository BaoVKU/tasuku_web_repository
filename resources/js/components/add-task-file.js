export const addTaskFileHTML = function (index, name, id) {
    return `
    <div class="flex items-center">
        <button
        value="${id}"
            class="delete-btn p-1 flex justify-center items-center rounded-full hover:bg-slate-200 mr-1"
            data-index="${index}"
        >
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <p class="grow text-blue-600 text-sm underline">${name}</p>
    </div>
`;
};
