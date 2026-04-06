<?php

namespace App\Services;

use App\Exceptions\BaseException;
use App\Exceptions\ServiceException;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

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
        } catch (\Throwable $th) {
            throw new ServiceException();
        }
    }

    public function update(int $id, array $attributes)
    {
        try {
            return new UserResource($this->repository->update($id, $attributes));
        } catch (\Throwable $th) {
            throw new ServiceException();
        }
    }

    public function show(int $id)
    {
        try {
            return new UserResource($this->repository->find($id));
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
