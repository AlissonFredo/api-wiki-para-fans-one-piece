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
            return json_encode(['message' => 'Success in creating a character']);
        } else {
            http_response_code(400);
            return json_encode(['message' => 'Error creating a character']);
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

        $response = $this->repository->update($character, $params['id']);

        if ($response) {
            http_response_code(200);
            return json_encode(['message' => 'Success in upgrading a character']);
        } else {
            http_response_code(400);
            return json_encode(['message' => 'Error upgrading a character']);
        }
    }

    public function list()
    {
        $response = $this->repository->list();

        http_response_code(200);
        return json_encode(['message' => 'Success in searching all characters', 'data' => $response]);
    }

    public function showById($params)
    {
        $response = $this->repository->show($params['id']);

        if ($response) {
            http_response_code(200);
            return json_encode(['message' => 'Success searching character by id', 'data' => $response]);
        } else {
            return json_encode(['message' => 'Error searching character by id']);
        }
    }

    public function destroy($params)
    {
        $response = $this->repository->destroy($params['id']);

        if ($response) {
            http_response_code(200);
            return json_encode(['message' => 'Success in deleting a character']);
        } else {
            http_response_code(400);
            return json_encode(['message' => 'Error in deleting a character']);
        }
    }

    public function searchByName($params)
    {
        return json_encode(['message' => 'searchByName']);
    }
}
