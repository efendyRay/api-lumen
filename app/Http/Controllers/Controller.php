<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function return_success($message, $data = [], $code = 200)
    {
        return [
            "code" => $code,
            "message" => $message,
            "data" => $data,
        ];
    }

    public function return_badrequest($message, $data = [], $code = 400)
    {
        return [
            "code" => $code,
            "message" => $message,
            "data" => $data,
        ];
    }

    public function return_mismatch($message, $data = [], $code = 422)
    {
        return [
            "code" => $code,
            "message" => $message,
            "data" => $data,
        ];
    }

    public function return_not_found()
    {
        return [
            "code" => 404,
            "message" => 'Data Not Found',
        ];
    }

    public function return_server_error($message, $data = [], $code = 500)
    {
        return [
            "code" => $code,
            "message" => $message,
            "data" => $data,
        ];
    }
}
