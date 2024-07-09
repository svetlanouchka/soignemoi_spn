<?php

require_once __DIR__ . '/App/Repository/UserRepository.php';
require_once __DIR__ . '/App/Db/Mysql.php';

use App\Repository\UserRepository;
use Exception;
use App\Db\Mysql;

// Définir l'en-tête de réponse JSON
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
        exit;
    }

    // Récupération des données POST
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        throw new Exception("Invalid JSON data received");
    }

    // Validation des données
    if (empty($data['email']) || empty($data['password'])) {
        throw new Exception("Email et mot de passe sont requis");
    }

    $userRepository = new UserRepository();
    $user = $userRepository->findOneByEmail($data['email']);

    if ($user && $user->verifyPassword($data['password'])) {
        // Génération de la réponse de succès
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Connexion réussie',
            'data' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'prenom' => $user->getPrenom(),
                'nom' => $user->getNom(),
                'role' => $user->getRole(),
            ]
        ]);
        exit;
    } else {
        // Génération de la réponse d'échec
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
        exit;
    }
} catch (Exception $e) {
    // Génération de la réponse d'erreur
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}
?>
