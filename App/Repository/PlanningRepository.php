<?php
namespace App\Repository;

use App\Entity\Planning;

class PlanningRepository extends Repository
{
    public function findByMedecinIdAndDate(int $medecin_id, \DateTime $date): ?Planning
    {
        $query = $this->pdo->prepare("SELECT * FROM planning_medecins WHERE medecin_id = :medecin_id AND date = :date");
        $query->bindParam(':medecin_id', $medecin_id, $this->pdo::PARAM_INT);
        $query->bindParam(':date', $date->format('Y-m-d'));
        $query->execute();

        $planningData = $query->fetch($this->pdo::FETCH_ASSOC);

        if ($planningData) {
            return Planning::createAndHydrate($planningData);
        }

        return null;
    }

    public function save(Planning $planning): void
    {
        if ($planning->getId() === null) {
            $query = $this->pdo->prepare(
                "INSERT INTO planning_medecins (medecin_id, date, nombre_patients) VALUES (:medecin_id, :date, :nombre_patients)"
            );
            $query->bindParam(':medecin_id', $planning->getMedecinId(), $this->pdo::PARAM_INT);
            $query->bindParam(':date', $planning->getDate()->format('Y-m-d'));
            $query->bindParam(':nombre_patients', $planning->getNombrePatients(), $this->pdo::PARAM_INT);
            $query->execute();
            $planning->setId($this->pdo->lastInsertId());
        } else {
            $query = $this->pdo->prepare(
                "UPDATE planning_medecins SET medecin_id = :medecin_id, date = :date, nombre_patients = :nombre_patients WHERE id = :id"
            );
            $query->bindParam(':medecin_id', $planning->getMedecinId(), $this->pdo::PARAM_INT);
            $query->bindParam(':date', $planning->getDate()->format('Y-m-d'));
            $query->bindParam(':nombre_patients', $planning->getNombrePatients(), $this->pdo::PARAM_INT);
            $query->bindParam(':id', $planning->getId(), $this->pdo::PARAM_INT);
            $query->execute();
        }
    }

    public function countPatientsByMedecinAndDate(int $medecinId, \DateTime $date): int
    {
        $query = $this->pdo->prepare("SELECT COUNT(*) FROM planning_medecins WHERE medecin_id = :medecin_id AND date = :date");
        $query->bindParam(':medecin_id', $medecinId, $this->pdo::PARAM_INT);
        $query->bindParam(':date', $date->format('Y-m-d'), $this->pdo::PARAM_STR);
        $query->execute();

        return (int) $query->fetchColumn();
    }
}
