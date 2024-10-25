<?php

namespace app\controllers;

use app\models\CharacterModel;
use app\repositories\CharacterRepository;

class CharacterController
{
    private $repository;

    public function __construct()
    {
        $this->repository = new CharacterRepository;
    }
    public function create($request)
    {
        $character = new CharacterModel();

        $character->setName($request['name']);
        $character->setDescription($request['description']);
        $character->setPlaceOfBirth($request['placeOfBirth']);
        $character->setOccupation($request['occupation']);
        $character->setFruit($request['fruit']);

        $response = $this->repository->create($character);

        if ($response) {
            http_response_code(201);
            return json_encode(['message' => 'success in creating a character']);
        } else {
            http_response_code(400);
            return json_encode(['message' => 'error creating a character']);
        }
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
        $response = $this->repository->list();

        http_response_code(200);
        return json_encode(['message' => 'Success in searching all characters', 'data' => $response]);
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
