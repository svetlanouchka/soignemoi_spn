<?php

require_once __DIR__ . '/../Db/Mysql.php';

use App\Db\Mysql;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['libelle'], $data['date_prescription'], $data['description'], $data['medecin_id'], $data['sejour_id'], $data['medicaments'])) {
        $libelle = $data['libelle'];
        $datePrescription = $data['date_prescription'];
        $description = $data['description'];
        $medecinId = $data['medecin_id'];
        $sejourId = $data['sejour_id'];
        $medicaments = $data['medicaments'];

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

            // Insérer les médicaments liés à la prescription
            foreach ($medicaments as $medicament) {
                if (isset($medicament['medicament_id'], $medicament['posologie'], $medicament['date_debut'], $medicament['date_fin'])) {
                    $query = $pdo->prepare("INSERT INTO prescriptions_medicaments (prescription_id, medicament_id, posologie, date_debut, date_fin) VALUES (:prescription_id, :medicament_id, :posologie, :date_debut, :date_fin)");
                    $query->execute([
                        ':prescription_id' => $prescriptionId,
                        ':medicament_id' => $medicament['medicament_id'],
                        ':posologie' => $medicament['posologie'],
                        ':date_debut' => $medicament['date_debut'],
                        ':date_fin' => $medicament['date_fin']
                    ]);
                } else {
                    throw new Exception('Les informations sur les médicaments sont incomplètes.');
                }
            }

            $pdo->commit();

            echo json_encode(['message' => 'Prescription ajoutée avec succès.']);
        } catch (Exception $e) {
            $pdo->rollBack();
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Tous les champs sont obligatoires.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée.']);
}
