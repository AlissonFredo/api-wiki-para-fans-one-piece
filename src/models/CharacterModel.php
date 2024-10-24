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
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPlaceOfBirth()
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth($placeOfBirth)
    {
        $this->placeOfBirth = $placeOfBirth;
    }

    public function getOccupation()
    {
        return $this->occupation;
    }

    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
    }

    public function getFruit()
    {
        return $this->fruit;
    }

    public function setFruit($fruit)
    {
        $this->fruit = $fruit;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
