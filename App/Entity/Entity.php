<?php

namespace App\Entity;

use App\Tools\StringTools;
use DateTime;
use Exception;


class Entity
{

    public static function createAndHydrate(array $data): static
    {
        // Ici static fait référence à la classe de l'enfant, alors que self fait référence à la classe courante
        $entity = new static();
        $entity->hydrate($data);
        return $entity;
    }

    public function hydrate(array $data)
    {
        if (count($data) > 0) {
            // On parcourt le tableau de données
            foreach ($data as $key => $value) {
                // Convert date strings to DateTime objects for specific keys
                if (in_array($key, ['date_debut', 'date_fin'])) {
                    try {
                        $value = new DateTime($value);
                    } catch (Exception $e) {
                        // Handle exception if needed, e.g., log an error or throw a custom exception
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