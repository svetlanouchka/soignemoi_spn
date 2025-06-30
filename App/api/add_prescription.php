<?php

require_once __DIR__ . '/../Db/Mysql.php';

use App\Db\Mysql;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }
    
    function checkField($fieldName, $data) {
        if (!isset($data[$fieldName]) || empty($data[$fieldName])) {
            error_log("$fieldName is missing or empty");
            return false;
        }
        return true;
    }
    
    $requiredFields = [
        'libelle',
        'date_prescription',
        'description',
        'medecin_id',
        'sejour_id',
        'medicament_id',
        'posologie',
        'date_debut',
        'date_fin'
    ];
    
    $missingFields = [];
    foreach ($requiredFields as $field) {
        if (!checkField($field, $data)) {
            $missingFields[] = $field;
        }
    }
    
    if (!empty($missingFields)) {
        echo json_encode(['error' => 'Tous les champs sont obligatoires.', 'missing_fields' => $missingFields]);
        exit;
    }
    

    echo json_encode(['success' => true, 'data' => $data]);

    
    error_log("Received data: " . print_r($data, true));

    
    $requiredFields = ['libelle', 'date_prescription', 'description', 'medecin_id', 'sejour_id', 'medicament_id', 'posologie', 'date_debut', 'date_fin'];
    $missingFields = [];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $missingFields[] = $field;
        } else {
            error_log("$field: " . $data[$field] . " (Type: " . gettype($data[$field]) . ")");
        }
    }

    if (empty($missingFields)) {
        $libelle = $data['libelle'];
        $datePrescription = $data['date_prescription'];
        $description = $data['description'];
        $medecinId = $data['medecin_id'];
        $sejourId = $data['sejour_id'];
        $medicamentId = $data['medicament_id'];
        $posologie = $data['posologie'];
        $dateDebut = $data['date_debut'];
        $dateFin = $data['date_fin'];

        try {
            $pdo = Mysql::getInstance()->getPDO();

            $pdo->beginTransaction();

            // Insérer la prescription
            $query = $pdo->prepare("INSERT INTO prescriptions (libelle, date_prescription, description, medecin_id, sejour_id) VALUES (:libelle, :date_prescription, :description, :medecin_id, :sejour_id)");
            $query->execute([
                ':libelle' => $libelle,
                ':date_prescription' => $datePrescription,
                ':description' => $description,
                ':medecin_id' => $medecinId,
                ':sejour_id' => $sejourId
            ]);

            $prescriptionId = $pdo->lastInsertId();

            // Insérer le médicament lié à la prescription
            $query = $pdo->prepare("INSERT INTO prescriptions_medicaments (prescription_id, medicament_id, posologie, date_debut, date_fin) VALUES (:prescription_id, :medicament_id, :posologie, :date_debut, :date_fin)");
            $query->execute([
                ':prescription_id' => $prescriptionId,
                ':medicament_id' => $medicamentId,
                ':posologie' => $posologie,
                ':date_debut' => $dateDebut,
                ':date_fin' => $dateFin
            ]);

            $pdo->commit();

            echo json_encode(['success' => true, 'message' => 'Prescription ajoutée avec succès.']);
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Exception: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        error_log("Missing fields in received data: " . implode(', ', $missingFields));
        http_response_code(400);
        echo json_encode(['error' => 'Tous les champs sont obligatoires.', 'missing_fields' => $missingFields]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée.']);
}
