<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Db\Mysql;
use App\Repository\SejourRepository;
use App\Entity\Sejour;


class UserCreateSejour extends TestCase
{
    protected $sejourRepository;

    protected function setUp(): void
    {
        $mysql = Mysql::getInstance();
        $this->sejourRepository = new SejourRepository($mysql);
    }
public function testCreateStay()
{
    $sejourData = [
        'date_debut' => '2024-08-01',
        'date_fin' => '2024-08-10',
        'motif' => 'Consultation',
        'specialite_id' => '1',
        'medecin_id' => '1',
        'user_id' => '1'
    ];

    $sejour = new Sejour(
        $sejourData['date_debut'],
        $sejourData['date_fin'],
        $sejourData['motif'],
        $sejourData['soecialite_id'],
        $sejourData['medecin_id'],
        $sejourData['user_id']
    );

    $userId = 1; 

    $result = $this->sejourRepository->persist($sejour);
    $this->assertTrue($result);
    $this->assertNotNull($this->sejourRepository->findByUserId($userId));
}
}
