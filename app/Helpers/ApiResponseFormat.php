<?php

namespace App\Helpers;

class ApiResponseFormat
{
    public static function successResponse($responseCode, $responseMessage, $responseData = '', $responseMeta = [])
    {
        $response = [
            'statusCode' => $responseCode,
            'message' => $responseMessage,
            'data' => $responseData,
            'metaData' => $responseMeta
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
