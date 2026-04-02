<?php

namespace App\Repositories;

use App\Enums\Status;
use App\Exceptions\RepositoryException;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Project::class);
    }

    public function findFromUser(int $id, ?int $user_id = null, array $with = [])
    {
        try {
            return $this->model
                ->with($with)
                ->where('id', $id)
                ->when($user_id, function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                })
                ->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new RepositoryException('The reported record was not found.', $exception->getCode(), $exception);
        } catch (\Throwable $th) {
            throw new RepositoryException();
        }
    }

    public function listProjects(?int $user_id = null, ?Status $status = null)
    {
        try {
            return $this->model
                ->when($user_id, function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                })
                ->when($status, function ($query) use ($status) {
                    $query->where('status', $status->value);
                })
                ->get();
        } catch (\Throwable $th) {
            throw new RepositoryException();
        }
    }
}
