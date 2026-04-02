<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Enums\Status;
use App\Exceptions\BaseException;
use App\Http\Requests\Project\CreateRequest;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends BaseController
{
    private ProjectService $service;

    public function __construct()
    {
        $this->service = app(ProjectService::class);
    }

    public function store(CreateRequest $request)
    {
        try {
            return response()->json([
                'message' => 'Project successfully registered.',
                'project' => $this->service->create($request->all()),
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

    public function show(int $id)
    {
        try {
            return response()->json([
                'message' => 'Project data.',
                'project' => $this->service->findFromUser($id),
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
                'message' => 'List of projects',
                'projects' => $this->service->listProjects(
                    Status::fromValue($request->get('status')), 
                    $request->get('user_id')
                ),
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

    public function update(int $id, Request $request)
    {
        try {
            return response()->json([
                'message' => 'Project successfully updated.',
                'project' => $this->service->update($id, $request->all()),
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

    public function destroy(int $id)
    {
        try {
            $this->service->delete($id);

            return response()->json([
                'message' => 'Project successfully removed.',
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
