<?php

namespace App\Services;

use App\Enums\Role;
use App\Enums\Status;
use App\Exceptions\BaseException;
use App\Exceptions\ServiceException;
use App\Repositories\ProjectRepository;
use Illuminate\Support\Facades\Gate;

class ProjectService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(ProjectRepository::class);
    }

    public function findFromUser(int $id)
    {
        try {
            $user = auth()->user();
            $user_id = $user->role != Role::Admin->value 
                ? $user->id 
                : null;

            return $this->repository->findFromUser($id, $user_id);
        } catch (BaseException $exception) {
            throw $exception;
        } catch (\Throwable $th) {
            throw new ServiceException();
        }

        return [];
    }

    public function listProjects(?Status $status = null, ?int $user_id = null)
    {
        try {
            $user = auth()->user();
            $user_id = $user->role != Role::Admin->value 
                ? $user->id 
                : $user_id;

            return $this->repository->listProjects($user_id, $status);
        } catch (BaseException $exception) {
            throw $exception;
        } catch (\Throwable $th) {
            throw new ServiceException();
        }

        return [];
    }

    public function update(int $id, array $input)
    {
        try {
            $project = $this->repository->find($id);

            Gate::authorize('update', [$project, $input]);

            return $this->repository->update($id, $input);
        } catch (BaseException $exception) {
            throw $exception;
        } catch (\Throwable $th) {
            throw new ServiceException();
        }
    }
}
