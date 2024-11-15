<?php

namespace app\services;

use app\models\CharacterModel;
use app\repositories\CharacterRepository;

class CharacterService
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
            return ['code' => 400, 'errors' => $character->getErrors()];
        }

        $response = $this->repository->create($character);

        if ($response) {
            return ['code' => 201];
        }

        return ['code' => 500];
    }

    public function update($request, $characterId)
    {
        $character = new CharacterModel();

        $character->setName($request['name']);
        $character->setDescription($request['description']);
        $character->setPlaceOfBirth($request['placeOfBirth']);
        $character->setOccupation($request['occupation']);
        $character->setFruit($request['fruit']);

        if ($character->existsErrors()) {
            return ['code' => 400, 'errors' => $character->getErrors()];
        } elseif (!isset($characterId) || $characterId === '') {
            return ['code' => 400, 'errors' => array(['id' => 'Id is a required attribute'])];
        }

        $response = $this->repository->update($character, $characterId);

        if ($response) {
            return ['code' => 200];
        }

        return ['code' => 500];
    }

    public function list()
    {
        $response = $this->repository->list();

        if ($response) {
            return ['code' => 200, 'data' => $response];
        }

        return ['code' => 500];
    }

    public function showById($id)
    {
        if (!isset($id) || $id === '') {
            return ['code' => 400, 'errors' => array(['id' => 'Id is a required attribute'])];
        }

        $response = $this->repository->show($id);

        if ($response) {
            return ['code' => 200, 'data' => $response];
        }

        return ['code' => 500];
    }

    public function destroy($id)
    {
        if (!isset($id) || $id === '') {
            return [
                'code' => 400,
                'errors' => array(['id' => 'Id is a required attribute'])
            ];
        }

        $response = $this->repository->destroy($id);

        if ($response) {
            return ['code' => 200, 'data' => $response];
        }

        return ['code' => 500];
    }

    public function searchByName($name)
    {
        if (!isset($name) || $name === '') {
            return [
                'code' => 400,
                'errors' => array(['name' => 'Name is a required attribute'])
            ];
        }

        $response = $this->repository->searchByName($name);

        if ($response) {
            return ['code' => 200, 'data' => $response];
        }

        return ['code' => 500];
    }
}
