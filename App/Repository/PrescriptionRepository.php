<?php

namespace App\Repository;

use App\Entity\Prescription;

class PrescriptionRepository extends Repository
{
    public function findOneById(int $id) 
    {
        $query = $this->pdo->prepare('SELECT * FROM prescription WHERE id = :id');
        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
        $query->execute();
        $prescriptionData = $query->fetch($this->pdo::FETCH_ASSOC);
        if ($prescriptionData) {
            return Prescription::createAndHydrate($prescriptionData);
        } else {
            return false;
        }
    }

    public function findAll(): array
    {
        $query = $this->pdo->query('SELECT * FROM prescription');
        $prescriptionsData = $query->fetchAll($this->pdo::FETCH_ASSOC);
        $prescriptions = [];
        foreach ($prescriptionsData as $prescriptionData) {
            $prescriptions[] = Prescription::createAndHydrate($prescriptionData);
        }
        return $prescriptions;
    }

    public function findBySejourId(int $sejourId): array
    {
        $query = $this->pdo->prepare('SELECT * FROM prescription WHERE sejour_id = :sejour_id');
        $query->bindParam(':sejour_id', $sejourId, $this->pdo::PARAM_INT);
        $query->execute();
        $prescriptionsData = $query->fetchAll($this->pdo::FETCH_ASSOC);
        $prescriptions = [];
        foreach ($prescriptionsData as $prescriptionData) {
            $prescriptions[] = Prescription::createAndHydrate($prescriptionData);
        }
        return $prescriptions;
    }

    public function create(Prescription $prescription): void
    {
        if($prescription->getId() === null) {
            $query = $this->pdo->prepare('INSERT INTO prescription (libelle, date_prescription, description, medecin_id, sejour_id) VALUES (:libelle, :date_prescription, :description, :medecin_id, :sejour_id)');
            $libelle = $prescription->getLibelle();
            $datePrescription = $prescription->getDate_Prescription()->format('Y-m-d');
            $description = $prescription->getDescription();
            $medecinId = $prescription->getMedecin_Id();
            $sejourId = $prescription->getSejour_Id();
            $query->bindParam(':libelle', $libelle, $this->pdo::PARAM_STR);
            $query->bindParam(':date_prescription', $datePrescription, $this->pdo::PARAM_STR);
            $query->bindParam(':description', $description, $this->pdo::PARAM_STR);
            $query->bindParam(':medecin_id', $medecinId, $this->pdo::PARAM_INT);
            $query->bindParam(':sejour_id', $sejourId, $this->pdo::PARAM_INT);
            $query->execute();
            $prescription->setId($this->pdo->lastInsertId());
        } else {
            $query = $this->pdo->prepare('UPDATE prescription SET libelle = :libelle, date_prescription = :date_prescription, description = :description, medecin_id = :medecin_id, sejour_id = :sejour_id WHERE id = :id');
            $libelle = $prescription->getLibelle();
            $datePrescription = $prescription->getDate_Prescription()->format('Y-m-d');
            $description = $prescription->getDescription();
            $medecinId = $prescription->getMedecin_Id();
            $sejourId = $prescription->getSejour_Id();

            $query->bindParam(':libelle', $libelle, $this->pdo::PARAM_STR);
            $query->bindParam(':date_prescription', $datePrescription, $this->pdo::PARAM_STR);
            $query->bindParam(':description', $description, $this->pdo::PARAM_STR);
            $query->bindParam(':medecin_id', $medecinId, $this->pdo::PARAM_INT);
            $query->bindParam(':sejour_id', $sejourId, $this->pdo::PARAM_INT);
            $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
            $query->execute();
        }
    }

    public function update(Prescription $prescription): void
    {
        $query = $this->pdo->prepare('UPDATE prescription SET libelle = :libelle, date_prescription = :date_prescription, description = :description, medecin_id = :medecin_id, sejour_id = :sejour_id WHERE id = :id');
        $libelle = $prescription->getLibelle();
        $datePrescription = $prescription->getDate_Prescription()->format('Y-m-d');
        $description = $prescription->getDescription();
        $medecinId = $prescription->getMedecin_Id();
        $sejourId = $prescription->getSejour_Id();

        $query->bindParam(':libelle', $libelle, $this->pdo::PARAM_STR);
        $query->bindParam(':date_prescription', $datePrescription, $this->pdo::PARAM_STR);
        $query->bindParam(':description', $description, $this->pdo::PARAM_STR);
        $query->bindParam(':medecin_id', $medecinId, $this->pdo::PARAM_INT);
        $query->bindParam(':sejour_id', $sejourId, $this->pdo::PARAM_INT);
        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
        $query->execute();
    }

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare('DELETE FROM prescription WHERE id = :id');
        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
        $query->execute();
    }
}