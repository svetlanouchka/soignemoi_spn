<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Db\Mysql;
use App\Repository\UserRepository;
use App\Entity\User;

class UserTest extends TestCase
{
    protected $userRepository; 

    protected function setUp(): void
    {
        $mysql = Mysql::getInstance();
        $this->userRepository = new UserRepository($mysql);
    }

    public function testCreateUser()
    {
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'securepassword123',
            'address' => '123 rue Test '
        ];

        $user = new User(
            $userData['first_name'],
            $userData['last_name'],
            $userData['email'],
            $userData['password'],
            $userData['address']
        );

        $result = $this->userRepository->persist($user);
        $this->assertTrue($result);

        $retrievedUser = $this->userRepository->findByEmail($userData['email']);
        $this->assertNotNull($retrievedUser);
        $this->assertEquals($userData['email'], $retrievedUser->getEmail());
}
}
