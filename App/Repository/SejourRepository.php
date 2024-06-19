<?php

namespace App\Repository;

use App\Entity\Sejour;
use App\Db\Mysql;
class SejourRepository extends Repository
{
    public function findOneById(int $id): Sejour|bool
    {
        $query = $this->pdo->prepare("SELECT * FROM sejours WHERE id = :id");
        $query->bindParam(':id', $id, $this->pdo::PARAM_STR);
        $query->execute();
        $sejourData = $query->fetch($this->pdo::FETCH_ASSOC);
        if ($sejourData) {
            return Sejour::createAndHydrate($sejourData);;
        } else {
            return false;
        }
    }

    public function persist(Sejour $sejour)
    {
        
            $query = $this->pdo->prepare('INSERT INTO sejours (date_debut, date_fin, motif, specialite, medecin_id) 
                                                    VALUES (:date_debut, :date_fin, :motif, :specialite, :medecin_id)'
            );
        
        $query->bindValue(':date_debut', $sejour->getDate_debut(), $this->pdo::PARAM_STR);
        $query->bindValue(':date_fin', $sejour->getDate_fin(), $this->pdo::PARAM_STR);
        $query->bindValue(':motif', $sejour->getMotif(), $this->pdo::PARAM_STR);
        $query->bindValue(':specialite_id', $sejour->getSpecialite_id(), $this->pdo::PARAM_STR);
        $query->bindValue(':medecin_id', $sejour->getMedecin_id(), $this->pdo::PARAM_STR);

        return $query->execute();
    }
}