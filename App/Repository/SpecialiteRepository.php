<?php

namespace App\Repository;

use App\Entity\Specialite;
use App\Db\Mysql;
class SpecialiteRepository extends Repository
{
    public function findOneById(int $id)
    {

            $query = $this->pdo->prepare("SELECT * FROM specialites WHERE id = :id");
            $query->bindParam(':id', $id, $this->pdo::PARAM_STR);
            $query->execute();
            $specialiteData = $query->fetch($this->pdo::FETCH_ASSOC);
            if ($specialiteData) {
                return Specialite::createAndHydrate($specialiteData);;
            } else {
                return false;
            }
        }            
    public function findAll(): array
            {
                $query = $this->pdo->query("SELECT * FROM specialites");
                $specialitesData = $query->fetchAll($this->pdo::FETCH_ASSOC);
                $specialites = [];
                
                foreach ($specialitesData as $specialiteData) {
                    $specialites[] = Specialite::createAndHydrate($specialiteData);
                }
                
                return $specialites;
            }
        
    }
