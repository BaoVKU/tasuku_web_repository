//user activity tracking
window.addEventListener("beforeunload", function () {
    var data = new FormData();
    data.append("_token", GLOBAL_CSRF_TOKEN);
    data.append("id", GLOBAL_AUTH_USER.id);
    navigator.sendBeacon(GLOBAL_HOST + "activity/disconnect/", data);
});

$(function () {
    var trackingPusher = new Pusher("30737d5abc999ad51c2f", {
        cluster: "ap1",
    });
    var userTrackingChannel = trackingPusher.subscribe("user-online-channel");
    userTrackingChannel.bind("online-event", function (user) {
        const groupMemberActivity = $(
            `.group-member[value="${user.id}"] .user-activity`
        );
        const chatPartnerActivity = $(
            `.chat-partner[aria-valuenow="${user.id}"] .user-activity`
        );
        if (user.isOnline) {
            groupMemberActivity.removeClass("bg-gray-500");
            groupMemberActivity.addClass("bg-green-500");
            chatPartnerActivity.removeClass("bg-gray-500");
            chatPartnerActivity.addClass("bg-green-500");
        } else {
            groupMemberActivity.removeClass("bg-green-500");
            groupMemberActivity.addClass("bg-gray-500");
            chatPartnerActivity.removeClass("bg-green-500");
            chatPartnerActivity.addClass("bg-gray-500");
        }
    });
});
