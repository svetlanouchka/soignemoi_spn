<?php

namespace App\Entity;

require_once __DIR__ . '/../Tools/StringTools.php';

use App\Tools\StringTools;
use DateTime;
use Exception;


class Entity
{

    public static function createAndHydrate(array $data): static
    {
        $entity = new static();
        $entity->hydrate($data);
        return $entity;
    }

    public function hydrate(array $data)
    {
        if (count($data) > 0) {
            // On parcourt le tableau de données
            foreach ($data as $key => $value) {
                if (in_array($key, ['date_debut', 'date_fin'])) {
                    try {
                        $value = new DateTime($value);
                    } catch (Exception $e) {
                    }
                }
                
                // Pour chaque donnée, on appel le setter
                $methodName = 'set' . StringTools::toPascalCase($key);
                if (method_exists($this, $methodName)) {
                    $this->{$methodName}($value);
                }
            }
        }
    }

    /*public function hydrate(array $data)
    {
        if (count($data) > 0) {
            // On parcourt le tableau de données
            foreach ($data as $key => $value) {
                // Pour chaque donnée, on appel le setter
                $methodName = 'set' . StringTools::toPascalCase($key);
                if (method_exists($this, $methodName)) {
                    $this->{$methodName}($value);
                }
            }
        }
    }*/
}