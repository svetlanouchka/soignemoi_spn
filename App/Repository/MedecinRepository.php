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
}