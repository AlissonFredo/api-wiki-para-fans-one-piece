<?php

namespace app\controllers;

class Controller
{
    protected function response($code, $data, $header = "application/json")
    {
        header("Content-Type: $header");

        if ($header == "text/html") {
            return $data;
        } elseif ($header == "text/plain" || $header == "text/css" || $header == "application/javascript" || $header == "image/png") {
            readfile($data);
        }

        http_response_code($code);
        return json_encode($data);
    }
}
