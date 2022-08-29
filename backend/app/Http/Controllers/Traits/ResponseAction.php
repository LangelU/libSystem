<?php

namespace App\Http\Controllers\Traits;

trait ResponseAction
{
    public function response($status, $message = '', $data = [], $code)
    {
        return [
            'status' => $status, //response status
            'message' => $message, //response data
            'data' => $data, //bug for developer
            'code' => $code //user message
        ];
    }
}