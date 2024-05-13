<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\TaskMember;
use App\Models\User;

class TaskPolicy
{
    public function operate(User $user, Task $task): bool
    {
        $isMember = TaskMember::where('member_id', $user->id)
            ->where('task_id', $task->id)
            ->first();

        return is_null($isMember) ? false : true;
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        //
        return $user->id == $task->creator_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        //
        return $user->id == $task->creator_id;
    }
}
