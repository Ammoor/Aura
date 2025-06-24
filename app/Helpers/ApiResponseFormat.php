<?php

namespace App\Helpers;

class ApiResponseFormat
{
    public static function successResponse($responseCode, $responseMessage, $responseData = '')
    {
        $response = [
            'statusCode' => $responseCode,
            'message' => $responseMessage,
            'clientData' => $responseData,
        ];
        return response()->json($response, $responseCode);
    }
    public static function failedResponse($responseCode, $responseMessage, $responseErrors = '')
    {
        $response = [
            'statusCode' => $responseCode,
            'message' => $responseMessage,
            'errors' => $responseErrors,
        ];
        return response()->json($response, $responseCode);
    }
}
