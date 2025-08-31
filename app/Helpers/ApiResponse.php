<?php

namespace App\Helpers;

class ApiResponse
{
    public static function successResponse($message = "Success", $data = null, $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'records' => $data,
            'statusCode' => $status
        ], $status);
    }

    public static function failedResponse($message = "Failed", $errors = null, $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'statusCode' => $status
        ], $status);
    }

public static function paginatedData($paginator)
{
    return [
        'pagination' => [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'last_page' => $paginator->lastPage(),
            'next_page_url' => $paginator->nextPageUrl(),
            'prev_page_url' => $paginator->previousPageUrl(),
            'pages' => range(1, $paginator->lastPage()) // optional: frontend segment
        ],
        'data' => $paginator->items() // only the records
    ];
}

public function commonResponse($type="success", $message = "Success", $status = 200)
{
    if($type=="error"||$type=="failed"){
   return response()->json([
        'success' => false,
        'message' => $message,
        'statusCode' => $status
    ], $status);
    }
    else{
   return response()->json([
        'success' => true,
        'message' => $message,
        'statusCode' => $status
    ], $status);    }
 
}
}