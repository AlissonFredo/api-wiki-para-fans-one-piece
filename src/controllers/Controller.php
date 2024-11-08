<?php

class Controller
{
    protected function response($code, $data)
    {
        http_response_code(201);
        return json_encode(['message' => 'Success in creating a character']);
    }
}
