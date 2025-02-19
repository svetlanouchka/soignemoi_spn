<?php
require 'vendor/autoload.php';

use MongoDB\Client;

try {
    $client = new Client("mongodb://localhost:27017");
    $db = $client->soignemoiDB;
    echo "Connexion réussie à MongoDB!";
} catch (Exception $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
