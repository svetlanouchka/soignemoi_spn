<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Db\Mysql;
use App\Repository\UserRepository;
use App\Repository\SejourRepository;
use App\Entity\User;


class UserSejourVis extends TestCase
{
    protected $sejourRepository;

    protected function setUp(): void
    {
        $mysql = Mysql::getInstance();
        $this->sejourRepository = new SejourRepository($mysql);
    }

public function testUserStayHistory()
{
    $userId = 1; // ID de l'utilisateur pour le test
    $sejours = $this->sejourRepository->findByUserId($userId);

    $this->assertNotEmpty($sejours);
    foreach ($sejours as $sejour) {
        $this->assertIsArray($sejour);
        $this->assertArrayHasKey('date_debut', $sejour);
        $this->assertArrayHasKey('date_fin', $sejour);
        $this->assertArrayHasKey('motif', $sejour);
        $this->assertArrayHasKey('specialite_id', $sejour);
        $this->assertArrayHasKey('medecin_id', $sejour);
        $this->assertArrayHasKey('user_id', $sejour);
    }
}
}
