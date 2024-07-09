<?php

namespace App\Repository;

use App\Entity\PrescriptionMedicament; // Add this line to import the 'PrescriptionMedicament' class
use App\Db\Mysql;

class PrescriptionMedicamentRepository extends Repository
{
    public function findOneById(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM prescription_medicament WHERE id = :id");
        $query->bindParam(':id', $id, $this->pdo::PARAM_STR);
        $query->execute();
        $prescriptionMedicamentData = $query->fetch($this->pdo::FETCH_ASSOC);
        if ($prescriptionMedicamentData) {
            return PrescriptionMedicament::createAndHydrate($prescriptionMedicamentData);;
        } else {
            return false;
        }
    }

    public function findAll()
    {
        $query = $this->pdo->prepare("SELECT * FROM prescriptions_medicaments");
        $query->execute();
        $prescriptionMedicamentData = $query->fetchAll($this->pdo::FETCH_ASSOC);
        $prescriptionMedicaments = [];
        foreach ($prescriptionMedicamentData as $prescriptionMedicament) {
            $prescriptionMedicaments[] = PrescriptionMedicament::createAndHydrate($prescriptionMedicament);
        }
        return $prescriptionMedicaments;
    }

    public function findByPrescriptionId(int $prescriptionId)
    {
        $query = $this->pdo->prepare("SELECT * FROM prescriptions_medicaments WHERE prescription_id = :prescription_id");
        $query->bindParam(':prescription_id', $prescriptionId, $this->pdo::PARAM_INT);
        $query->execute();
        $prescriptionMedicamentData = $query->fetchAll($this->pdo::FETCH_ASSOC);
        $prescriptionMedicaments = [];
        foreach ($prescriptionMedicamentData as $prescriptionMedicament) {
            $prescriptionMedicaments[] = PrescriptionMedicament::createAndHydrate($prescriptionMedicament);
        }
        return $prescriptionMedicaments;
    }

    public function create(PrescriptionMedicament $prescriptionMedicament): void
    {
        if($prescriptionMedicament->getId() === null) {
            $query = $this->pdo->prepare("INSERT INTO prescriptions_medicaments (prescription_id, medicament_id, posologie, datedebut, datefin) VALUES (:prescription_id, :medicament_id, :posologie, :datedebut, :datefin)");

            $prescription_id = $prescriptionMedicament->getPrescription_Id();
            $medicament_id = $prescriptionMedicament->getMedicament_Id();
            $posologie = $prescriptionMedicament->getPosologie();
            $datedebut = $prescriptionMedicament->getDateDebut();
            $datefin = $prescriptionMedicament->getDateFin();

            $query->bindParam(':prescription_id', $prescription_id, $this->pdo::PARAM_INT);
            $query->bindParam(':medicament_id', $medicament_id, $this->pdo::PARAM_INT);
            $query->bindParam(':posologie', $posologie, $this->pdo::PARAM_STR);
            $query->bindParam(':datedebut', $datedebut, $this->pdo::PARAM_STR);
            $query->bindParam(':datefin', $datefin, $this->pdo::PARAM_STR);
            $query->execute();
            $prescriptionMedicament->setId($this->pdo->lastInsertId());
        } else {
            $query = $this->pdo->prepare("UPDATE prescriptions_medicaments SET prescription_id = :prescription_id, medicament_id = :medicament_id, posologie = :posologie, datedebut = :datedebut, datefin = :datefin WHERE id = :id");

            $id = $prescriptionMedicament->getId();
            $prescription_id = $prescriptionMedicament->getPrescription_Id();
            $medicament_id = $prescriptionMedicament->getMedicament_Id();
            $posologie = $prescriptionMedicament->getPosologie();
            $datedebut = $prescriptionMedicament->getDateDebut();
            $datefin = $prescriptionMedicament->getDateFin();

            $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
            $query->bindParam(':prescription_id', $prescription_id, $this->pdo::PARAM_INT);
            $query->bindParam(':medicament_id', $medicament_id, $this->pdo::PARAM_INT);
            $query->bindParam(':posologie', $posologie, $this->pdo::PARAM_STR);
            $query->bindParam(':datedebut', $datedebut, $this->pdo::PARAM_STR);
            $query->bindParam(':datefin', $datefin, $this->pdo::PARAM_STR);
            $query->execute();
            
    }
}

public function update(PrescriptionMedicament $prescriptionMedicament): void
{
    $query = $this->pdo->prepare("UPDATE prescriptions_medicaments SET prescription_id = :prescription_id, medicament_id = :medicament_id, posologie = :posologie, datedebut = :datedebut, datefin = :datefin WHERE id = :id");

    $id = $prescriptionMedicament->getId();
    $prescription_id = $prescriptionMedicament->getPrescription_Id();
    $medicament_id = $prescriptionMedicament->getMedicament_Id();
    $posologie = $prescriptionMedicament->getPosologie();
    $datedebut = $prescriptionMedicament->getDateDebut();
    $datefin = $prescriptionMedicament->getDateFin();

    $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
    $query->bindParam(':prescription_id', $prescription_id, $this->pdo::PARAM_INT);
    $query->bindParam(':medicament_id', $medicament_id, $this->pdo::PARAM_INT);
    $query->bindParam(':posologie', $posologie, $this->pdo::PARAM_STR);
    $query->bindParam(':datedebut', $datedebut, $this->pdo::PARAM_STR);
    $query->bindParam(':datefin', $datefin, $this->pdo::PARAM_STR);
    $query->execute();
}

public function delete(PrescriptionMedicament $prescriptionMedicament): void
{
    $query = $this->pdo->prepare("DELETE FROM prescriptions_medicaments WHERE id = :id");
    $id = $prescriptionMedicament->getId();
    $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
    $query->execute();
}
}