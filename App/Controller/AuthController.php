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

        if (isset($_POST['loginUser'])) {
            $userRepository = new UserRepository();
            $user = $userRepository->findOneByEmail($_POST['email']);

            if ($user && $user->verifyPassword($_POST['password'])) {

                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'adress' => $user->getAdress(),
                    'prenom' => $user->getPrenom(),
                    'nom' => $user->getNom(),
                    'role' => $user->getRole(),
                ];

                header('Location: index.php');
                exit; 
            } else {
                $errors[] = 'Email ou mot de passe incorrect';
            }
        }


        $this->render('auth/login', [
            'errors' => $errors,
        ]);
    }

    protected function logout()
    {
        session_regenerate_id(true);
        session_destroy();
        unset($_SESSION);
        header('Location: index.php?controller=auth&action=login');
        exit; 
    }
}
