<?php
require_once __DIR__.'/config.php';

// Sécurise le cookie de session avec httponly
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'domain' => $_SERVER['SERVER_NAME'],
    'httponly' => true
]);
session_start();

// Vérifiez si la session est démarrée
if (!isset($_SESSION)) {
    echo "Session n'est pas démarrée.";
}

if (!isset($_SESSION['user'])) {
    echo "Utilisateur non connecté.";
} else {
    $user_id = $_SESSION['user']['id'];
}

define('_ROOTPATH_', __DIR__);

spl_autoload_register();

use App\Controller\Controller;
// Nous avons besoin de cette classe pour verifier si l'utilisateur est connecté
use App\Entity\User;


$controller = new Controller();
$controller->route();


