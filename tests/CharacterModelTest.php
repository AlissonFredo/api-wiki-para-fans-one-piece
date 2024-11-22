<?php

namespace tests;

use app\models\CharacterModel;
use PHPUnit\Framework\TestCase;

class CharacterModelTest extends TestCase
{
    public function testCharacterId()
    {
        $character = new CharacterModel();
        $character->setId(1);
        $this->assertEquals(1, $character->getId());
    }

    public function testCharacterName()
    {
        $character = new CharacterModel();
        $character->setName('Luffy');
        $this->assertEquals('Luffy', $character->getName());
    }

    public function testCharacterNameMaximumCharacters()
    {
        $character = new CharacterModel();
        $longName = str_repeat('Luffy', 60);
        $character->setName($longName);
        $error = current(array_filter(
            $character->getErrors(),
            fn($error) => isset($error['name'])
        ));
        $this->assertEquals(
            'Name can have a maximum of 255 characters',
            $error['name']
        );
    }

    public function testCharacterNameRequired()
    {
        $character = new CharacterModel();
        $character->setName('');
        $error = current(array_filter(
            $character->getErrors(),
            fn($error) => isset($error['name'])
        ));
        $this->assertEquals(
            'Name is a required attribute',
            $error['name']
        );
    }

    public function testCharacterDescription()
    {
        $character = new CharacterModel();
        $character->setDescription('É o capitão dos Chapeus de Palha');
        $this->assertEquals(
            'É o capitão dos Chapeus de Palha',
            $character->getDescription()
        );
    }

    public function testCharacterDescriptionRequired()
    {
        $character = new CharacterModel();
        $character->setDescription('');
        $error = current(array_filter(
            $character->getErrors(),
            fn($error) => isset($error['description'])
        ));
        $this->assertEquals(
            'Description is a required attribute',
            $error['description']
        );
    }

    public function testCharacterPlaceOfBirth()
    {
        $character = new CharacterModel();
        $character->setPlaceOfBirth('Aldeia Foosha');
        $this->assertEquals(
            'Aldeia Foosha',
            $character->getPlaceOfBirth()
        );
    }

    public function testCharacterPlaceOfBirthMaximumCharacters()
    {
        $character = new CharacterModel();
        $longName = str_repeat('Aldeia Foosha', 60);
        $character->setPlaceOfBirth($longName);
        $error = current(array_filter(
            $character->getErrors(),
            fn($error) => isset($error['placeOfBirth'])
        ));
        $this->assertEquals(
            'Place of birth can have a maximum of 255 characters',
            $error['placeOfBirth']
        );
    }

    public function testCharacterPlaceOfBirthRequired()
    {
        $character = new CharacterModel();
        $character->setPlaceOfBirth('');
        $error = current(array_filter(
            $character->getErrors(),
            fn($error) => isset($error['placeOfBirth'])
        ));
        $this->assertEquals(
            'Place of birth is a required attribute',
            $error['placeOfBirth']
        );
    }

    public function testCharacterOccupation()
    {
        $character = new CharacterModel();
        $character->setOccupation('Capitão');
        $this->assertEquals(
            'Capitão',
            $character->getOccupation()
        );
    }

    public function testCharacterOccupationMaximumCharacters()
    {
        $character = new CharacterModel();
        $longName = str_repeat('Capitão', 60);
        $character->setOccupation($longName);
        $error = current(array_filter(
            $character->getErrors(),
            fn($error) => isset($error['occupation'])
        ));
        $this->assertEquals(
            'Occupation can have a maximum of 255 characters',
            $error['occupation']
        );
    }

    public function testCharacterOccupationRequired()
    {
        $character = new CharacterModel();
        $character->setOccupation('');
        $error = current(array_filter(
            $character->getErrors(),
            fn($error) => isset($error['occupation'])
        ));
        $this->assertEquals(
            'Occupation is a required attribute',
            $error['occupation']
        );
    }

    public function testCharacterFruit()
    {
        $character = new CharacterModel();
        $character->setFruit('Gomu Gomu ni Mi');
        $this->assertEquals(
            'Gomu Gomu ni Mi',
            $character->getFruit()
        );
    }

    public function testCharacterFruitMaximumCharacters()
    {
        $character = new CharacterModel();
        $longName = str_repeat('Gomu Gomu ni Mi', 60);
        $character->setFruit($longName);
        $error = current(array_filter(
            $character->getErrors(),
            fn($error) => isset($error['fruit'])
        ));
        $this->assertEquals(
            'Fruit can have a maximum of 255 characters',
            $error['fruit']
        );
    }

    public function testCharacterNotExistsErrors()
    {
        $character = new CharacterModel();
        $character->setName('Luffy');
        $character->setDescription('É o capitão dos Chapeus de Palha');
        $character->setPlaceOfBirth('Aldeia Foosha');
        $character->setOccupation('Capitão');
        $character->setFruit('Gomu Gomu ni Mi');
        $this->assertFalse($character->existsErrors());
    }

    public function testCharacterExistsErrors()
    {
        $character = new CharacterModel();
        $character->setName('');
        $character->setDescription('É o capitão dos Chapeus de Palha');
        $character->setPlaceOfBirth('Aldeia Foosha');
        $character->setOccupation('');
        $character->setFruit('Gomu Gomu ni Mi');
        $this->assertTrue($character->existsErrors());
    }
}
