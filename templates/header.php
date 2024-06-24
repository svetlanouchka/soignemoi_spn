<?php

use App\Entity\User;
use App\Tools\NavigationTools;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/override-bootstrap.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <title>Soigne Moi</title>
</head>
<body>

<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <div class="col-md-3 mb-2 mb-md-0">
        <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
        <img width="120" src="assets/images/Soigne moi (2).png" alt="">
        </a>
        </div>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/" class="nav-link px-2 link-secondary" <?= NavigationTools::addActiveClass('page', 'home') ?>>Accueil</a></li>
        <?php if (User::isLogged()){ ?>
            <li><a href="http://localhost/studi_ecf/soignemoi_spn/index.php?controller=sejour&action=create" class="nav-link px-2" <?= NavigationTools::addActiveClass('sejour', 'create') ?>>Créer le séjour</a></li>
        <?php } else { ?>
            <li><a href="http://localhost/studi_ecf/soignemoi_spn/index.php?controller=auth&action=login" class="nav-link px-2" <?= NavigationTools::addActiveClass('auth', 'login') ?>>Créer le séjour</a></li>
        <?php } ?>
        <li><a href="#" class="nav-link px-2">Espace admin</a></li>
        <li><a href="#" class="nav-link px-2">A propos</a></li>
        </ul>

        <div class="col-md-3 text-end">
                <?php if (User::isLogged()) { ?>
                    <a href="/index.php?controller=auth&action=logout" class="btn btn-primary">Déconnexion</a>
                <?php } else { ?>
                    <a href="http://localhost/studi_ecf/soignemoi_spn/index.php?controller=auth&action=login" class="btn btn-outline-primary me-2 <?= NavigationTools::addActiveClass('auth', 'login') ?>">Connexion</a>
                    <a href="http://localhost/studi_ecf/soignemoi_spn/index.php?controller=auth&action=register" class="btn btn-outline-primary me-2 <?= NavigationTools::addActiveClass('user', 'register') ?>">Créer un compte</a>
                <?php } ?>
            </div>
    </div>
    </header>

<main>