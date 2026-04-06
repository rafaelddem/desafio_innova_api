<?php

namespace App\Services;

use App\Exceptions\BaseException;
use App\Exceptions\ServiceException;
use App\Repositories\UserRepository;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(UserRepository::class);
    }

    public function listUsers(?bool $withAdmin = null)
    {
        try {
            return $this->repository->listUsers($withAdmin);
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
