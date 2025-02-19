<?php
require_once 'C:/xampp/htdocs/studi_ecf/soignemoi_spn/vendor/autoload.php';
require_once __DIR__ . '/../Db/MongoService.php';

$requestData = json_decode(file_get_contents('php://input'), true);

if (!isset($requestData['id'], $requestData['medecin_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Données incomplètes.']);
    exit;
}

$mongo = new \App\Db\MongoService();
$collection = $mongo->db->avis;

$avis = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($requestData['id'])]);

if (!$avis || $avis['medecin']['id'] != $requestData['medecin_id']) {
    http_response_code(403);
    echo json_encode(['error' => 'Suppression non autorisée.']);
    exit;
}

$collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($requestData['id'])]);

echo json_encode(['success' => true, 'message' => 'Avis supprimé avec succès.']);
