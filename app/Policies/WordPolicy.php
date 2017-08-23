<?php

namespace App\Policies;

use App\User;
use App\Word;
use Illuminate\Auth\Access\HandlesAuthorization;

class WordPolicy
{
    use HandlesAuthorization;

    public function handle(User $user, Word $word)
    {
        return $word->user_id == $user->id;
    }
}
