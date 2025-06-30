<?php

namespace App\Db;

require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\Client;

class MongoService
{
    protected $client;
    protected $db;

    public function __construct()
    {
        try {
            
            $mongoHost = getenv('MONGO_HOST') ?: 'localhost';
            $mongoPort = getenv('MONGO_PORT') ?: 27017;
            $mongoUser = getenv('MONGO_USER') ?: 'soignemoi_user';
            $mongoPassword = getenv('MONGO_PASSWORD') ?: 'spn_2025!';
            $mongoDbName = getenv('MONGO_DB_NAME') ?: 'soignemoiDB';


            if ($mongoUser && $mongoPassword) {
                $uri = sprintf(
                    'mongodb://%s:%s@%s:%d',
                    urlencode($mongoUser),
                    urlencode($mongoPassword),
                    $mongoHost,
                    $mongoPort
                );
            } else {
                $uri = sprintf('mongodb://%s:%d', $mongoHost, $mongoPort);
            }

            $this->client = new Client($uri, [
                'ssl' => false, // Pas de SSL pour localhost
            ]);
            $this->db = $this->client->$mongoDbName;
            $this->client->listDatabases();
            error_log("Connexion MongoDB réussie !");
        } catch (\Exception $e) {
            error_log("Erreur MongoDB : " . $e->getMessage());
            throw $e;
        }
    }

    public function getDb()
    {
        return $this->db;
    }

    public function getStatistics()
    {
        $collection = $this->db->statistics;
        $data = $collection->find()->toArray();

        if (empty($data)) {
            $sampleSejours = [
                [
                    "specialite" => "Cardiologie",
                    "total_sejours" => 25
                ],
                [
                    "specialite" => "Dermatologie",
                    "total_sejours" => 15
                ],
                [
                    "specialite" => "Gynecologie",
                    "total_sejours" => 10
                ],
                [
                    "specialite" => "Pediatrie",
                    "total_sejours" => 20
                ],
            ];
            $collection->insertMany($sampleSejours);
            $data = $collection->find()->toArray();
        }

        $sejoursArray = [];
        foreach ($data as $doc) {
            $sejoursArray[] = json_decode(json_encode($doc), true);
        }

        $patientsPerMonth = [
            "Janvier" => 50,
            "Fevrier" => 43,
            "Mars" => 53,
        ];

        return [
            "sejoursParSpecialite" => $sejoursArray,
            "patientsParMois" => $patientsPerMonth
        ];
    }
}
