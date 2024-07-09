<?php

namespace App\Repository;

use App\Entity\Medicament;
use App\Db\Mysql;

class MedicamentRepository extends Repository
{

    public function findOneById(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM medicament WHERE id = :id");
        $query->bindParam(':id', $id, $this->pdo::PARAM_STR);
        $query->execute();
        $medicamentData = $query->fetch($this->pdo::FETCH_ASSOC);
        if ($medicamentData) {
            return Medicament::createAndHydrate($medicamentData);;
        } else {
            return false;
        }
    }

    public function create(Medicament $medicament): void
    {
        if ($medicament->getId() === null) {
            $query = $this->pdo->prepare(
                "INSERT INTO medicament (nom, description) VALUES (:nom, :description)"
            );
            $nom = $medicament->getNom();
            $description = $medicament->getDescription();
            $query->bindParam(':nom', $nom, $this->pdo::PARAM_STR);
            $query->bindParam(':description', $description, $this->pdo::PARAM_STR);
            $query->execute();
        }
    }
}