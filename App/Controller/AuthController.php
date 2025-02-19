<?php

namespace App\Controller;

use App\Db\Mysql;
use App\Repository\UserRepository;

class AuthController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'login':
                        $this->login();
                        break;
                    case 'logout':
                        $this->logout();
                        break;
                    default:
                        throw new \Exception("Cette action n'existe pas : " . $_GET['action']);
                }
            } else {
                throw new \Exception("Aucune action détectée");
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }


    protected function login()
    {
        $errors = [];

        var_dump($_POST); 

        if (isset($_POST['loginUser'])) {

            $userRepository = new UserRepository();

            $user = $userRepository->findOneByEmail($_POST['email']);

            if ($user) {
                var_dump($user); // Vérifier si l'utilisateur est trouvé
            } else {
                echo "Aucun utilisateur trouvé avec cet email.";
            }

            if ($user && $user->verifyPassword($_POST['password'])) {
                // Regénère l'id session pour éviter la fixation de session
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'adress' => $user->getAdress(),
                    'prenom' => $user->getPrenom(),
                    'nom' => $user->getNom(),
                    'role' => $user->getRole(),
                ];
                header('location: index.php');
            } else {
                $errors[] = 'Email ou mot de passe incorrect';
                var_dump($errors);
            }
        }

        $this->render('auth/login', [
            'errors' => $errors,
        ]);
    }

    /*protected function login()
    {
        try {
            $errors = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') 

            // Récupération des données POST
            $data = json_decode(file_get_contents('php://input'), true);

            $userRepository = new UserRepository();
            $user = $userRepository->findOneByEmail($data['email']);

            if ($user && $user->verifyPassword($data['password'])) {
                // Regénère l'id de session pour éviter la fixation de session
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'adress' => $user->getAdress(),
                    'prenom' => $user->getPrenom(),
                    'nom' => $user->getNom(),
                    'role' => $user->getRole(),
                ];

                // Réponse JSON de succès
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Connexion réussie']);
                exit;
            } else {
                // Réponse JSON d'échec
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
                exit;
            }
        } catch (\Exception $e) {
            // Réponse JSON d'erreur
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }
    }*/


    protected function logout()
    {
        //Prévient les attaques de fixation de session
        session_regenerate_id(true);
        //Supprime les données de session du serveur
        session_destroy();
        //Supprime les données du tableau $_SESSION
        unset($_SESSION);
        header ('location: index.php?controller=auth&action=login');
    }
}