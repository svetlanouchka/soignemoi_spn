<?php
require 'vendor/autoload.php';

use App\Db\Mysql;
use App\Repository\UserRepository;

$mysql = Mysql::getInstance();
$userRepository = new UserRepository($mysql);

echo "Autoloading works!";
