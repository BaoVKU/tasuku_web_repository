export const chatPartnerHTML = function (
    channelID,
    channelName,
    partnerID,
    partnerName,
    avatar
) {
    return `<li
            name="${channelName}" value="${channelID}" aria-valuenow="${partnerID}"
            class= "chat-partner grow flex p-2 rounded-xl hover:bg-slate-200 hover:cursor-pointer">
            <div class="relative">
            <img src="${avatar}" class="w-10 h-10 object-cover relative mr-2"
                id="chat-partner-avatar" />
            <div
                class="user-activity w-3 h-3 bg-stone-500 rounded-full absolute bottom-0 right-2">
            </div>
        </div>
        <div class="grow w-72">
            <p class="flex max-h-5 items-center">
                <span class="text-sm font-semibold grow line-clamp-1 overflow-y-hidden"
                    id="chat-partner-name">${partnerName}</span>
                <span class="text-xs min-w-max" id="chat-last-sent">
                </span>
            </p>
            <p>
                <span class="text-xs text-stone-500 break-words line-clamp-1 grow" id="chat-last-message">
                </span>
            </p>
        </div>
    </li>
    `;
};
