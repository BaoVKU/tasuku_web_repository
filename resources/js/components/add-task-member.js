export const addTaskMemberHTML = function (user, id = null) {
    return `<li value="${id}" class="add-task-member-item mx-1">
    <input type="text" name="members[]" value="${user.id}" hidden>
    <button class="inline-block min-w-max text-sm py-1 px-2 bg-slate-200 text-slate-700 font-semibold rounded-lg">
        ${user.name}
    </button>
</li>`;
};
