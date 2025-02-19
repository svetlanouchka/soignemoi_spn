<?php
$dsn = "mysql:host=127.0.0.1;dbname=soignemoi_spn;charset=utf8mb4";
$user = "root";
$password = "Openeyes088!";


try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

trigger_error("Test error logging", E_USER_NOTICE);