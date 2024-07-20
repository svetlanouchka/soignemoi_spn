<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

use App\Db\Mysql;

require_once '../Db/Mysql.php';

// Récupérer les IDs depuis la requête GET
$sejour_id = isset($_GET['sejour_id']) ? $_GET['sejour_id'] : die(json_encode(["message" => "Sejour ID not provided"]));
$medecin_id = isset($_GET['medecin_id']) ? $_GET['medecin_id'] : die(json_encode(["message" => "Medecin ID not provided"]));

// Connexion à la base de données via la classe Mysql
try {
$mysql = Mysql::getInstance();
$pdo = $mysql->getPDO();
} catch (PDOException $exception) {
die("Erreur de connexion : " . $exception->getMessage());
}

// Requête SQL pour récupérer les détails du séjour
$query = $pdo->prepare("SELECT s.*, sp.name AS specialite_name, u.nom AS user_nom, u.prenom AS user_prenom
FROM sejours s
LEFT JOIN specialites sp ON s.specialite_id = sp.id
LEFT JOIN user u ON s.user_id = u.id
WHERE s.id = :sejour_id
AND s.medecin_id = :medecin_id");
$query->bindParam('sejour_id', $sejour_id, PDO::PARAM_INT);
$query->bindParam('medecin_id', $medecin_id, PDO::PARAM_INT);
$query->execute();
$sejourData = $query->fetch(PDO::FETCH_ASSOC);

if (!$sejourData) {
echo json_encode(["message" => "Séjour non trouvé"]);
exit;
}

// Requête SQL pour récupérer les avis du séjour
$avisQuery = $pdo->prepare("SELECT a.* FROM avis a WHERE a.sejour_id = :sejour_id");
$avisQuery->bindParam('sejour_id', $sejour_id, PDO::PARAM_INT);
$avisQuery->execute();
$avisData = $avisQuery->fetchAll(PDO::FETCH_ASSOC);

// Requête SQL pour récupérer les prescriptions du séjour
$prescriptionsQuery = $pdo->prepare("
SELECT p.*, pm.posologie, pm.date_debut, pm.date_fin
FROM prescriptions p
LEFT JOIN prescriptions_medicaments pm ON p.id = pm.prescription_id
LEFT JOIN medicaments m ON pm.medicament_id = m.id
WHERE p.sejour_id = :sejour_id");
$prescriptionsQuery->bindParam('sejour_id', $sejour_id, PDO::PARAM_INT);
$prescriptionsQuery->execute();
$prescriptionsData = $prescriptionsQuery->fetchAll(PDO::FETCH_ASSOC);
$prescriptions = [];
foreach ($prescriptionsData as $prescriptionData) {
    // Requête SQL pour récupérer les médicaments de la prescription
    $medicamentsQuery = $pdo->prepare("SELECT pm.*, m.nom AS medicament_nom 
                                        FROM prescriptions_medicaments pm
                                        LEFT JOIN medicaments m ON pm.medicament_id = m.id
                                        WHERE pm.prescription_id = :prescription_id");
    $medicamentsQuery->bindParam(':prescription_id', $prescriptionData['id'], PDO::PARAM_INT);
    $medicamentsQuery->execute();
    $medicamentsData = $medicamentsQuery->fetchAll(PDO::FETCH_ASSOC);

    $prescription = [
        "id" => $prescriptionData['id'],
        "libelle" => $prescriptionData['libelle'],
        "date_prescription" => $prescriptionData['date_prescription'],
        "description" => $prescriptionData['description'],
        "medecin_id" => $prescriptionData['medecin_id'],
        "sejour_id" => $prescriptionData['sejour_id'],
        "medicaments" => $medicamentsData
    ];
    $prescriptions[] = $prescription;
}
// Créer un tableau associatif pour le séjour avec les avis et les prescriptions
$sejourDetails = [
"id" => $sejourData['id'],
"date_debut" => $sejourData['date_debut'],
"date_fin" => $sejourData['date_fin'],
"motif" => $sejourData['motif'],
"specialite_id" => $sejourData['specialite_id'],
"specialite_name" => $sejourData['specialite_name'],
"user_nom" => $sejourData['user_nom'],
"user_prenom" => $sejourData['user_prenom'],
"avis" => $avisData,
"prescriptions" => $prescriptions
];

// Retourner les détails du séjour en JSON
echo json_encode($sejourDetails);

?>