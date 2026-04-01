<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    public function logIn(Request $request)
    {
        try {
            $token = auth('api')->attempt([
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ]);

            if (!$token) 
                throw new Exception(__('Invalid Data.'));

            return response()->json([
                'message' => 'Login successful.',
                'token' => $token,
            ], 200);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
        } catch (\Throwable $th) {
            $message = self::DEFAULT_CONTROLLER_ERROR;
        }

        return response()->json([
            'message' => __($message),
        ], 401);
    }

    public function logOut(Request $request)
    {
        auth()->logout();

        return response()->json([
            'message' => 'Logout successful.',
        ], 200);
    }
}
