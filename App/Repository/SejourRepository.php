<?php

namespace App\Repository;

use App\Entity\Sejour;
use App\Db\Mysql;
class SejourRepository extends Repository
{
    public function findOneById(int $id): Sejour|bool
    {
        $query = $this->pdo->prepare("SELECT * FROM sejours WHERE id = :id");
        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
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
        
            $query = $this->pdo->prepare('INSERT INTO sejours (date_debut, date_fin, motif, specialite_id, medecin_id, user_id) 
                                                    VALUES (:date_debut, :date_fin, :motif, :specialite_id, :medecin_id, :user_id)'
            );
        
            $dateDebut = $sejour->getDate_debut()->format('Y-m-d H:i:s');
            $dateFin = $sejour->getDate_fin()->format('Y-m-d H:i:s');
        
            $query->bindValue(':date_debut', $dateDebut, $this->pdo::PARAM_STR);
            $query->bindValue(':date_fin', $dateFin, $this->pdo::PARAM_STR);
            $query->bindValue(':motif', $sejour->getMotif(), $this->pdo::PARAM_STR);
            $query->bindValue(':specialite_id', $sejour->getSpecialite_id(), $this->pdo::PARAM_INT);
            $query->bindValue(':medecin_id', $sejour->getMedecin_id(), $this->pdo::PARAM_INT);
            $query->bindValue(':user_id', $sejour->getUserid(), $this->pdo::PARAM_INT);
        return $query->execute();
    }
}