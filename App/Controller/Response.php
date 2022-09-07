<?php

namespace App\Controller;

class Response {

    public static function error(string $msg, array $data = []): void
    {
        echo json_encode(array_merge($data, ['status' => false, 'message' => $msg]));
        exit();
    }

    public static function success(string $msg, array $data = []): void
    {
        echo json_encode(array_merge($data, ['status' => true, 'message' => $msg]));
        exit();
    }

}