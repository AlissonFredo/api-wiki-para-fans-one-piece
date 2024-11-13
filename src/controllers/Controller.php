<?php

namespace app\controllers;

class Controller
{
    protected function response($code, $data)
    {
        http_response_code($code);
        return json_encode($data);
    }
}
