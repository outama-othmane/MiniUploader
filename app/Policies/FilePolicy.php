<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can download the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\File  $file
     * @return mixed
     */
    public function download(User $user, File $file)
    {
        return $user->currentTeam->id === $file->team_id;
    }
}
