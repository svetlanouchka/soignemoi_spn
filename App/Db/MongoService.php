<?php
namespace App\Db;

use MongoDB\Client;

class MongoService {
    protected $client;
    protected $db;

    public function __construct() {
        $this->client = new Client("mongodb://localhost:27017");
        $this->db = $this->client->soignemoiDB;
    }

    public function getStatistics() {
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