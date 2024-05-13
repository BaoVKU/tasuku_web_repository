<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GroupPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Group $group): bool
    {
        $isMember = GroupMember::where('group_id', $group->id)
            ->where('member_id', $user->id)
            ->first();
        return is_null($isMember) ? false : true;
    }

    public function edit(User $user, Group $group): bool
    {
        return $group->creator_id == $user->id;
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Group $group): bool
    {
        return $group->creator_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Group $group): bool
    {
        return $group->creator_id == $user->id;
    }

}
