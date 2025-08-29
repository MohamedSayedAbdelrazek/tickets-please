<?php

namespace App\Traits;

trait ApiResponses
{
    //
    
     protected function successResponse($data = null, string $message = "Success", int $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

     // simple
    protected function ok ($data , $message ,$code) {
        return $this->successResponse($data , $message ,$code);
    }

    protected function errorResponse(string $message = "Error", $errors = [], int $code = 400)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    protected function paginatedResponse($data, string $message = "Success")
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data->items(),
            'meta' => [
                'current_page' => $data->currentPage(),
                'per_page'     => $data->perPage(),
                'total'        => $data->total(),
                'last_page'    => $data->lastPage(),
            ]
        ]);
    }
}
