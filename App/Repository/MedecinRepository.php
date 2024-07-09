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

            public function findAllWithSpecialites(): array
            {
                $query = $this->pdo->query("
                    SELECT m.*, s.name as specialite_name 
                    FROM medecin m 
                    LEFT JOIN specialites s ON m.specialite_id = s.id
                ");
                
                $medecinsData = $query->fetchAll($this->pdo::FETCH_ASSOC);
                $medecins = [];
        
                foreach ($medecinsData as $medecinData) {
                    $medecin = Medecin::createAndHydrate($medecinData);
                    $medecin->setSpecialiteName($medecinData['specialite_name']);
                    $medecins[] = $medecin;
                }
        
                return $medecins;
            }
            public function save(Medecin $medecin): void
            {
                if ($medecin->getId() === null) {
                    $query = $this->pdo->prepare(
                        "INSERT INTO medecin (nom, prenom, email, specialite_id, matricule) VALUES (:nom, :prenom, :email, :specialite_id, :matricule)"
                    );
                    $nom = $medecin->getNom();
                    $prenom = $medecin->getPrenom();
                    $email = $medecin->getEmail();
                    $specialite_id = $medecin->getSpecialite_id();
                    $matricule = $medecin->getMatricule();
        
                    $query->bindParam(':nom', $nom, $this->pdo::PARAM_STR);
                    $query->bindParam(':prenom', $prenom, $this->pdo::PARAM_STR);
                    $query->bindParam(':email', $email, $this->pdo::PARAM_STR);
                    $query->bindParam(':specialite_id', $specialite_id, $this->pdo::PARAM_INT);
                    $query->bindParam(':matricule', $matricule, $this->pdo::PARAM_STR);
                    $query->execute();
                    $medecin->setId($this->pdo->lastInsertId());
                } else {
                    $query = $this->pdo->prepare(
                        "UPDATE medecin SET nom = :nom, prenom = :prenom, email = :email, specialite_id = :specialite_id, matricule = :matricule WHERE id = :id"
                    );
                    $id = $medecin->getId();
                    $nom = $medecin->getNom();
                    $prenom = $medecin->getPrenom();
                    $email = $medecin->getEmail();
                    $specialite_id = $medecin->getSpecialite_id();
                    $matricule = $medecin->getMatricule();
        
                    $query->bindParam(':nom', $nom, $this->pdo::PARAM_STR);
                    $query->bindParam(':prenom', $prenom, $this->pdo::PARAM_STR);
                    $query->bindParam(':email', $email, $this->pdo::PARAM_STR);
                    $query->bindParam(':specialite_id', $specialite_id, $this->pdo::PARAM_INT);
                    $query->bindParam(':matricule', $matricule, $this->pdo::PARAM_STR);
                    $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
                    $query->execute();
                }
            }
                public function update(Medecin $medecin): void
                    {
                        $query = $this->pdo->prepare("UPDATE medecin SET nom = :nom, prenom = :prenom, email = :email, specialite = :specialite, matricule = :matricule WHERE id = :id");
                        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
                        $query->bindParam(':nom', $nom, $this->pdo::PARAM_STR);
                        $query->bindParam(':prenom', $prenom, $this->pdo::PARAM_STR);
                        $query->bindParam(':email', $email, $this->pdo::PARAM_STR);
                        $query->bindParam(':specialite', $specialite_id, $this->pdo::PARAM_INT);
                        $query->bindParam(':matricule', $matricule, $this->pdo::PARAM_STR);
                        $query->execute();
                    }
                    public function delete(int $id): void
                    {
                        $query = $this->pdo->prepare("DELETE FROM medecin WHERE id = :id");
                        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
                        $query->execute();
                    }
                }