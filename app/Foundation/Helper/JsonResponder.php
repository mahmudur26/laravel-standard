<?php

namespace App\Foundation\Helper;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class JsonResponder
{
    public static function respond(string $message, string|int $status = 200, array $data = [], array $errors = []): JsonResponse
    {
        $responseData = [
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
        ];

        if($status == 0){
            $status = 200;
        }
        return response()->json($responseData, $status, [], JSON_PRESERVE_ZERO_FRACTION);
    }

    public static function errorRespond($message, array|string $errors, int $statusCode): JsonResponse
    {
        return self::respond(message: $message, status: $statusCode, errors: $errors);
    }

    public static function success($message = 'Success', $data = []): JsonResponse
    {
        return self::respond($message, 200, $data);
    }

    public static function unauthorized($message = 'Unauthorized'): JsonResponse
    {
        return self::respond($message, 401);
    }

    public static function validationError(string $message, array $errors, int $statusCode = 422): JsonResponse
    {
        return self::errorRespond(message: $message, errors: $errors, statusCode: $statusCode);
    }

    public static function internalServerError($message = 'Internal Server Error', $data = []): JsonResponse
    {
        return self::respond($message, 500, $data);
    }

    public static function notFound($message = 'Not Found'): JsonResponse
    {
        return self::respond($message, 404);
    }

    public static function methodNotAllowed($message = 'The current method not allow for this route'): JsonResponse
    {
        return self::respond($message, 405);
    }

    public static function noContent($message = 'No Content'): JsonResponse
    {
        return self::respond($message, 204);
    }

    public static function errorResponse($message = 'Error', array $errors = [], array $data = [], int $statusCode = 500): JsonResponse
    {
        $errorData = [];
        foreach ($errors as $index => $error) {
            $errorData[$index]['name'] = $index;
            $errorData[$index]['message'] = $error[0] ?? $error;
        }

        return self::respond(message: $message, status: $statusCode, data: $data, errors: collect($errorData)->values()->toArray());
    }

    public static function successResponse($message = 'Success', array $errors = [], array $data = [], int $statusCode = 200): JsonResponse
    {
        $errorData = [];
        if ($errors) {
            foreach ($errors as $index => $error) {
                $errorData[$index]['name'] = $index;
                $errorData[$index]['message'] = $error[0] ?? $error;
            }
        }

        return self::respond(message: $message, status: $statusCode, data: $data, errors: collect($errorData)->values()->toArray());
    }
}
