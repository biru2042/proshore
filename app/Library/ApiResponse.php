<?php 

namespace App\Library;

use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Exceptions\HttpResponseException;


class ApiResponse
{
    public static function sendResponse($error = false, $message = "",$data=[],$code)
    {
        return response()->json([
            'error'=>$error,
            'message'=>$message,
            'data'=>$data
        ],$code);

    }

    public static function sendFormRequestValidationErrorResponse($errors)
    {
        throw new HttpResponseException(response()->json([
            'error'=>true,
            'message'=>'validation error',
            'data'=>$errors
        ], 422));
    }

    public static function sendUnauthenticatedResponse()
    {
        return response()->json([
            'error'=>true,
            'message'=>'Unauthenticated',
            'data'=>[]
        ],401);
    }

}