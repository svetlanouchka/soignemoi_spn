<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$env = getenv('APP_ENV') ?: 'production';

if ($env === 'test') {
    $dbConfig = [
        'db_name' => getenv('DB_NAME'),
        'db_user' => getenv('DB_USER'),
        'db_password' => getenv('DB_PASSWORD'),
        'db_host' => getenv('DB_HOST'),
        'db_port' => getenv('DB_PORT')
    ];
} else {
    // Configuration de la base de données de production*/
    $dbConfig = [
        'db_name' => 'soignemoi_spn',
        'db_user' => 'root',
        'db_password' => 'Openeyes088!',
        'db_port' => '3306',
        'db_host' => '192.168.1.105'
    ];
}
