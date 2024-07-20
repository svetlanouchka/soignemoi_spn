<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

use App\Db\Mysql;

require_once '../Db/Mysql.php';

// Vérifier si l'ID du patient est fourni dans la requête GET
if (!isset($_GET['user_id'])) {
    http_response_code(400);
    echo json_encode(["message" => "User ID not provided"]);
    exit;
}

// Récupérer l'ID du patient depuis la requête GET
$user_id = $_GET['user_id'];

// Connexion à la base de données via la classe Mysql
try {
    $mysql = Mysql::getInstance();
    $pdo = $mysql->getPDO();
} catch (PDOException $exception) {
    die("Erreur de connexion : " . $exception->getMessage());
}

// Requête SQL pour récupérer les détails du dossier du patient
$query = $pdo->prepare("SELECT u.prenom, u.nom, s.date_debut, s.date_fin, s.motif,
                                p.libelle AS prescription_libelle, p.description AS prescription_description,
                                a.libelle AS avis_libelle, a.date_avis AS avis_date_avis, a.description AS avis_description
                        FROM user u
                        LEFT JOIN sejours s ON u.id = s.user_id
                        LEFT JOIN prescriptions p ON s.id = p.sejour_id
                        LEFT JOIN avis a ON s.id = a.sejour_id
                        WHERE u.id = :user_id");
$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$query->execute();
$patientDetails = $query->fetchAll(PDO::FETCH_ASSOC);

// Formater les résultats pour les prescriptions et les avis
$formattedDetails = [];
foreach ($patientDetails as $detail) {
    $patientName = $detail['prenom'] . ' ' . $detail['nom'];
    if (!isset($formattedDetails[$patientName])) {
        $formattedDetails[$patientName] = [
            'nom' => $detail['prenom'],
            'prenom' => $detail['nom'],
            'sejours' => [],
            'prescriptions' => [],
            'avis' => []
        ];
    }

    if ($detail['date_debut'] && $detail['date_fin']) {
        $formattedDetails[$patientName]['sejours'][] = [
            'date_debut' => $detail['date_debut'],
            'date_fin' => $detail['date_fin'],
            'motif' => $detail['motif']
        ];
    }

    if ($detail['prescription_libelle'] && $detail['prescription_description']) {
        $formattedDetails[$patientName]['prescriptions'][] = [
            'libelle' => $detail['prescription_libelle'],
            'description' => $detail['prescription_description']
        ];
    }

    if ($detail['avis_libelle'] && $detail['avis_date_avis'] && $detail['avis_description']) {
        $formattedDetails[$patientName]['avis'][] = [
            'libelle' => $detail['avis_libelle'],
            'date_avis' => $detail['avis_date_avis'],
            'description' => $detail['avis_description']
        ];
    }
}

// Retourner les détails formatés en JSON
echo json_encode($formattedDetails);
?>
