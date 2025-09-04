<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

/**
 * Handles the deletion of a user account.
 *
 * This class implements the `DeletesUsers` contract from Jetstream.
 * It is responsible for deleting the user's profile photo, API tokens,
 * and the user record itself.
 */
class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function delete(User $user): void
    {
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
    }
}
