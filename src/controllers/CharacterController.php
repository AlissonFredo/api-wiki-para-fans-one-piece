<?php

namespace app\controllers;

use app\models\CharacterModel;

class CharacterController
{
    public function create($request)
    {
        $character = new CharacterModel();

        $character->setName($request['name']);
        $character->setDescription($request['description']);
        $character->setPlaceOfBirth($request['placeOfBirth']);
        $character->setOccupation($request['occupation']);
        $character->setFruit($request['fruit']);

        return json_encode(['message' => 'create', 'data' => $character]);
    }

    public function update($request, $params)
    {
        $character = new CharacterModel();

        $character->setName($request['name']);
        $character->setDescription($request['description']);
        $character->setPlaceOfBirth($request['placeOfBirth']);
        $character->setOccupation($request['occupation']);
        $character->setFruit($request['fruit']);

        return json_encode(['message' => 'update', 'data' => $character]);
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
