<?php

namespace App\Repository;

require_once __DIR__ . '/../Db/Mysql.php';

use App\Entity\Book;
use App\Db\Mysql;
use App\Tools\StringTools;

class Repository
{
    protected \PDO $pdo;

    public function __construct()
    {
        $mysql = Mysql::getInstance();
        $this->pdo = $mysql->getPDO();
    }

}