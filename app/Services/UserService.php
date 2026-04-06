<?php

namespace App\Services;

use App\Exceptions\BaseException;
use App\Exceptions\ServiceException;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Gate;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(UserRepository::class);
    }

    public function create(array $attributes)
    {
        try {
            return new UserResource($this->repository->create($attributes));
        } catch (BaseException $exception) {
            throw $exception;
        } catch (\Throwable $th) {
            throw new ServiceException();
        }
    }

    public function update(int $id, array $attributes)
    {
        try {
            $user = $this->repository->find($id);

            Gate::authorize('update', $user);

            return new UserResource($this->repository->update($id, $attributes));
        } catch (BaseException $exception) {
            throw $exception;
        } catch (\Throwable $th) {
            throw new ServiceException();
        }
    }

    public function find(int $id, array $with = [])
    {
        try {
            $user = new User();
            $user->id = $id;

            Gate::authorize('view', $user);

            return new UserResource($this->repository->find($id));
        } catch (BaseException $exception) {
            throw $exception;
        } catch (\Throwable $th) {
            throw new ServiceException();
        }
    }

    public function listUsers(?bool $withAdmin = null)
    {
        try {
            return UserResource::collection($this->repository->listUsers($withAdmin));
        } catch (BaseException $exception) {
            throw $exception;
        } catch (\Throwable $th) {
            throw new ServiceException();
        }

        return [];
    }

    public function delete(int $id)
    {
        try {
            $this->repository->delete($id);

            auth()->logout();
        } catch (BaseException $exception) {
            throw $exception;
        } catch (\Throwable $th) {
            throw new ServiceException();
        }
    }
}
