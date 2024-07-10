<?php

require_once __DIR__ . '/../Db/Mysql.php';

use App\Db\Mysql;

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode(['error' => 'Méthode non autorisée']);
    http_response_code(405);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['prescription_id']) || !isset($data['medicament_id']) || !isset($data['new_date_fin'])) {
    echo json_encode(['error' => 'Tous les champs sont obligatoires.']);
    http_response_code(400);
    exit;
}

$prescription_id = $data['prescription_id'];
$medicament_id = $data['medicament_id'];
$new_date_fin = $data['new_date_fin'];

try {
    $pdo = Mysql::getInstance()->getPDO();
    $query = $pdo->prepare("UPDATE prescriptions_medicaments SET date_fin = :new_date_fin WHERE prescription_id = :prescription_id AND medicament_id = :medicament_id");
    $query->bindParam(':new_date_fin', $new_date_fin);
    $query->bindParam(':prescription_id', $prescription_id);
    $query->bindParam(':medicament_id', $medicament_id);

    if ($query->execute()) {
        echo json_encode(['success' => 'Date de fin mise à jour avec succès.']);
    } else {
        echo json_encode(['error' => 'Erreur lors de la mise à jour de la date de fin.']);
        http_response_code(500);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de base de données: ' . $e->getMessage()]);
    http_response_code(500);
}
?>
