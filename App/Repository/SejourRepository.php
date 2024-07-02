<?php

namespace App\Repository;

use App\Entity\Sejour;
use App\Entity\Specialite;
use App\Entity\Medecin;
use App\Db\Mysql;
class SejourRepository extends Repository
{
    public function findByUserId(int $userId): array
    {
        $query = $this->pdo->prepare("SELECT s.*, sp.name AS specialite_name, m.nom AS medecin_nom, m.prenom AS medecin_prenom
            FROM sejours s
            LEFT JOIN specialites sp ON s.specialite_id = sp.id
            LEFT JOIN medecin m ON s.medecin_id = m.id
            WHERE s.user_id = :user_id");
        $query->bindParam(':user_id', $userId, $this->pdo::PARAM_INT);
        $query->execute();
        $sejoursData = $query->fetchAll($this->pdo::FETCH_ASSOC);

        if ($sejoursData === false) {
            return [];
        }

        $sejours = [];
        foreach ($sejoursData as $sejourData) {
            $sejour = Sejour::createAndHydrate($sejourData);
             // Hydrate specialite
            $specialite = new Specialite();
            $specialite->setId($sejourData['specialite_id']);
            $specialite->setName($sejourData['specialite_name']);
            $sejour->setSpecialite($specialite);

             // Hydrate medecin
            $medecin = new Medecin();
            $medecin->setId($sejourData['medecin_id']);
            $medecin->setNom($sejourData['medecin_nom']);
            $medecin->setPrenom($sejourData['medecin_prenom']);
            $sejour->setMedecin($medecin);
            $sejours[] = $sejour;

        }

        return $sejours;
    }

    public function findAll(): array
            {
                $query = $this->pdo->query("SELECT * FROM sejours");
                $sejoursData = $query->fetchAll($this->pdo::FETCH_ASSOC);
                $sejours = [];
                
                foreach ($sejoursData as $sejourData) {
                    $sejours[] = Sejour::createAndHydrate($sejourData);
                }
                
                return $sejours;
            }

    public function countPatientsByMedecinAndDate(int $medecinId, \DateTime $date_i): int
            {
                $query = $this->pdo->prepare("SELECT COUNT(*) FROM sejours WHERE medecin_id = :medecin_id AND date_i = :date_i");
                $query->bindParam(':medecin_id', $medecinId, $this->pdo::PARAM_INT);
                $query->bindParam(':date_i', $date_i, $this->pdo::PARAM_STR);
                $query->execute();
        
                return (int) $query->fetchColumn();
            }

    public function persist(Sejour $sejour): bool
            {
                $query = $this->pdo->prepare(
                    'INSERT INTO sejours (date_debut, date_fin, motif, specialite_id, medecin_id, user_id) 
                    VALUES (:date_debut, :date_fin, :motif, :specialite_id, :medecin_id, :user_id)'
                );
            
                $dateDebut = $sejour->getDate_debut()->format('Y-m-d H:i:s');
                $dateFin = $sejour->getDate_fin()->format('Y-m-d H:i:s');
            
                $query->bindValue(':date_debut', $dateDebut, $this->pdo::PARAM_STR);
                $query->bindValue(':date_fin', $dateFin, $this->pdo::PARAM_STR);
                $query->bindValue(':motif', $sejour->getMotif(), $this->pdo::PARAM_STR);
                $query->bindValue(':specialite_id', $sejour->getSpecialite_id(), $this->pdo::PARAM_INT);
                $query->bindValue(':medecin_id', $sejour->getMedecin_id(), $this->pdo::PARAM_INT);
                $query->bindValue(':user_id', $sejour->getUserId(), $this->pdo::PARAM_INT);
            
                $result = $query->execute();
            
                if ($result) {
                    $sejour->setId($this->pdo->lastInsertId());
                    $this->addToPlanningMedecins($sejour);
                }
            
                return $result;
            }
            
    private function addToPlanningMedecins(Sejour $sejour): void
            {
                $startDate = $sejour->getDate_debut();
                $endDate = $sejour->getDate_fin();
                $interval = $startDate->diff($endDate)->days + 1;
            
                for ($i = 0; $i < $interval; $i++) {
                    $currentDate = clone $startDate;
                    $currentDate->modify("+{$i} days");
            
                    $query = $this->pdo->prepare(
                        "INSERT INTO planning_medecins (medecin_id, sejour_id, date_i, nombre_patients) 
                        VALUES (:medecin_id, :sejour_id, :date_i, :nombre_patients)"
                    );
            
                    $query->bindValue(':medecin_id', $sejour->getMedecin_id(), $this->pdo::PARAM_INT);
                    $query->bindValue(':sejour_id', $sejour->getId(), $this->pdo::PARAM_INT);
                    $query->bindValue(':date_i', $currentDate->format('Y-m-d'), $this->pdo::PARAM_STR);
                    $query->bindValue(':nombre_patients', 1, $this->pdo::PARAM_INT);
            
                    $query->execute();
                }
            }
}
