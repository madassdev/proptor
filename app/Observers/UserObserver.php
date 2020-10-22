<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        $split_names = User::resolveFirstAndLastName($user->full_name);
        $user->first_name = $split_names['first_name'];
        $user->last_name = $split_names['last_name'];
        // dd($user);
    }

    public function updating(User $user)
    {
        $split_names = User::resolveFirstAndLastName($user->full_name);
        $user->first_name = $split_names['first_name'];
        $user->last_name = $split_names['last_name'];
    }

}
