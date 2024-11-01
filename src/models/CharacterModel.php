<?php

namespace app\models;

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
