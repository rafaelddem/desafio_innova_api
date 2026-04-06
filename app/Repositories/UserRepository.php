<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Exceptions\RepositoryException;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    public function listUsers(?bool $withAdmin = null)
    {
        try {
            return $this->model
                ->with('hero')
                ->when(!$withAdmin, function ($query) {
                    $query->where('role', Role::User);
                })
                ->get();
        } catch (\Throwable $th) {
            throw new RepositoryException();
        }
    }
}
