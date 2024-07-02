<?php
namespace App\Repository;

use App\Entity\Planning;

class PlanningRepository extends Repository
{

    public function findBySejourId(int $sejour_id): array
{
    $query = $this->pdo->prepare("SELECT * FROM planning WHERE sejour_id = :sejour_id");
    $query->bindParam(':sejour_id', $sejour_id, $this->pdo::PARAM_INT);
    $query->execute();

    $plannings = [];
    while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
        $planning = new Planning();
        $planning->setId($row['id']);
        $planning->setMedecinId($row['medecin_id']);
        $planning->setSejour_Id($row['sejour_id']);
        $planning->setDate_i(new \DateTime($row['date_i']));
        $planning->setNombrePatients($row['nombre_patients']);
        
        $plannings[] = $planning;
    }

    return $plannings;
}
    public function findByMedecinIdAndDate(int $medecin_id, \DateTime $date_i): ?Planning
    {

        $dateFormatted = $date_i->format('Y-m-d H:i:s');
        $query = $this->pdo->prepare("SELECT * FROM planning_medecins WHERE medecin_id = :medecin_id AND date_i = :date_i");
        $query->bindValue(':medecin_id', $medecin_id, $this->pdo::PARAM_INT);
        $query->bindValue(':date_i', $dateFormatted, $this->pdo::PARAM_STR);
        $query->execute();

        $planningData = $query->fetch($this->pdo::FETCH_ASSOC);

        if ($planningData) {
            return Planning::createAndHydrate($planningData);
        }

        return null;
    }

    public function save(Planning $planning, \DateTime $date_i):void
    {
        $medecin_id = $planning->getMedecinId();
        $nombre_patients = $planning->getNombrePatients();
        $id = $planning->getId();
        if ($planning->getId() === null) {
            $query = $this->pdo->prepare(
                "INSERT INTO planning_medecins (medecin_id, date_i, nombre_patients) VALUES (:medecin_id, :date_i, :nombre_patients)"
            );
            $dateFormatted = $date_i->format('Y-m-d H:i:s');
            $query->bindParam(':medecin_id', $medecin_id, $this->pdo::PARAM_INT);
            $query->bindValue(':date_i', $dateFormatted, $this->pdo::PARAM_STR);
            $query->bindParam(':nombre_patients', $nombre_patients, $this->pdo::PARAM_INT);
            $query->execute();
            $planning->setId($this->pdo->lastInsertId());
        } else {
            $query = $this->pdo->prepare(
                "UPDATE planning_medecins SET medecin_id = :medecin_id, date_i = :date_i, nombre_patients = :nombre_patients WHERE id = :id"
            );
            $dateFormatted = $date_i->format('Y-m-d H:i:s');
            $query->bindParam(':medecin_id', $medecin_id, $this->pdo::PARAM_INT);
            $query->bindValue(':date_i', $dateFormatted, $this->pdo::PARAM_STR);
            $query->bindParam(':nombre_patients', $nombre_patients, $this->pdo::PARAM_INT);
            $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
            $query->execute();
        }
    }
        

    public function countPatientsByMedecinAndDate(int $medecinId, \DateTime $date_i): int
    {
        $dateFormatted = $date_i->format('Y-m-d H:i:s');
        $query = $this->pdo->prepare("SELECT COUNT(*) FROM planning_medecins WHERE medecin_id = :medecin_id AND date_i = :date_i");
        $query->bindParam(':medecin_id', $medecinId, $this->pdo::PARAM_INT);
        $query->bindValue(':date_i', $dateFormatted, $this->pdo::PARAM_STR);
        $query->execute();

        return (int) $query->fetchColumn();
    }

    public function findByMedecinId(int $medecin_id): array
    {
        $query = $this->pdo->prepare("SELECT * FROM planning_medecins WHERE medecin_id = :medecin_id");
        $query->bindParam(':medecin_id', $medecin_id, $this->pdo::PARAM_INT);
        $query->execute();

        $plannings = [];
        while ($row = $query->fetch($this->pdo::FETCH_ASSOC)) {
            $planning = $this->createAndHydrate($row);
            $plannings[] = $planning;
        }

        return $plannings;
    }

    private function createAndHydrate(array $row): Planning
    {
        $planning = new Planning();
        $planning->setId($row['id']);
        $planning->setMedecinId($row['medecin_id']);
        $planning->setDate_i(new \DateTime($row['date_i']));
        $planning->setNombrePatients($row['nombre_patients']);

        return $planning;
    }
}
