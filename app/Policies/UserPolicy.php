<?php

namespace App\Policies;

use App\Enums\Role;
use App\Exceptions\BaseException;
use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->role == Role::Admin->value) 
            return true;

        if ($model->id != $user->id) 
            throw new BaseException('You do not have permission to access this resource.');

        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->role == Role::Admin->value) 
            return true;

        if ($model->id != $user->id) 
            throw new BaseException('You do not have permission to access this resource.');

        return true;
    }
}
