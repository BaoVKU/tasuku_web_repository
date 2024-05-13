$(function () {
    //show task comment
    $(".task-comment-btn").click(function (e) {
        e.preventDefault();
        $(this).parent().parent().next().removeClass("hidden");
        const commentsArea = $(`#cmt-area-${$(this).val()}`);
        commentsArea.empty();
        const form = $(this).prev();
        $("#black-background").removeClass("hidden");
        $.get(form.attr("action"), form.serialize(), function (response) {
            response.forEach((comments) => {
                const content = comments["comment"];
                const attachments = comments["attachments"];
                let imagesHTML = "";
                let filesHTML = "";
                attachments.forEach((attachment) => {
                    let url = GLOBAL_HOST + attachment.url;
                    if (attachment.type.startsWith("image/"))
                        imagesHTML += `<a class="h-32" target="_blank" href="${url}">
                                    <img src="${url}" class="w-full h-full object-cover rounded-md">
                                </a>
                            `;
                    else
                        filesHTML += `<li class="flex items-center justify-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                            <polyline points="13 2 13 9 20 9"></polyline>
                                        </svg>
                                        <a href="${url}" download="${
                            attachment.name
                        }" class="ml-1 py-0.5 px-1 text-sm rounded-md hover:bg-stone-300">${
                            attachment.name + "." + attachment.extension
                        }</a>
                                </li>
                            `;
                });
                let html = `<div class="p-2 flex flex-col items-stretch" id="cmt-item-${
                    content.id
                }">
                <div class="flex mb-2">
                    <img src="${
                        GLOBAL_HOST + content.avatar
                    }" class="block w-8 h-8 mx-1.5"/>
                    <div>
                        <p class="font-semibold text-sm">
                            ${content.name}
                        </p>
                        <p class="flex">
                            <span class="mr-1 text-xs text-stone-500">${
                                content.created_at
                            }</span>
                        </p>
                    </div>
                </div>
                <div class="text-xs text-justify bg-stone-100 rounded-md p-2 lg:text-sm">
                    ${content.comment}
                    ${
                        filesHTML &&
                        '<ul class="cmt-file-area">' + filesHTML + "</ul>"
                    }
                    ${
                        imagesHTML &&
                        '<div class="cmt-img-area grid grid-cols-5 gap-0.5">' +
                            imagesHTML +
                            "</div>"
                    }
                </div>
                ${
                    GLOBAL_AUTH_USER.id == content.user_id
                        ? `<button value="${content.id}"
                    class="cmt-delete-btn text-red-600 bg-red-200 self-end text-[10px] font-bold px-2 mt-1 rounded-full hover:bg-red-300"
                    >
                    Delete
                </button>`
                        : ""
                }
                        </div>`;
                commentsArea.append(html);
            });
            $(".cmt-delete-btn").click(function (e) {
                e.preventDefault();
                const box = $("#confirm-box");
                box.removeClass("hidden");
                const taskID = $(this).val();
                console.log(box);
                console.log(taskID);
                box.attr("action", GLOBAL_HOST + "task/comment/" + taskID);
                box.find(".text").text("Are you sure to delete?");
                box.append(
                    '<input type="hidden" name="_method" value="DELETE"/>'
                );
            });
        });
    });

    $(".cmt-file-chooser").click(function (e) {
        e.preventDefault();
        $(this).next().click();
    });

    //file
    $(".cmt-choose-file").change(function (e) {
        const form = $(this).parent().parent().attr("id");
        const taskID = form.slice(form.lastIndexOf("-") + 1);
        const cmtFileDisplay = $(this).parent().prev();
        const cmtImgGrid = $(this).parent().prev().prev();
        cmtImgGrid.removeClass("hidden");
        cmtImgGrid.addClass("grid");
        cmtImgGrid.empty();

        const files = $(this)[0].files;
        let html = "";
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            html += `
                    <div class="flex items-center">
                        <button
                            class="cmt-delete-btn p-1 flex justify-center items-center rounded-full hover:bg-slate-200 mr-1"
                            data-index="${i}" value="${taskID}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                        <p class="grow text-blue-600 underline">${file.name}</p>
                    </div>`;
            if (file.type.startsWith("image/")) {
                const imageUrl = URL.createObjectURL(file);

                const image = $(
                    '<img class="w-full h-full object-cover rounded-lg border shadow-md">'
                ).attr("src", imageUrl);
                const anchor = $(`<a class="h-32" data-index="${i}">`)
                    .attr("href", imageUrl)
                    .attr("target", "_blank")
                    .append(image);
                cmtImgGrid.append(anchor);
            }
        }
        cmtFileDisplay.removeClass("hidden");
        cmtFileDisplay.html(html);
    });

    $(".cmt-file-preview-display").on("click", ".cmt-delete-btn", function (e) {
        e.preventDefault();
        const index = $(this).data("index");
        $(this).parent().remove();
        const fileInput = $(
            `#cmt-form-task-${$(this).val()} input[type="file"]`
        )[0];
        const files = Array.from(fileInput.files);
        files.splice(index, 1);

        const newFileList = new DataTransfer();
        files.forEach((file) => newFileList.items.add(file));

        fileInput.files = newFileList.files;
        $(`#cmt-form-task-${$(this).val()}`)
            .find("div")
            .find(`a[data-index="${index}"]`)
            .remove();
    });

    // post comment
    $(".post-cmt-btn").click(function (e) {
        e.preventDefault();
        const form = $(this).closest("form");
        const commentsArea = form.prev().children().last();
        var files = $(this).prev().prev()[0].files;
        var formData = new FormData();
        formData.append("_token", GLOBAL_CSRF_TOKEN);
        formData.append("_method", "POST");
        formData.append("task_id", form.find('input[name="task_id"]').val());
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            formData.append("files[]", file);
        }
        formData.append("comment", $(this).prev().val());
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (comments) {
                console.log(comments);
                const content = comments[0];
                const attachments = comments[1];
                let imagesHTML = "";
                let filesHTML = "";
                if (attachments)
                    attachments.forEach((attachment) => {
                        let url = GLOBAL_HOST + attachment.url;
                        if (attachment.type.startsWith("image/"))
                            imagesHTML += `<a class="h-20" target="_blank" href="${url}">
                                    <img src="${url}" class="w-full h-full object-cover rounded-md">
                                </a>
                            `;
                        else
                            filesHTML += `<li class="flex items-center justify-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                            <polyline points="13 2 13 9 20 9"></polyline>
                                        </svg>
                                        <a href="${url}" download="${
                                attachment.name
                            }" class="ml-1 py-0.5 px-1 text-sm rounded-md hover:bg-stone-300">${
                                attachment.name + "." + attachment.extension
                            }</a>
                                </li>
                            `;
                    });
                let html = `<div class="p-2 flex flex-col items-stretch">
                <div class="flex mb-2">
                    <img src="${
                        GLOBAL_HOST + GLOBAL_AUTH_USER.avatar
                    }" class="block w-8 h-8 mx-1.5"/>
                    <div>
                        <p class="font-semibold text-sm">
                            ${GLOBAL_AUTH_USER.name}
                        </p>
                        <p class="flex">
                            <span class="mr-1 text-xs text-stone-500">Just commented</span>
                        </p>
                    </div>
                </div>
                <div class="text-xs text-justify bg-stone-100 rounded-md p-2 lg:text-sm">
                    ${content.comment}
                    ${
                        filesHTML &&
                        '<ul class="cmt-file-area">' + filesHTML + "</ul>"
                    }
                    ${
                        imagesHTML &&
                        '<div class="cmt-img-area grid grid-cols-5 gap-0.5">' +
                            imagesHTML +
                            "</div>"
                    }
                </div>
                <form>
                    <input type="hidden" name="_token" value="${GLOBAL_CSRF_TOKEN}">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="comment_id" value="${
                        content.id
                    }">
                </form>
                <button
                    class="cmt-delete-btn text-red-600 bg-red-200 self-end text-[10px] font-bold px-2 mt-1 rounded-full hover:bg-red-300"

                    >
                    Delete
                </button>
                        </div>`;
                commentsArea.prepend(html);
            },
        });
        form[0].reset();
        form.find(".cmt-image-preview-grid").empty();
        form.find(".cmt-file-preview-display").empty();
    });
});
