<?php
require_once __DIR__ .'/../Db/MongoService.php';

// Récupérer les données de la requête
$requestData = json_decode(file_get_contents('php://input'), true); // Récupérer les données JSON envoyées par POST
error_log('Données reçues:');
error_log(print_r($requestData, true));
// Vérifier si les données nécessaires sont présentes
if (!isset($requestData['libelle'], $requestData['date_avis'], $requestData['description'], $requestData['medecin_id'], $requestData['medecin_nom'], $requestData['medecin_prenom'], $requestData['sejour_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Tous les champs sont obligatoires.']);
    exit;
}

// Extraire les données
$libelle = $requestData['libelle'];
$date_avis = $requestData['date_avis'];
$description = $requestData['description'];
$medecinId = $requestData['medecin_id'];
$medecinNom = $requestData['medecin_nom'];
$medecinPrenom = $requestData['medecin_prenom'];
$sejourId = $requestData['sejour_id'];

// error_log('Données extraites:');
// error_log("libelle: $libelle, date_avis: $date_avis, description: $description, medecin_id: $medecinId, sejour_id: $sejourId");

try {
    $mongo = new App\Db\MongoService();
    $collection = $mongo->getDb()->avis;

    $result = $collection->insertOne([
        'libelle' => $libelle,
        'date_avis' => $date_avis,
        'description' => $description,
        'medecin' => [
            'id' => $medecinId,
            'nom' => $medecinNom,
            'prenom' => $medecinPrenom
        ],
        'sejour_id' => $sejourId
    ]);

    // Répondre avec un message de succès
    http_response_code(201);
    echo json_encode(['success' => true, 'message' => 'Avis ajouté avec succès.', 'inserted_id' => (string) $result->getInsertedId()]);

} catch (PDOException $e) {
    // En cas d'erreur, répondre avec un message d'erreur
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de l\'ajout de l\'avis: ' . $e->getMessage()]);
}
