<?php

namespace app\controllers;

class PersonageController
{
    public function create($request)
    {
        return json_encode(['message' => 'create']);
    }

    public function update($request, $params)
    {
        return json_encode(['message' => 'update']);
    }

    public function list()
    {
        return json_encode(['message' => 'list']);
    }

    public function showById()
    {
        return json_encode(['message' => 'showById']);
    }

    public function destroy($params)
    {
        return json_encode(['message' => 'destroy']);
    }

    public function searchByName($params)
    {
        return json_encode(['message' => 'searchByName']);
    }
}
