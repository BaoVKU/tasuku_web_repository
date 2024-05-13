import { chatTextHTML } from "./components/chat-text";
import { chatAnchorHTML } from "./components/chat-anchor";
import { chatImageHTML } from "./components/chat-image";
import { chatPartnerHTML } from "./components/chat-partner";
$(function () {
    var pusher = new Pusher("30737d5abc999ad51c2f", {
        cluster: "ap1",
    });

    //connect to partner
    $(".group-member").click(function (e) {
        e.preventDefault();
        const partnerID = $(this).val();
        const partnerName = $(this).find("span").text();
        const avatar = $(this).find("img").attr("src");

        $.post(
            GLOBAL_HOST + "chat/connect",
            { partner_id: partnerID },
            function (channel) {
                const hasChatted =
                    GLOBAL_CHAT_LIST &&
                    GLOBAL_CHAT_LIST.some(function (item) {
                        return item["chat_partner"].channel_id == channel.id;
                    });
                if (!hasChatted) {
                    $("#chat-list-list").prepend(
                        chatPartnerHTML(
                            channel.id,
                            channel.name,
                            partnerID,
                            partnerName,
                            avatar
                        )
                    );
                }
                $(`.chat-partner[value="${channel.id}"]`).click();
                $("#chat-list").toggle();
            }
        );
    });

    //chat box
    $("#chat-list-list").on("click", ".chat-partner", function () {
        const chatBox = $("#chat-box");
        const avatar = $(this).find("#chat-partner-avatar").attr("src");
        const partnerID = $(this).attr("aria-valuenow");
        const partnerName = $(this).find("#chat-partner-name").text();
        const channelID = $(this).val();
        const channelName = $(this).attr("name");
        const chatDisplay = $("#chat-display");

        $("#chat-box-profile-btn").val(partnerID);
        $("#chat-box-partner-avatar").attr("src", avatar);
        $("#chat-box-partner-name").text(partnerName);
        $("#chat-form").find('input[name="channel-id"]').val(channelID);

        $.get(GLOBAL_HOST + "chat/" + channelID, function (messages) {
            $("#chat-display").empty();
            messages.forEach((message) => {
                let isUserSent = message.sender_id == GLOBAL_AUTH_USER.id;
                let html = "";
                if (isUserSent) {
                    html = $('<li class="my-1 w-full flex justify-end"></li>');
                } else {
                    html = $(
                        '<li class="my-1 w-full flex justify-start"></li>'
                    );
                }
                if (message.message != null) {
                    html.html(chatTextHTML(message.message, isUserSent));
                } else {
                    const url = GLOBAL_HOST + message.url;
                    if (message.type.startsWith("image/")) {
                        html.html(chatImageHTML(url));
                    } else {
                        html.html(
                            chatAnchorHTML(
                                message.name + "." + message.extension,
                                url,
                                isUserSent
                            )
                        );
                    }
                }
                chatDisplay.append(html);
            });

            chatDisplay.animate(
                { scrollTop: chatDisplay[0].scrollHeight },
                "fast"
            );
        });

        $(this).find("#chat-last-message").removeClass("font-bold");
        $(this).find("#chat-last-sent div").remove();
        $("#chat-list").toggle();
        chatBox.attr("name", channelName);
        chatBox.toggle();
        $("#chat-notification").addClass("hidden");
    });

    //receive
    let chatChannels = [];
    chatChannels =
        GLOBAL_CHAT_LIST &&
        GLOBAL_CHAT_LIST.map((item) => item["chat_partner"].channel_name);

    chatChannels.forEach(function (channelName) {
        var channel = pusher.subscribe(channelName);
        channel.bind("message-event", function (data) {
            const chatBox = $("#chat-box");
            if (data.from != GLOBAL_AUTH_USER.id)
                if (data.channel == chatBox.attr("name")) {
                    const html = $(
                        '<li class="my-1 w-full flex justify-start"></li>'
                    );
                    if (data.message != null) {
                        html.html(chatTextHTML(data.message));
                    } else {
                        const url = GLOBAL_HOST + data.file.url;

                        if (data.file.type.startsWith("image/")) {
                            html.html(chatImageHTML(url));
                        } else {
                            html.html(
                                chatAnchorHTML(
                                    data.file.name + "." + data.file.extension,
                                    url
                                )
                            );
                        }
                    }
                    $("#chat-display").append(html);
                } else {
                    const chatListItem = $(
                        `.chat-partner[name="${data.channel}"]`
                    );
                    const lastMessage = chatListItem.find("#chat-last-message");
                    const lastSent = chatListItem.find("#chat-last-sent");
                    lastMessage.addClass("font-bold");
                    if (data.message != null) lastMessage.text(data.message);
                    else lastMessage.text(data.name + data.extension);
                    lastSent.html(
                        '<div class="w-2 h-2 bg-black rounded-full shadow-md"></div>'
                    );
                    $("#chat-notification").removeClass("hidden");
                }
        });
    });

    //send
    $("#chat-send-btn").click(function (e) {
        e.preventDefault();

        const form = $("#chat-form");
        const chatDisplay = $("#chat-display");
        const textInput = form.find('input[type="text"]');
        const fileInput = form.find('input[type="file"]')[0];
        const file = fileInput.files[0];
        const fileName = file ? file.name : "";
        const html = $('<li class="my-1 w-full flex justify-end"></li>');

        textInput.val() == fileName
            ? textInput.val("")
            : (fileInput.value = "");

        if (textInput.val() != "") {
            html.html(chatTextHTML(textInput.val(), true));
        } else {
            const url = URL.createObjectURL(file);

            if (file.type.startsWith("image/")) {
                html.html(chatImageHTML(url));
            } else {
                html.html(chatAnchorHTML(file.name, url, true));
            }
        }

        var formData = new FormData();
        formData.append("channel", form.find('input[name="channel-id"]').val());
        formData.append("from", GLOBAL_AUTH_USER.id);
        formData.append("message", textInput.val());

        if (file) formData.append("file", file);

        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                chatDisplay.animate(
                    { scrollTop: chatDisplay[0].scrollHeight },
                    "fast"
                );
            },
        });

        form[0].reset();

        chatDisplay.append(html);
    });

    //chat search
    $("#chat-search-form").submit(function (e) {
        e.preventDefault();
        let keyword = $(this).find('input[type="text"]').val();
        const sanitizedInput = keyword
            .replace(/\s/g, "")
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "");
        const regexPattern = new RegExp(sanitizedInput, "i");
        let founded = GLOBAL_CHAT_LIST.filter((item) => {
            return regexPattern.test(
                item["chat_partner"].partner_name
                    .replace(/\s/g, "")
                    .normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, "")
            );
        });
        if (founded) {
            $(".chat-partner").each(function () {
                const channelID = $(this).val();
                let isMatch = founded.find((item) => {
                    return item["chat_partner"].channel_id == channelID;
                });
                if (!isMatch) $(this).remove();
            });
        }
    });

    //chat show profile
    $("#chat-box-profile-btn").click(function (e) {
        e.preventDefault();
        window.location.href = GLOBAL_HOST + "profile/" + $(this).val();
    });

    $(".video-call-btn").click(function () {
        var width = screen.width * 0.7;
        var height = screen.height * 0.6;
        var left = screen.width / 2 - width / 2;
        var top = screen.height / 2 - height / 2;
        var userId = "userId" + $("#chat-box-profile-btn").val();
        window.open(
            GLOBAL_HOST + "video-call/" + userId,
            "_blank",
            "width=" +
                width +
                ",height=" +
                height +
                ",left=" +
                left +
                ",top=" +
                top
        );
    });
});
