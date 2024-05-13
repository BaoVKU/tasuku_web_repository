import { mailFileHTML } from "./components/mail-file";
$(function () {
    //select
    $(".mail-sent-item").click(function (e) {
        e.preventDefault();
        const mailForm = $("#mail-form");
        const mailID = $(this).val();
        let founded = GLOBAL_MAIL_LIST.find((item) => {
            return item["mail"].id == mailID;
        });
        const mailTo = founded["receivers"]
            .map((receiver) => {
                return receiver.email;
            })
            .join(", ");

        $("#mail-file-display").empty();
        mailForm[0].reset();
        mailForm.find('input[name="mail-to"]').val(mailTo);
        mailForm.find('input[name="mail-subject"]').val(founded["mail"].title);
        mailForm
            .find('textarea[name="mail-content"]')
            .val(founded["mail"].description);

        if (founded["attachments"]) {
            let html = "";
            founded["attachments"].forEach((attachment, index) => {
                const url = GLOBAL_HOST + attachment.url;
                html += mailFileHTML(
                    index,
                    attachment.name + "." + attachment.extension,
                    url
                );
            });
            $("#mail-file-display").html(html);
        }

        $("#mail-box").toggle();
    });

    //send
    $("#mail_file").change(function () {
        const files = $(this)[0].files;
        let html = "";
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileURL = URL.createObjectURL(file);
            html += mailFileHTML(i, file.name, fileURL);
        }
        $("#mail-file-display").html(html);
    });

    $("#mail-file-display").on("click", ".mail-file-delete-btn", function (e) {
        e.preventDefault();
        $(this).parent().remove();
        const index = $(this).data("index");
        const fileInput = $("#mail_file")[0];
        if (fileInput.length > 0) {
            const files = Array.from(fileInput.files);
            files.splice(index, 1);

            const newFileList = new DataTransfer();
            files.forEach((file) => newFileList.items.add(file));

            fileInput.files = newFileList.files;
        }
    });

    //delete
    $(".mail-delete-btn").click(function (e) {
        e.preventDefault();
        const mailID = $(this).val();
        $.ajax({
            url: GLOBAL_HOST + "mail/" + mailID,
            type: "DELETE",
            success: function (response) {
                console.log(response);
            },
        });
        $(this).parent().remove();
    });

    $("#send-gmail-btn").click(function (e) {
        e.preventDefault();
        $("#mail-form").attr("action", GLOBAL_HOST + "gmail");
        $("#mail-form").submit();
    });
});
