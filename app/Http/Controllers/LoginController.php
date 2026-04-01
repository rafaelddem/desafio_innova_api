<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class LoginController extends Controller
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
                'message' => 'Operação concluída com sucesso',
                'token' => $token,
            ], 200);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
        } catch (\Throwable $th) {
            $message = 'Invalid Data.';
        }

        return response()->json([
            'message' => __($message),
        ], 401);
    }

    public function user(Request $request)
    {
        try {
            return response()->json([
                'message' => 'Operação concluída com sucesso',
            ], 200);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
        } catch (\Throwable $th) {
            $message = 'Invalid Data.';
        }

        return response()->json([
            'message' => __($message),
        ], 401);
    }

    public function admin(Request $request)
    {
        try {
            return response()->json([
                'message' => 'Operação concluída com sucesso',
            ], 200);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
        } catch (\Throwable $th) {
            $message = 'Invalid Data.';
        }

        return response()->json([
            'message' => __($message),
        ], 401);
    }
}
