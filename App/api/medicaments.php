<?php
require_once __DIR__ . '/../Db/Mysql.php';

use App\Db\Mysql;

header('Content-Type: application/json');

try {
    // Obtenir une instance de PDO
    $pdo = Mysql::getInstance()->getPDO();
    
    // Préparer et exécuter la requête SQL pour récupérer tous les médicaments
    $query = $pdo->query("SELECT id, nom FROM medicaments");
    $medicaments = $query->fetchAll(PDO::FETCH_ASSOC);
    
    // Vérifier si des médicaments ont été trouvés
    if ($medicaments) {
        // Répondre avec la liste des médicaments en format JSON
        echo json_encode($medicaments);
    } else {
        // Répondre avec un message d'erreur si aucun médicament n'est trouvé
        http_response_code(404);
        echo json_encode(['error' => 'Aucun médicament trouvé']);
    }
} catch (PDOException $e) {
    // En cas d'erreur, répondre avec un message d'erreur
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la récupération des médicaments: ' . $e->getMessage()]);
}
