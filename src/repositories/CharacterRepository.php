<?php

namespace app\repositories;

use PDOException;
use app\core\Database;
use app\models\CharacterModel;

class CharacterRepository
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create(CharacterModel $character)
    {
        $query = "
            INSERT INTO characters (
                name,
                description,
                place_of_birth,
                occupations,
                fruit
            ) VALUES (
                :name,
                :description,
                :place_of_birth,
                :occupations,
                :fruit
            )
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam("name", $character->getName());
        $stmt->bindParam("description", $character->getDescription());
        $stmt->bindParam("place_of_birth", $character->getPlaceOfBirth());
        $stmt->bindParam("occupations", $character->getOccupation());
        $stmt->bindParam("fruit", $character->getFruit());

        return $stmt->execute();
    }
}
