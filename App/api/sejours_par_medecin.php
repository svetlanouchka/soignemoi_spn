<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

use App\Db\Mysql;

require_once '../Db/Mysql.php';

// Récupérer l'ID du médecin depuis la requête GET
$medecin_id = isset($_GET['medecin_id']) ? $_GET['medecin_id'] : die(json_encode(["message" => "Medecin ID not provided"]));

// Connexion à la base de données via la classe Mysql
try {
    $mysql = Mysql::getInstance();
    $pdo = $mysql->getPDO();
} catch (PDOException $exception) {
    die("Erreur de connexion : " . $exception->getMessage());
}

// Requête SQL pour récupérer les séjours du médecin
$query = $pdo->prepare("SELECT s.*, sp.name AS specialite_name, u.nom AS user_nom, u.prenom AS user_prenom
            FROM sejours s
            LEFT JOIN specialites sp ON s.specialite_id = sp.id
            LEFT JOIN user u ON s.user_id = u.id
            WHERE s.medecin_id = :medecin_id");
$query->bindParam(':medecin_id', $medecin_id, PDO::PARAM_INT);
$query->execute();
$sejoursData = $query->fetchAll(PDO::FETCH_ASSOC);

$sejours = [];
foreach ($sejoursData as $sejourData) {
    $avisQuery = $pdo->prepare("SELECT * FROM avis WHERE sejour_id = :sejour_id");
    $avisQuery->bindParam(':sejour_id', $sejourData['id'], PDO::PARAM_INT);
    $avisQuery->execute();
    $avisData = $avisQuery->fetchAll(PDO::FETCH_ASSOC);

    // Requête pour récupérer les prescriptions du séjour
    $prescriptionsQuery = $pdo->prepare("SELECT p.*, m.nom AS medicament_nom
                                        FROM prescriptions p
                                        LEFT JOIN prescriptions_medicaments pm ON p.id = pm.prescription_id
                                        LEFT JOIN medicaments m ON pm.medicament_id = m.id
                                        WHERE p.sejour_id = :sejour_id");
    $prescriptionsQuery->bindParam(':sejour_id', $sejourData['id'], PDO::PARAM_INT);
    $prescriptionsQuery->execute();
    $prescriptionsData = $prescriptionsQuery->fetchAll(PDO::FETCH_ASSOC);

    // Créer un tableau associatif pour chaque séjour
    $sejour = [
        "id" => $sejourData['id'],
        "date_debut" => $sejourData['date_debut'],
        "date_fin" => $sejourData['date_fin'],
        "motif" => $sejourData['motif'],
        "specialite_id" => $sejourData['specialite_id'],
        "user_nom" => $sejourData['user_nom'],
        "user_prenom" => $sejourData['user_prenom'],
        "avis" => $avisData,
        "prescriptions" => $prescriptionsData
        // Ajoutez d'autres champs si nécessaire
    ];
    $sejours[] = $sejour;
}

// Retourner les séjours en JSON
echo json_encode($sejours);

?>
