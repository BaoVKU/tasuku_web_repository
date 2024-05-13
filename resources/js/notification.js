$(function () {
    var notificationPusher = new Pusher("30737d5abc999ad51c2f", {
        cluster: "ap1",
    });
    var notificationChannel = notificationPusher.subscribe(
        "notification-channel"
    );
    notificationChannel.bind("notification-event", function (notification) {
        console.log(notification);
        if (
            notification.creatorID != GLOBAL_AUTH_USER.id &&
            notification.receivers.find(
                (receiver) => receiver.id == GLOBAL_AUTH_USER.id
            )
        ) {
            const url = GLOBAL_HOST + notification.url;
            let html = `
        <li class="relative my-2 hover:bg-slate-100 rounded-lg">
            <button
                onclick="window.location.href='${
                    GLOBAL_HOST + notification.url
                }'"
                class="w-full px-2 py-1">
                <p class="text-left text-xs text-stone-600">${
                    notification.date
                }</p>
                <p class="text-left text-sm line-clamp-1 text-ellipsis break-words">${
                    notification.content
                }</p>
                <p class="text-left text-lg font-medium line-clamp-1 text-ellipsis break-words"">${
                    notification.taskTitle
                }</p>
            </button>
            <div class="absolute right-1 top-1 w-3 h-3 bg-black rounded-full"></div>
        </li>
        `;
            $("#notification-list-list").prepend(html);
            $("#notification-notification").removeClass("hidden");
        }
    });
});
