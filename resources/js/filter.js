$(function () {
    $("#task-filter").submit(function (e) {
        e.preventDefault();

        const creatorInput = $(this)
            .find('input[name="creator-filter__name"]')
            .val();
        const memberRadio = $(this)
            .find('input[name="member-filter__radio"]:checked')
            .val();
        const memberInput = $(this)
            .find('input[name="member-filter__tag"]')
            .val();
        const dateRadio = $(this)
            .find('input[name="expiration-date-filter__radio"]:checked')
            .val();
        const dateInput = $(this)
            .find('input[name="expiration-date-filter__date"]')
            .val();
        const statusRadio = $(this)
            .find('input[name="status-filter__radio"]:checked')
            .val();

        let founded = GLOBAL_TASKS;

        //start buffer filter
        if (creatorInput) {
            const sanitizedInput = creatorInput
                .replace(/\s/g, "")
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "");
            const regexPattern = new RegExp(sanitizedInput, "i");

            founded = founded.filter((item) => {
                const creatorName = item["task"].creator_name;

                return regexPattern.test(
                    creatorName
                        .replace(/\s/g, "")
                        .normalize("NFD")
                        .replace(/[\u0300-\u036f]/g, "")
                );
            });
        }

        switch (memberRadio) {
            case "your": {
                founded = founded.filter((item) => {
                    return item["task"].mode == 2;
                });
                break;
            }
            case "team": {
                const sanitizedInput = GLOBAL_AUTH_USER.name
                    .replace(/\s/g, "")
                    .normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, "");
                const regexPattern = new RegExp(sanitizedInput, "i");

                founded = founded.filter((item) => {
                    return (
                        item["members"].length > 0 &&
                        item["members"].find((member) => {
                            return regexPattern.test(
                                member.name
                                    .replace(/\s/g, "")
                                    .normalize("NFD")
                                    .replace(/[\u0300-\u036f]/g, "")
                            );
                        })
                    );
                });
                break;
            }
            default:
                break;
        }

        if (memberInput) {
            memberInput.split("-").forEach((memberName) => {
                const sanitizedInput = memberName
                    .replace(/\s/g, "")
                    .normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, "");
                const regexPattern = new RegExp(sanitizedInput, "i");
                founded = founded.filter((item) => {
                    return (
                        item["members"].length > 0 &&
                        item["members"].find((member) => {
                            return regexPattern.test(
                                member.name
                                    .replace(/\s/g, "")
                                    .normalize("NFD")
                                    .replace(/[\u0300-\u036f]/g, "")
                            );
                        })
                    );
                });
            });
        }

        switch (dateRadio) {
            case "during": {
                founded = founded.filter((item) => {
                    const startTime = new Date(item["task"].start);
                    const endTime = new Date(item["task"].end);
                    const currentTime = new Date();
                    return currentTime >= startTime && currentTime <= endTime;
                });
                break;
            }
            case "coming": {
                founded = founded.filter((item) => {
                    const startTime = new Date(item["task"].start);
                    const currentTime = new Date();
                    return currentTime < startTime;
                });
                break;
            }
            case "expired": {
                founded = founded.filter((item) => {
                    const endTime = new Date(item["task"].end);
                    const currentTime = new Date();
                    return currentTime > endTime;
                });
                break;
            }
            default:
                break;
        }

        if (dateInput) {
            founded = founded.filter((item) => {
                const startTime = new Date(item["task"].start);
                const endTime = new Date(item["task"].end);
                const checkTime = new Date(dateInput);
                return checkTime >= startTime && checkTime <= endTime;
            });
        }

        switch (statusRadio) {
            case "new": {
                founded = founded.filter((item) => {
                    return (
                        item["members"].length > 0 &&
                        item["members"].every((member) => {
                            return member.is_completed == null;
                        })
                    );
                });
                break;
            }
            case "working": {
                founded = founded.filter((item) => {
                    return (
                        item["members"].length > 0 &&
                        item["members"].some((member) => {
                            return member.is_completed == null;
                        }) &&
                        item["members"].some((member) => {
                            return member.is_completed != null;
                        })
                    );
                });
                break;
            }
            case "done": {
                founded = founded.filter((item) => {
                    return (
                        item["members"].length > 0 &&
                        item["members"].every((member) => {
                            return member.is_completed != null;
                        })
                    );
                });
                break;
            }

            default:
                break;
        }
        //end buffer filter
        $(".todo-task").each(function () {
            const explodeID = $(this).attr("id").split("-");
            const taskID = parseInt(explodeID[explodeID.length - 1], 10);
            let isMatchFilter = founded.find((item) => {
                return item["task"].id == taskID;
            });
            if (!isMatchFilter) $(this).remove();
        });
    });
});
