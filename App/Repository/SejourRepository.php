<?php

namespace App\Repository;

use App\Entity\Sejour;
use App\Db\Mysql;
class SejourRepository extends Repository
{
    public function findOneById(int $id): Sejour|bool
    {
        $query = $this->pdo->prepare("SELECT * FROM sejour WHERE id = :id");
        $query->bindParam(':id', $id, $this->pdo::PARAM_STR);
        $query->execute();
        $sejourData = $query->fetch($this->pdo::FETCH_ASSOC);
        if ($sejourData) {
            return Sejour::createAndHydrate($sejourData);;
        } else {
            return false;
        }
    }
}