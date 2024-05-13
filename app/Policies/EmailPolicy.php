<?php

namespace App\Policies;

use App\Models\Email;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmailPolicy
{
    public function delete(User $user, Email $email): bool
    {
        //
        return $email->sender_id == $user->id;
    }
}
