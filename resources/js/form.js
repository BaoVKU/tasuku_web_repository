import { groupItemHTML } from "./components/joined-group";
import { addTaskMemberHTML } from "./components/add-task-member";
import { addTaskFileHTML } from "./components/add-task-file";

$(function () {
    //create group
    $('#create-group-form button[name="create-btn"]').click(function (e) {
        e.preventDefault();
        $.post(
            $(this).parent().attr("action"),
            $(this).parent().serialize(),
            function (group) {
                if (group.responseText === undefined) {
                    const item = groupItemHTML(group);
                    $("#joined-group-list ul").append(item);
                }
            }
        );
        $("#black-background").click();
    });

    //join group
    $('#join-group-form button[name="join-btn"]').click(function (e) {
        e.preventDefault();
        $.post(
            $("#join-group-form").attr("action"),
            $("#join-group-form").serialize(),
            function (group) {
                if (group.responseText === undefined) {
                    const item = groupItemHTML(group);
                    $("#joined-group-list ul").append(item);
                }
            }
        );
        $("#black-background").click();
    });

    //add task - search member
    const searchInput = $("#add-task-form")
        .next()
        .find('input[name="keyword"]');
    $("#add-task-form .search-member").keyup(function (e) {
        searchInput.val($(this).val());
        searchInput.parent().submit();
    });
    searchInput.parent().submit(function (e) {
        e.preventDefault();
        const url =
            "/task/member?" + new URLSearchParams(new FormData($(this)[0]));
        $.get(url, function (res) {
            if (res.error == undefined) {
                const list = $(".add-task-member-suggest");
                list.parent().removeClass("hidden");
                let html = "";
                res.forEach((user) => {
                    html += `<li
                class="text-xs leading-6 line-clamp-1 text-ellipsis rounded-md p-1 hover:bg-slate-200 hover:cursor-pointer"
                id="${user.id}"
                >${user.name}</li>`;
                });
                list.html(html);
                list.children().click(function () {
                    const user = {
                        id: $(this).attr("id"),
                        name: $(this).text(),
                    };
                    $("#add-task-form .task-member-list").append(
                        addTaskMemberHTML(user)
                    );
                    list.parent().addClass("hidden");
                    list.children().remove();
                    $("#add-task-form .task-member-list").removeClass("hidden");
                    $("#add-task-form .task-member-list").addClass("flex");
                    $("#add-task-form .search-member").val("");
                });
            }
        });
    });

    //add task - members
    $("#add-task-form .task-member-list").on(
        "click",
        ".add-task-member-item",
        function () {
            $(this).remove();
            const taskMemberID = $(this).val();
            if (!$("#update-task-btn").hasClass("hidden"))
                $.ajax({
                    url: GLOBAL_HOST + "task/member/" + taskMemberID,
                    type: "delete",
                    success: function (response) {
                        GLOBAL_TASKS.forEach((item) => {
                            item.members.forEach(function (member, index) {
                                if (member.task_members_id == taskMemberID)
                                    item.members.splice(index, 1);
                            });
                        });
                    },
                });
        }
    );

    //add task - files
    $("#add-task-file").change(function (e) {
        $("#add-task-form .image-grid").removeClass("hidden");
        $("#add-task-form .image-grid").addClass("grid");
        $("#add-task-form .image-grid").empty();
        if (!$("#update-task-btn").hasClass("hidden")) {
            $(".delete-btn").each(function () {
                const attachmentID = $(this).val();
                $.ajax({
                    url:
                        window.location.origin +
                        "/task/attachment/" +
                        attachmentID,
                    type: "delete",
                    success: function (response) {
                        GLOBAL_TASKS.forEach((item) => {
                            item.attachments.forEach(function (
                                attachment,
                                index
                            ) {
                                if (attachment.attachment_id == attachmentID)
                                    item.attachments.splice(index, 1);
                            });
                        });
                    },
                });
            });
        }

        const files = $(this)[0].files;
        let html = "";
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            html += addTaskFileHTML(i, file.name);
            if (file.type.startsWith("image/")) {
                const fileURL = URL.createObjectURL(file);

                const image = $(
                    '<img class="w-full h-full object-cover rounded-lg border shadow-md">'
                ).attr("src", fileURL);
                const anchor = $(`<a class="block h-32" data-index="${i}">`)
                    .attr("href", fileURL)
                    .attr("target", "_blank")
                    .append(image);
                $("#add-task-form .image-grid").append(anchor);
            }
        }
        $("#add-task-form .files-display").removeClass("hidden");
        $("#add-task-form .files-display").html(html);
    });

    //update task - show
    $(".task-more-edit-btn").click(function (e) {
        const taskID = $(this).val();
        let taskItem = GLOBAL_TASKS.find((item) => item.task.id === taskID);
        const task = taskItem["task"];
        const members = taskItem["members"];
        const attachments = taskItem["attachments"];
        const form = $("#add-task-form");
        const imageGrid = $("#add-task-form .image-grid");
        const fileDisplay = $("#add-task-form .files-display");

        form[0].reset();
        imageGrid.empty();
        fileDisplay.empty();
        $("#add-task-form .task-member-list").empty();

        $(".add-task-wrapper").removeClass("hidden");
        $("#black-background").removeClass("hidden");
        $("#update-task-btn").removeClass("hidden");
        $("#add-task-btn").addClass("hidden");

        $(".add-task-label").text("Update task");
        form.append(
            $(`<input type="hidden" name="task_id" value="${taskID}"/>`)
        );

        let [startDay, startTime] = task.start.split(" ");
        form.find('input[name="start-day"]').val(startDay);
        form.find('input[name="start-time"]').val(startTime);

        let [endDay, endTime] = task.end.split(" ");
        form.find('input[name="end-day"]').val(endDay);
        form.find('input[name="end-time"]').val(endTime);

        form.find('input[name="title"]').val(task.title);
        form.find('textarea[name="description"]').val(task.description);

        if (members) {
            members.forEach((member) => {
                $("#add-task-form .task-member-list").append(
                    addTaskMemberHTML(member, member.task_members_id)
                );
            });
            $("#add-task-form .task-member-list").removeClass("hidden");
            $("#add-task-form .task-member-list").addClass("flex");
        }

        if (attachments) {
            let html = "";
            for (let i = 0; i < attachments.length; i++) {
                const file = attachments[i];
                html += addTaskFileHTML(
                    i,
                    file.name + "." + file.extension,
                    file.attachment_id
                );
                if (file.type.startsWith("image/")) {
                    const fileURL = GLOBAL_HOST + file.url;

                    const image = $(
                        '<img class="w-full h-full object-cover rounded-lg border shadow-md">'
                    ).attr("src", fileURL);
                    const anchor = $(`<a class="block h-32" data-index="${i}">`)
                        .attr("href", fileURL)
                        .attr("target", "_blank")
                        .append(image);
                    imageGrid.append(anchor);
                    imageGrid.removeClass("hidden");
                    imageGrid.addClass("grid");
                }
            }
            fileDisplay.removeClass("hidden");
            fileDisplay.html(html);
        }
    });

    //update task - mode change
    $("#add-task-form select").change(function () {
        if (!$("#update-task-btn").hasClass("hidden") && $(this).val() == 2) {
            $("#add-task-form .task-member-list")
                .children("li")
                .each(function () {
                    let taskMemberID = $(this).val();
                    $.ajax({
                        url:
                            window.location.origin +
                            "/task/member/" +
                            taskMemberID,
                        type: "delete",
                    });
                });
            $("#add-task-form .task-member-list").empty();
            GLOBAL_TASKS.forEach((item) => {
                if (
                    item.task.id ==
                    $('#add-task-form input[name="task_id"]').val()
                )
                    item.members.length = 0;
            });
        }
    });

    $("#add-task-form .files-display").on("click", ".delete-btn", function (e) {
        e.preventDefault();
        const index = $(this).data("index");
        const attachmentID = $(this).val();
        $(this).parent().remove();
        if ($("#update-task-btn").hasClass("hidden")) {
            const fileInput = $('#add-task-form input[type="file"]')[0];
            const files = Array.from(fileInput.files);
            files.splice(index, 1);

            const newFileList = new DataTransfer();
            files.forEach((file) => newFileList.items.add(file));

            fileInput.files = newFileList.files;
        } else {
            $.ajax({
                url: GLOBAL_HOST + "task/attachment/" + attachmentID,
                type: "delete",
                success: function (response) {
                    GLOBAL_TASKS.forEach((item) => {
                        item.attachments.forEach(function (attachment, index) {
                            if (attachment.attachment_id == attachmentID)
                                item.attachments.splice(index, 1);
                        });
                    });
                },
            });
        }
        $(`#add-task-form .image-grid a[data-index="${index}"]`).remove();
    });
    //update task - submit
    $("#update-task-btn").click(function (e) {
        e.preventDefault();
        $("#add-task-form").attr("action", GLOBAL_HOST + "task/update");
        $("#add-task-form").submit();
    });

    //task done button
    $(".task-done-btn").click(function (e) {
        e.preventDefault();
        $(this).parent().submit();
    });
    $(".task-done-btn")
        .parent()
        .submit(function (e) {
            e.preventDefault();
            const cmtProgress = $(this)
                .parent()
                .parent()
                .next()
                .find(".cmt-progress");
            var formData = $(this).serialize();
            const url = $(this).attr("action");
            $.post(url, formData, function (operation) {
                const button = $(
                    `.task-is-done-form input[value="${operation.task_id}"]`
                ).siblings("button");
                const progressBar = $(`#progress-task-${operation.task_id}`);
                let curCompleted = progressBar.attr("aria-valuemin");
                const totalMembers = progressBar.attr("aria-valuemax");
                const userAvatar = $(
                    `.task-member-avatar[aria-valuemin="${operation.user_id}"][aria-valuemax="${operation.task_id}"]`
                );
                let percent = 0;
                if (operation.is_completed == null) {
                    button.removeClass("text-green-400");
                    userAvatar.removeClass("ring-green-400");
                    userAvatar.addClass("ring-red-400");
                    curCompleted--;
                } else {
                    userAvatar.removeClass("ring-red-400");
                    userAvatar.addClass("ring-green-400");
                    button.addClass("text-green-400");
                    curCompleted++;
                }
                progressBar.attr("aria-valuemin", curCompleted);
                percent = (curCompleted * 100) / totalMembers;
                progressBar.animate({ width: `${percent}%` }, "fast");
                if (percent == 100) {
                    progressBar.addClass("bg-green-400");
                } else {
                    progressBar.removeClass("bg-green-400");
                }
                cmtProgress.text(`${percent}%`);
            });
        });

    //task important button
    $(".task-important-btn").click(function (e) {
        e.preventDefault();
        $(this).parent().submit();
    });
    $(".task-important-btn")
        .parent()
        .submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            const url = $(this).attr("action");
            $.post(url, formData, function (operation) {
                const button = $(
                    `.task-is-important-form input[value="${operation.task_id}"]`
                ).siblings("button");
                if (operation.is_important == null) {
                    button.removeClass("text-red-400");
                } else {
                    button.addClass("text-red-400");
                }
            });
        });

    //delete task
    $(".task-more-delete-btn").click(function () {
        const box = $("#confirm-box");
        box.removeClass("hidden");
        const taskID = $(this).val();
        box.attr("action", GLOBAL_HOST + "task/" + taskID);
        box.find(".text").text("Are you sure to delete?");
        box.append('<input type="hidden" name="_method" value="DELETE"/>');
    });
    $("#confirm-box").submit(function (e) {
        e.preventDefault();
        const formAction = $(this).attr("action");
        const formMethod = $(this).find('input[name="_method"]').val();
        if (formMethod == "DELETE") {
            $.ajax({
                url: formAction,
                type: "DELETE",
                success: function (response) {
                    location.reload();
                },
            });
        }
    });
});
