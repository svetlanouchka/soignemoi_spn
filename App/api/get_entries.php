<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

use App\Db\Mysql;

require_once '../Db/Mysql.php';

// Connexion à la base de données via la classe Mysql
try {
    $mysql = Mysql::getInstance();
    $pdo = $mysql->getPDO();
} catch (PDOException $exception) {
    die("Erreur de connexion : " . $exception->getMessage());
}

// Récupérer la date d'aujourd'hui
$date_today = date('Y-m-d');

// Requête SQL pour récupérer les patients qui commencent leur séjour aujourd'hui
$query = $pdo->prepare("SELECT u.id AS user_id, u.prenom, u.nom
                        FROM sejours s
                        JOIN user u ON s.user_id = u.id
                        WHERE s.date_debut = :date_today");
$query->bindParam(':date_today', $date_today, PDO::PARAM_STR);
$query->execute();
$patientsStartToday = $query->fetchAll(PDO::FETCH_ASSOC);

// Retourner les patients en JSON
echo json_encode($patientsStartToday);
?>
