<?php

namespace app\controllers;

use app\models\CharacterModel;
use app\repositories\CharacterRepository;
use app\services\CharacterService;
use app\controllers\Controller;
use OpenApi\Annotations as OA;

class CharacterController extends Controller
{
    private $repository;
    private $service;

    public function __construct()
    {
        $this->repository = new CharacterRepository;
        $this->service = new CharacterService;
    }

    /**
     * @OA\Post(
     *     path="/characters/create",
     *     summary="Create a new character",
     *     tags={"Characters"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Character data for creation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", maxLength=255, example="John Doe"),
     *             @OA\Property(property="description", type="string", example="A brave character from the story."),
     *             @OA\Property(property="placeOfBirth", type="string", maxLength=255, example="Springfield"),
     *             @OA\Property(property="occupation", type="string", maxLength=255, example="Warrior"),
     *             @OA\Property(property="fruit", type="string", maxLength=255, example="Apple")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Character created successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Success in creating a character")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error when creating character.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error creating a character"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     oneOf={
     *                         @OA\Schema(@OA\Property(property="name", type="string", example="Name is a required attribute")),
     *                         @OA\Schema(@OA\Property(property="description", type="string", example="Description is a required attribute"))
     *                     }
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal error creating character.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error creating a character")
     *         )
     *     )
     * )
     */
    public function create($request)
    {
        $response = $this->service->create($request);

        if ($response['code'] == 201) {
            return $this->response($response['code'], ['message' => 'Success in creating a character']);
        } elseif ($response['code'] == 400) {
            return $this->response($response['code'], [
                'message' => 'Error creating a character',
                'errors' => $response['errors']
            ]);
        }

        return $this->response(500, ['message' => 'Error creating a character']);
    }

    /**
     * @OA\Put(
     *     path="/characters/update",
     *     summary="Upgrade a character",
     *     tags={"Characters"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="ID of the character to be updated.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Character data for update",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", maxLength=255, example="John Doe"),
     *             @OA\Property(property="description", type="string", example="A brave character from the story."),
     *             @OA\Property(property="placeOfBirth", type="string", maxLength=255, example="Springfield"),
     *             @OA\Property(property="occupation", type="string", maxLength=255, example="Warrior"),
     *             @OA\Property(property="fruit", type="string", maxLength=255, example="Apple")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Character updated successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Success in upgrading a character")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error when updating character.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error upgrading a character"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     oneOf={
     *                         @OA\Schema(@OA\Property(property="name", type="string", example="Name is a required attribute")),
     *                         @OA\Schema(@OA\Property(property="id", type="string", example="Id is a required attribute"))
     *                     }
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal error while updating character.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error upgrading a character")
     *         )
     *     )
     * )
     */
    public function update($request, $params)
    {
        $response = $this->service->update($request, $params['id']);

        if ($response['code'] == 200) {
            return $this->response($response['code'], ['message' => 'Success in upgrading a character']);
        } elseif ($response['code'] == 400) {
            return $this->response($response['code'], [
                'message' => 'Error upgrading a character',
                'errors' => $response['errors']
            ]);
        }

        return $this->response($response['code'], ['message' => 'Error upgrading a character']);
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
        $response = $this->service->list();

        if ($response['code'] == 200) {
            return $this->response($response['code'], [
                'message' => 'Success in searching all characters',
                'data' => $response['data']
            ]);
        }

        return $this->response($response['code'], [
            'message' => 'Error searching all characters'
        ]);
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
        $response = $this->service->showById($params['id']);

        if ($response['code'] == 200) {
            return $this->response($response['code'], [
                'message' => 'Success searching character by id',
                'data' => $response['data']
            ]);
        } elseif ($response['code'] == 400) {
            return $this->response($response['code'], [
                'message' => 'Error searching character by id',
                'errors' => $response['errors']
            ]);
        }

        return $this->response($response['code'], ['message' => 'Error searching character by id']);
    }

    /**
     * @OA\Delete(
     *     path="/characters/delete",
     *     summary="Delete a character by ID",
     *     tags={"Characters"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="ID of the character to be deleted.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Character deleted successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Success in deleting a character")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error when deleting character.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error deleting a character"),
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
     *         description="Internal error while deleting character.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error in deleting a character")
     *         )
     *     )
     * )
     */
    public function destroy($params)
    {
        $response = $this->service->destroy($params['id']);

        if ($response['code'] == 200) {
            return $this->response($response['code'], [
                'message' => 'Success in deleting a character'
            ]);
        } elseif ($response['code'] == 400) {
            return $this->response($response['code'], [
                'message' => 'Error deleting a character',
                'errors' => $response['errors']
            ]);
        }

        return $this->response($response['code'], [
            'message' => 'Error in deleting a character'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/characters/search",
     *     summary="Search character by name",
     *     tags={"Characters"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         description="Name of the character to be searched for.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Character found successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Success searching character by name"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Character")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error when searching for character.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error searching character by name"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="name", type="string", example="Name is a required attribute")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal error while searching for character.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error searching character by name")
     *         )
     *     )
     * )
     */
    public function searchByName($params)
    {
        if (!isset($params['name']) || $params['name'] === '') {
            return $this->response(400, [
                'message' => 'Error searching character by name',
                'errors' => array(['name' => 'Name is a required attribute'])
            ]);
        }

        $response = $this->repository->searchByName($params['name']);

        if ($response !== false) {
            return $this->response(200, [
                'message' => 'Success searching character by name',
                'data' => $response
            ]);
        } else {
            return $this->response(500, ['message' => 'Error searching character by name']);
        }
    }
}
