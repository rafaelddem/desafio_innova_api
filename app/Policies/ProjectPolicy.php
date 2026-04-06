<?php

namespace App\Policies;

use App\Enums\Role;
use App\Exceptions\BaseException;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    // /**
    //  * Determine whether the user can view any models.
    //  */
    // public function viewAny(User $user): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(User $user, Project $project): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project, array $input = [])
    {
        if ($user->role == Role::Admin->value) 
            return true;

        if ($project->user_id != $user->id) 
            throw new BaseException('You do not have permission to access this resource.');

        $allowUpdateFieldsByUsers = [
            'goals',
            'status',
        ];

        if (!empty(array_diff(array_keys($input), $allowUpdateFieldsByUsers))) 
            throw new BaseException('You only have permission to update goals and status.');

        return true;
    }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete(User $user, Project $project): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(User $user, Project $project): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Project $project): bool
    // {
    //     //
    // }
}
