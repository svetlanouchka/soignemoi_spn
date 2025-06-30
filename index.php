<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

// Sécurise le cookie de session avec httponly
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'domain' => $_SERVER['SERVER_NAME'],
    'httponly' => true
]);
session_start();

define('_ROOTPATH_', __DIR__);

// Fonction d'autoloading
function my_autoload($class)
{
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register('my_autoload');

use App\Controller\Controller;

// Pas de redirection, on charge la page d'accueil dans tous les cas
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id']; // Accessible si connecté
} else {
    // Pas d'echo ni de redirection, on continue simplement
    $user_id = null; // Ou toute autre valeur par défaut si nécessaire
}

$controller = new Controller();
$controller->route();
