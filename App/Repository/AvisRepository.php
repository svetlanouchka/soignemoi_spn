<?php

namespace App\Repository;

use App\Entity\Avis;
use App\Db\Mysql;
class AvisRepository extends Repository
{ 

    public function findOneById(int $id)
    {
        $query = $this->pdo->prepare('SELECT * FROM avis WHERE id = :id');
        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
        $query->execute();
        $avisData = $query->fetch($this->pdo::FETCH_ASSOC);
        if ($avisData) {
            return Avis::createAndHydrate($avisData);
        } else {
            return false;
        }
    }

    public function findAll()
    {
        $query = $this->pdo->query('SELECT * FROM avis');
        $avisData = $query->fetchAll($this->pdo::FETCH_ASSOC);
        $avis = [];
        foreach ($avisData as $data) {
            $avis[] = Avis::createAndHydrate($data);
        }
        return $avis;
    }
    public function findBySejourId(int $sejour_id)
    {
        $query = $this->pdo->prepare('SELECT * FROM avis WHERE sejour_id = :sejour_id');
        $query->bindParam(':sejour_id', $sejour_id, $this->pdo::PARAM_INT);
        $query->execute();
        $avisData = $query->fetch($this->pdo::FETCH_ASSOC);
        if ($avisData) {
            return Avis::createAndHydrate($avisData);;
        } else {
            return false;
        }
        }
    

    public function create(Avis $avis): void
    {
        if ($avis->getId() === null) {
            $query = $this->pdo->prepare('INSERT INTO avis (libelle, date_avis, description, medecin_id, sejour_id) 
                                    VALUES (:libelle, :date_avis, :description, :medecin_id, :sejour_id)');
            $libelle = $avis->getLibelle();
            $date_avis = $avis->getDate_Avis();
            $description = $avis->getDescription();
            $medecin_id = $avis->getMedecin_Id();
            $sejour_id = $avis->getSejour_Id();

            $query->bindParam(':libelle', $libelle, $this->pdo::PARAM_STR);
            $query->bindParam(':date_avis', $date_avis, $this->pdo::PARAM_STR);
            $query->bindParam(':description', $description, $this->pdo::PARAM_STR);
            $query->bindParam(':medecin_id', $medecin_id, $this->pdo::PARAM_INT);
            $query->bindParam(':sejour_id', $sejour_id, $this->pdo::PARAM_INT);
            $query->execute();   
            $avis->setId($this->pdo->lastInsertId());
        } else {
            $query = $this->pdo->prepare('UPDATE avis SET libelle = :libelle, date_avis = :date_avis, description = :description, medecin_id = :medecin_id, sejour_id = :sejour_id WHERE id = :id');
            $libelle = $avis->getLibelle();
            $date_avis = $avis->getDate_Avis();
            $description = $avis->getDescription();
            $medecin_id = $avis->getMedecin_Id();
            $sejour_id = $avis->getSejour_Id();

            $query->bindParam(':libelle', $libelle, $this->pdo::PARAM_STR);
            $query->bindParam(':date_avis', $date_avis, $this->pdo::PARAM_STR);
            $query->bindParam(':description', $description, $this->pdo::PARAM_STR);
            $query->bindParam(':medecin_id', $medecin_id, $this->pdo::PARAM_INT);
            $query->bindParam(':sejour_id', $sejour_id, $this->pdo::PARAM_INT);
            $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
            $query->execute();
        }
    }

    public function update(Avis $avis): void
    {
        $query = $this->pdo->prepare('UPDATE avis SET libelle = :libelle, date_avis = :date_avis, description = :description, medecin_id = :medecin_id, sejour_id = :sejour_id WHERE id = :id');
        $libelle = $avis->getLibelle();
        $date_avis = $avis->getDate_Avis();
        $description = $avis->getDescription();
        $medecin_id = $avis->getMedecin_Id();
        $sejour_id = $avis->getSejour_Id();

        $query->bindParam(':libelle', $libelle, $this->pdo::PARAM_STR);
        $query->bindParam(':date_avis', $date_avis, $this->pdo::PARAM_STR);
        $query->bindParam(':description', $description, $this->pdo::PARAM_STR);
        $query->bindParam(':medecin_id', $medecin_id, $this->pdo::PARAM_INT);
        $query->bindParam(':sejour_id', $sejour_id, $this->pdo::PARAM_INT);
        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
        $query->execute();
    }
    
    public function delete(int $id): void
    {
        $query = $this->pdo->prepare('DELETE FROM avis WHERE id = :id');
        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
        $query->execute();
    }
}