<?php

namespace App\Http\Controllers;

use App\Exceptions\BaseException;
use App\Services\HeroService;
use Illuminate\Http\Request;

class HeroController extends BaseController
{
    private HeroService $service;

    public function __construct()
    {
        $this->service = app(HeroService::class);
    }

    public function list(Request $request)
    {
        try {
            return response()->json([
                'message' => 'User data',
                'users' => $this->service->list(),
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
