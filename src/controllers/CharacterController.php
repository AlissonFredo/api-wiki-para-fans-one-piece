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

        if ($character->existsErrors()) {
            http_response_code(400);
            return json_encode(['message' => 'Error creating a character', 'errors' => $character->getErrors()]);
        }

        $response = $this->repository->create($character);

        if ($response) {
            http_response_code(200);
            return json_encode(['message' => 'Success in creating a character']);
        } else {
            http_response_code(500);
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

        if ($character->existsErrors()) {
            http_response_code(400);
            return json_encode(['message' => 'Error creating a character', 'errors' => $character->getErrors()]);
        } elseif (!isset($params['id']) || $params['id'] === '') {
            http_response_code(400);
            return json_encode(['message' => 'Error creating a character', 'errors' => array(['id' => 'Id is a required attribute'])]);
        }

        $response = $this->repository->update($character, $params['id']);

        if ($response) {
            http_response_code(200);
            return json_encode(['message' => 'Success in upgrading a character']);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Error upgrading a character']);
        }
    }

    public function list()
    {
        $response = $this->repository->list();

        if ($response !== false) {
            http_response_code(200);
            return json_encode(['message' => 'Success in searching all characters', 'data' => $response]);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Error searching all characters']);
        }
    }

    public function showById($params)
    {
        if (!isset($params['id']) || $params['id'] === '') {
            http_response_code(400);
            return json_encode(['message' => 'Error searching character by id', 'errors' => array(['id' => 'Id is a required attribute'])]);
        }

        $response = $this->repository->show($params['id']);

        if ($response !== false) {
            http_response_code(200);
            return json_encode(['message' => 'Success searching character by id', 'data' => $response]);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Error searching character by id']);
        }
    }

    public function destroy($params)
    {
        if (!isset($params['id']) || $params['id'] === '') {
            http_response_code(400);
            return json_encode(['message' => 'Error deleting a character', 'errors' => array(['id' => 'Id is a required attribute'])]);
        }

        $response = $this->repository->destroy($params['id']);

        if ($response) {
            http_response_code(200);
            return json_encode(['message' => 'Success in deleting a character']);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Error in deleting a character']);
        }
    }

    public function searchByName($params)
    {
        if (!isset($params['name']) || $params['name'] === '') {
            http_response_code(400);
            return json_encode(['message' => 'Error searching character by name', 'errors' => array(['name' => 'Name is a required attribute'])]);
        }

        $response = $this->repository->searchByName($params['name']);

        if ($response !== false) {
            http_response_code(200);
            return json_encode(['message' => 'Success searching character by name', 'data' => $response]);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Error searching character by name']);
        }
    }
}
