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
            $user = $this->service->create($request->all());

            return response()->json([
                'message' => 'Hero successfully registered.',
                'user' => $user,
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

    public function show(Request $request)
    {
        try {
            $user = $request->user();

            return response()->json([
                'message' => 'Hero data',
                'user' => $user,
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
        try {
            $user = $this->service->update($request->user()->id, $request->all());

            return response()->json([
                'message' => 'Hero successfully updated.',
                'user' => $user,
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
                'message' => 'Hero successfully removed.',
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
