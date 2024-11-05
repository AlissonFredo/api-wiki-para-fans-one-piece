<?php

namespace app\controllers;

use app\models\CharacterModel;
use app\repositories\CharacterRepository;
use OpenApi\Annotations as OA;

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
            return json_encode([
                'message' => 'Error creating a character',
                'errors' => $character->getErrors()
            ]);
        }

        $response = $this->repository->create($character);

        if ($response) {
            http_response_code(201);
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
            return json_encode([
                'message' => 'Error creating a character',
                'errors' => $character->getErrors()
            ]);
        } elseif (!isset($params['id']) || $params['id'] === '') {
            http_response_code(400);
            return json_encode([
                'message' => 'Error creating a character',
                'errors' => array(['id' => 'Id is a required attribute'])
            ]);
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

    /**
     * @OA\Get(
     *     path="/characters/list",
     *     summary="List all characters",
     *     tags={"Characters"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of all characters.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Success in searching all characters"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Character")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error fetching all characters.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error searching all characters")
     *         )
     *     )
     * )
     */
    public function list()
    {
        $response = $this->repository->list();

        if ($response !== false) {
            http_response_code(200);
            return json_encode([
                'message' => 'Success in searching all characters',
                'data' => $response
            ]);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Error searching all characters']);
        }
    }

    /**
     * @OA\Get(
     *     path="/characters/show",
     *     summary="Search character by ID",
     *     tags={"Characters"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="ID of the character to be searched.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Character found successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Success searching character by id"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Character"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error when searching for character.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error searching character by id"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="Id is a required attribute")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal error while searching for character.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error searching character by id")
     *         )
     *     )
     * )
     */
    public function showById($params)
    {
        if (!isset($params['id']) || $params['id'] === '') {
            http_response_code(400);
            return json_encode([
                'message' => 'Error searching character by id',
                'errors' => array(['id' => 'Id is a required attribute'])
            ]);
        }

        $response = $this->repository->show($params['id']);

        if ($response !== false) {
            http_response_code(200);
            return json_encode([
                'message' => 'Success searching character by id',
                'data' => $response
            ]);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Error searching character by id']);
        }
    }

    public function destroy($params)
    {
        if (!isset($params['id']) || $params['id'] === '') {
            http_response_code(400);
            return json_encode([
                'message' => 'Error deleting a character',
                'errors' => array(['id' => 'Id is a required attribute'])
            ]);
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
            return json_encode([
                'message' => 'Error searching character by name',
                'errors' => array(['name' => 'Name is a required attribute'])
            ]);
        }

        $response = $this->repository->searchByName($params['name']);

        if ($response !== false) {
            http_response_code(200);
            return json_encode([
                'message' => 'Success searching character by name',
                'data' => $response
            ]);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Error searching character by name']);
        }
    }
}
