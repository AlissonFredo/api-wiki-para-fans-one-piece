<?php

namespace app\models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Character",
 *     type="object",
 *     title="Character",
 *     description="Represents a character.",
 *     @OA\Property(
 *         property="id", 
 *         type="integer", 
 *         example=1, 
 *         description="Unique ID of the character."
 *     ),
 *     @OA\Property(
 *         property="name", 
 *         type="string", 
 *         example="Monkey D. Luffy", 
 *         description="Character name."
 *     ),
 *     @OA\Property(
 *         property="description", 
 *         type="string", 
 *         example="Captain of the Straw Hat Ship.", 
 *         description="Character description."
 *     ),
 *     @OA\Property(
 *         property="placeOfBirth", 
 *         type="string", 
 *         example="Foosha Village", 
 *         description="Character's birthplace."
 *     ),
 *     @OA\Property(
 *         property="occupation", 
 *         type="string", 
 *         example="Pirate", 
 *         description="Character's occupation."
 *     ),
 *     @OA\Property(
 *         property="fruit", 
 *         type="string", 
 *         example="Gomu Gomu no Mi", 
 *         description="Devil fruit that the character ate."
 *     ),
 *     @OA\Property(
 *         property="createdAt", 
 *         type="string", format="date-time", 
 *         example="2024-11-05T12:00:00Z", 
 *         description="Character creation date."
 *     ),
 *     @OA\Property(
 *         property="updatedAt", 
 *         type="string", format="date-time", 
 *         example="2024-11-05T12:00:00Z", 
 *         description="Date the character was last updated."
 *     )
 * )
 */
class CharacterModel
{
    private $id;
    private $name;
    private $description;
    private $placeOfBirth;
    private $occupation;
    private $fruit;
    private $createdAt;
    private $updatedAt;

    private $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (strlen($name) > 0) {
            if (strlen($name) <= 255) {
                $this->name = $name;
            } else {
                array_push($this->errors, ['name' => 'Name can have a maximum of 255 characters']);
            }
        } else {
            array_push($this->errors, ['name' => 'Name is a required attribute']);
        }
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        if (strlen($description) > 0) {
            $this->description = $description;
        } else {
            array_push($this->errors, ['description' => 'Description is a required attribute']);
        }
    }

    public function getPlaceOfBirth()
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth($placeOfBirth)
    {
        if (strlen($placeOfBirth) > 0) {
            if (strlen($placeOfBirth) <= 255) {
                $this->placeOfBirth = $placeOfBirth;
            } else {
                array_push($this->errors, ['placeOfBirth' => 'Place of birth can have a maximum of 255 characters']);
            }
        } else {
            array_push($this->errors, ['placeOfBirth' => 'Place of birth is a required attribute']);
        }
    }

    public function getOccupation()
    {
        return $this->occupation;
    }

    public function setOccupation($occupation)
    {
        if (strlen($occupation) > 0) {
            if (strlen($occupation) <= 255) {
                $this->occupation = $occupation;
            } else {
                array_push($this->errors, ['occupation' => 'Occupation can have a maximum of 255 characters']);
            }
        } else {
            array_push($this->errors, ['occupation' => 'Occupation is a required attribute']);
        }
    }

    public function getFruit()
    {
        return $this->fruit;
    }

    public function setFruit($fruit)
    {
        if (strlen($fruit) <= 255) {
            $this->fruit = $fruit;
        } else {
            array_push($this->errors, ['fruit' => 'Fruit can have a maximum of 255 characters']);
        }
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function existsErrors()
    {
        return count($this->errors) > 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function __toString()
    {
        $fruit = $this->fruit ?? '';

        return "Character {
            id={$this->id},
            nome={$this->name}
            description={$this->description},
            placeOfBirth={$this->placeOfBirth},
            occupation={$this->occupation},
            fruit={$fruit},
            createdAt={$this->createdAt},
            updatedAt={$this->updatedAt},
        }";
    }
}
