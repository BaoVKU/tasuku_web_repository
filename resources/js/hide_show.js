import tippy, { followCursor } from "tippy.js";
import "tippy.js/dist/tippy.css";
$(function () {
    //search bar
    const expandSearchInput = (function () {
        //closure
        let isExpanded = false;
        return function () {
            if (isExpanded) {
                $(".search-bar-input").addClass("expand-search-input");
            } else {
                $(".search-bar-input").removeClass("expand-search-input");
            }
            isExpanded = !isExpanded;
        };
    })();
    expandSearchInput();
    $(".search-bar-button").click(expandSearchInput);

    //black background
    const blackBackground = $("#black-background");
    blackBackground.click(function () {
        $(this).addClass("hidden");
        $(".add-task-wrapper").addClass("hidden");
        $(".task-comment-box").addClass("hidden");
        groupForm.addClass("hidden");
    });

    //tooltip
    const tooltipText = $("#tooltip");
    const tooltipFunction = function (e) {
        const $followingDiv = tooltipText;

        $followingDiv.css({
            left: e.pageX + 10,
            top: e.pageY + 10,
        });
    };

    //deleting confirm box
    $("#confirm-box .no-btn").click((e) => {
        e.preventDefault();
        $("#confirm-box").addClass("hidden");
    });

    //popup close button
    $(".popup-close-btn").click(function (e) {
        e.preventDefault();
        $(this).parent().parent().toggle();
        blackBackground.addClass("hidden");
    });

    //popup back button (only mobile)
    $(".popup-back-btn").click(function (e) {
        e.preventDefault();
        $(this).parent().parent().toggle();
        blackBackground.addClass("hidden");
    });

    //filter button (only mobile)
    $(".filter-btn").click((e) => {
        e.preventDefault();
        $(".filter").removeClass("hidden");
    });

    //show groups
    $(".mobile-show-group-btn").click(function () {
        $("#joined-group-list").removeClass("hidden");
    });

    //create group
    const groupForm = $(".group-form");
    const showCreateGroup = function (e) {
        e.preventDefault();
        groupForm.removeClass("hidden");
        groupForm.find("p").text("Create Group");
        $("#create-group-form").removeClass("hidden");
        $("#create-group-form").addClass("flex");
        $("#join-group-form").addClass("hidden");
        blackBackground.removeClass("hidden");
    };
    $(".pc-create-group-btn").click(showCreateGroup);
    $(".mobile-create-group-btn").click(showCreateGroup);

    //join group
    const showJoinGroup = function (e) {
        e.preventDefault();
        groupForm.removeClass("hidden");
        groupForm.find("p").text("Join Group");
        $("#create-group-form").addClass("hidden");
        $("#join-group-form").removeClass("hidden");
        $("#join-group-form").addClass("flex");
        blackBackground.removeClass("hidden");
    };
    $(".pc-join-group-btn").click(showJoinGroup);
    $(".mobile-join-group-btn").click(showJoinGroup);

    //add task
    $(".add-task-show-btn").click(function (e) {
        e.preventDefault();
        $("#add-task-form")[0].reset();
        $("#add-task-form .task-member-list").empty();
        $("#add-task-form .image-grid").empty();
        $("#add-task-form .files-display").empty();
        $(".add-task-wrapper").removeClass("hidden");
        $("#add-task-btn").removeClass("hidden");
        $("#update-task-btn").addClass("hidden");
        $(".add-task-label").text("Add task");
        $("#add-task-form").find('input[name="task_id"]').remove();
        blackBackground.removeClass("hidden");
    });

    //chat box level 1
    $(".chat-box-show-btn").click(function () {
        $("#chat-list").toggle();
    });

    $("#chat-choose-file").change(function () {
        $('#chat-form input[type="text"]').val($(this)[0].files[0].name);
    });

    //task post
    $(".progress-bar").mouseenter(function () {
        tooltipText.removeClass("hidden");
        const child = $(this).children().first();
        const curCompleted = child.attr("aria-valuemin");
        const totalMembers = child.attr("aria-valuemax");
        let percent = 0;
        if (totalMembers != 0)
            percent = Math.floor((curCompleted * 100) / totalMembers);
        tooltipText.html(
            `<center>${percent}%</center>${curCompleted}/${totalMembers} completed<p></p>`
        );
        $(document).mousemove(tooltipFunction);
    });
    $(".progress-bar").mouseleave(function () {
        tooltipText.addClass("hidden");
        $(document).off("mousemove", tooltipFunction);
    });

    $(".task-more-option-btn").click(function (e) {
        e.preventDefault();
        $(this).children().last().toggle();
    });

    $(".task-member-avatar").mouseenter(function () {
        tooltipText.removeClass("hidden");
        tooltipText.html($(this).prev().val());
        $(document).mousemove(tooltipFunction);
    });
    $(".task-member-avatar").mouseleave(function () {
        tooltipText.addClass("hidden");
        $(document).off("mousemove", tooltipFunction);
    });

    $("#comment-choose-file").change(function (e) {
        $(this).next().val(e.target.files[0].name);
    });

    const joinedGroupList = $("#joined-group-list");
    joinedGroupList.on("click", ".joined-group-btn", function () {
        window.location.href =
            "/workspace/group/" + $(this).parent().attr("id");
    });
    joinedGroupList.on("click", ".group-share-btn", async function () {
        await navigator.clipboard.writeText($(this).parent().attr("id"));
    });

    //profile
    $("#profile-update-form #avatar").change(function (e) {
        $(this)
            .prev()
            .children()
            .first()
            .attr("src", URL.createObjectURL(e.target.files[0]));
    });

    //add task
    $(".close-add-task-member-btn").click(function (e) {
        e.preventDefault();
        $(this).parent().addClass("hidden");
        $(this).parent().prev().val("");
        $(this).next().children().remove();
    });
    $("#add-task-form #mode").change(function (e) {
        if ($(this).val() == 2)
            $('#add-task-form input[name="members"]').addClass("hidden");
        else $('#add-task-form input[name="members"]').removeClass("hidden");
    });

    //mail
    $(".mail-list-btn").click(function () {
        $("#mail-list").toggle();
    });

    $(".mail-box-btn").click(function () {
        $("#mail-file-display").empty();
        $("#mail-form")[0].reset();
        $("#mail-box").toggle();
        $("#mail-list").toggle();
    });

    $("#mail-received-btn").click(function () {
        $(this).addClass("border-b-2 border-black");
        $(this).removeClass("text-slate-500");
        $("#mail-list-received").removeClass("hidden");
        $("#mail-list-sent").addClass("hidden");
        $("#mail-sent-btn").removeClass("border-b-2 border-black");
        $("#mail-sent-btn").addClass("text-slate-500");
    });
    $("#mail-sent-btn").click(function () {
        $(this).removeClass("text-slate-500");
        $(this).addClass("border-b-2 border-black");
        $("#mail-list-sent").removeClass("hidden");
        $("#mail-list-received").addClass("hidden");
        $("#mail-received-btn").removeClass("border-b-2 border-black");
        $("#mail-received-btn").addClass("text-slate-500");
    });

    //notification
    $(".notification-list-btn").click(function () {
        $("#notification-list").toggle();
        $("#notification-notification").addClass("hidden");
    });
});
