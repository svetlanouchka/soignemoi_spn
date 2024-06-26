<?php

namespace App\Repository;

use App\Entity\Medecin;
use App\Db\Mysql;
class MedecinRepository extends Repository
{
    public function findOneById(int $id)
    {

            $query = $this->pdo->prepare("SELECT * FROM medecin WHERE id = :id");
            $query->bindParam(':id', $id, $this->pdo::PARAM_STR);
            $query->execute();
            $medecinData = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($medecinData) {
                return Medecin::createAndHydrate($medecinData);;
            } else {
                return false;
            }
        }            
    public function findAll(): array
            {
                $query = $this->pdo->query("SELECT * FROM medecin");
                $medecinsData = $query->fetchAll($this->pdo::FETCH_ASSOC);
                $medecins = [];
                
                foreach ($medecinsData as $medecinData) {
                    $medecins[] = Medecin::createAndHydrate($medecinData);
                }
                
                return $medecins;
            }

            public function save(Medecin $medecin): bool
                {
                    if ($medecin->getId()) {
                        // Update existing medecin
                        $query = $this->pdo->prepare("UPDATE medecins SET nom = :nom, prenom = :prenom, specialite = :specialite, matricule = :matricule WHERE id = :id");
                        $query->bindParam(':id', $medecin->getId(), $this->pdo::PARAM_INT);
                    } else {
                        // Insert new medecin
                        $query = $this->pdo->prepare("INSERT INTO medecins (nom, prenom, specialite_id, matricule) VALUES (:nom, :prenom, :specialite_id, :matricule)");
                    }
                    
                    $query->bindParam(':nom', $medecin->getNom(), $this->pdo::PARAM_STR);
                    $query->bindParam(':prenom', $medecin->getPrenom(), $this->pdo::PARAM_STR);
                    $query->bindParam(':specialite', $medecin->getSpecialite_id(), $this->pdo::PARAM_INT);
                    $query->bindParam(':matricule', $medecin->getMatricule(), $this->pdo::PARAM_STR);
                    
                    return $query->execute();
                }

                public function update(Medecin $medecin): void
                    {
                        $query = $this->pdo->prepare("UPDATE medecins SET nom = :nom, prenom = :prenom, specialite = :specialite, matricule = :matricule WHERE id = :id");
                        $query->bindParam(':id', $medecin->getId(), $this->pdo::PARAM_INT);
                        $query->bindParam(':nom', $medecin->getNom(), $this->pdo::PARAM_STR);
                        $query->bindParam(':prenom', $medecin->getPrenom(), $this->pdo::PARAM_STR);
                        $query->bindParam(':specialite', $medecin->getSpecialite_id(), $this->pdo::PARAM_INT);
                        $query->bindParam(':matricule', $medecin->getMatricule(), $this->pdo::PARAM_STR);
                        $query->execute();
                    }
                    public function delete(int $id): void
                    {
                        $query = $this->pdo->prepare("DELETE FROM medecins WHERE id = :id");
                        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
                        $query->execute();
                    }
        // Appel bdd
        /*$mysql = Mysql::getInstance();

        $pdo = $mysql->getPDO();
        
        $query = $pdo->prepare('SELECT $ ')

        $medecin = ['id' => 1, 'nom' => 'nomtest', 'prenom' => 'prenomtest', 'specialite' => 'specialitetest', 'matricule' => 'matriculetest'];

        $medecinEntity = new Medecin();
        $medecinEntity->setId($medecin['id']);
        $medecinEntity->setNom($medecin['nom']);
        $medecinEntity->setPrenom($medecin['prenom']);
        $medecinEntity->setSpecialite($medecin['specialite']);
        $medecinEntity->setMatricule($medecin['matricule']);

        return $medecinEntity;*/
    }
