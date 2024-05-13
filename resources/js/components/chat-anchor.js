export const chatAnchorHTML = function (name, url, own = false) {
    return `<a class="py-1 px-2 rounded-full ${
        own ? "bg-black text-white" : "bg-slate-100"
    } underline"
    href="${url}" download="${name}">
    ${name}
</a>`;
};
