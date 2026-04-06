<?php

namespace App\Http\Controllers;

use App\Exceptions\BaseException;
use App\Services\UserService;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    private UserService $service;

    public function __construct()
    {
        $this->service = app(UserService::class);
    }

    public function store(CreateRequest $request)
    {
        try {
            return response()->json([
                'message' => 'User successfully registered.',
                'user' => $this->service->create($request->all()),
            ], 200);
        } catch (BaseException $exception) {
            $message = $exception->getMessage();
        } catch (\Throwable $th) {
            $message = self::DEFAULT_CONTROLLER_ERROR;
        }

        return response()->json([
            'message' => __($message),
        ], 401);
    }

    public function show(int $id, Request $request)
    {
        try {
            return response()->json([
                'message' => 'User data',
                'user' => $this->service->find($id),
            ], 200);
        } catch (BaseException $exception) {
            $message = $exception->getMessage();
        } catch (\Throwable $th) {
            $message = self::DEFAULT_CONTROLLER_ERROR;
        }

        return response()->json([
            'message' => __($message),
        ], 401);
    }

    public function list(Request $request)
    {
        try {
            return response()->json([
                'message' => 'User data',
                'users' => $this->service->listUsers(),
            ], 200);
        } catch (BaseException $exception) {
            $message = $exception->getMessage();
        } catch (\Throwable $th) {
            $message = self::DEFAULT_CONTROLLER_ERROR;
        }

        return response()->json([
            'message' => __($message),
        ], 401);
    }

    public function update(UpdateRequest $request)
    {
        return $this->updateUser($request->user()->id, $request);
    }

    public function updateUser(int $id, UpdateRequest $request)
    {
        try {
            return response()->json([
                'message' => 'User successfully updated.',
                'user' => $this->service->update($id, $request->all()),
            ], 200);
        } catch (BaseException $exception) {
            $message = $exception->getMessage();
        } catch (\Throwable $th) {
            $message = self::DEFAULT_CONTROLLER_ERROR;
        }

        return response()->json([
            'message' => __($message),
        ], 401);
    }

    public function destroy(Request $request)
    {
        try {
            $this->service->delete($request->user()->id);

            return response()->json([
                'message' => 'User successfully removed.',
            ], 200);
        } catch (BaseException $exception) {
            $message = $exception->getMessage();
        } catch (\Throwable $th) {
            $message = self::DEFAULT_CONTROLLER_ERROR;
        }

        return response()->json([
            'message' => __($message),
        ], 401);
    }
}
