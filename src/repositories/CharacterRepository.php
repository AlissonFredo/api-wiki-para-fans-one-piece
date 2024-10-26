<?php

namespace app\repositories;

use PDO;
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

    public function list()
    {
        $query = "SELECT * FROM characters";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function show($id)
    {
        $query = "SELECT * FROM characters WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function destroy($id)
    {
        $query = "DELETE FROM characters WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
