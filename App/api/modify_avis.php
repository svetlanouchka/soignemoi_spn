<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Db/MongoService.php';

use MongoDB\BSON\ObjectId as MongoObjectId;

$requestData = json_decode(file_get_contents('php://input'), true);

if (!isset($requestData['id'], $requestData['libelle'], $requestData['date_avis'], $requestData['description'], $requestData['medecin_id'], $requestData['medecin_nom'], $requestData['medecin_prenom'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Données incomplètes.']);
    exit;
}

$mongo = new \App\Db\MongoService();
$collection = $mongo->getDb()->avis;

$avis = $collection->findOne(['_id' => new MongoObjectId($requestData['id'])]);

if (!$avis || $avis['medecin']['id'] != $requestData['medecin_id']) {
    http_response_code(403);
    echo json_encode(['error' => 'Modification non autorisée.']);
    exit;
}

$updateResult = $collection->updateOne(
    ['_id' => new MongoObjectId($requestData['id'])],
    ['$set' => [
        'libelle' => $requestData['libelle'],
        'date_avis' => $requestData['date_avis'],
        'description' => $requestData['description']
    ]]
);

echo json_encode(['success' => true, 'message' => 'Avis mis à jour avec succès.']);
