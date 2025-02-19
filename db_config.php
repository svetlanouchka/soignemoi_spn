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
    // Configuration de la base de données de production
    $dbConfig = [
        'db_name' => 'soignemoi_spn',
        'db_user' => 'root',
        'db_password' => 'Openeyes088!',
        'db_port' => '3306',
        'db_host' => '127.0.0.1'
    ];
}

// Retourne la configuration
return $dbConfig;

// try {
//     $host = getenv('DB_HOST') ?: '127.0.0.1';
//     $port = getenv('DB_PORT') ?: '3306';
//     $db_name = getenv('DB_NAME') ?: 'soignemoi_spn';
//     $db_user = getenv('DB_USER') ?: 'root';
//     $db_password = getenv('DB_PASSWORD') ?: 'Openeyes088!';
//     // $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db_name;charset=utf8mb4", $db_user, $db_password);
//     // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     // echo "Connexion réussie !";
// } catch (PDOException $e) {
//     echo "Erreur de connexion : " . $e->getMessage();
//     error_log("PDO Error: " . $e->getMessage());
// }
        


// if ($env === 'test') {
//     $dbConfig = [
//         'db_name' => getenv('DB_NAME'),
//         'db_user' => getenv('DB_USER'),
//         'db_password' => getenv('DB_PASSWORD'),
//         'db_host' => getenv('DB_HOST'),
//         'db_port' => getenv('DB_PORT')
//     ];
// } else {
//     // Configuration de la base de données de production*/
//     $dbConfig = [
//         'db_name' => 'soignemoi_spn',
//         'db_user' => 'root',
//         'db_password' => 'Openeyes088!',
//         'db_port' => '3306',
//         'db_host' => '127.0.0.1'
//         // 'db_host' => '192.168.1.105'
//     ];
// }
