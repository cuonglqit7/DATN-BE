<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait SendResponse
{
    /**
     * Success Response
     */
    public function successResponse($data = [], $message = 'Success'): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], Response::HTTP_OK);
    }

    /**
     * Error Response
     */
    public function errorResponse($message = 'Error', $errors = []): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'errors'  => $errors,
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Validation Error Response
     */
    public function validationErrorResponse($errors, $message = 'Validation Error'): JsonResponse
    {
        return response()->json([
            'status'  => 'fail',
            'message' => $message,
            'errors'  => $errors,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
