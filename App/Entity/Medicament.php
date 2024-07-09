<?php

namespace App\Entity;

class Medicament extends Entity
{
    protected ?int $id = null;
    protected string $nom;
    protected string $description;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function validate(): array
    {
        $errors = [];
        if (empty($this->nom)) {
            $errors[] = "Le nom est obligatoire";
        }
        if (empty($this->description)) {
            $errors[] = "La description est obligatoire";
        }
        return $errors;
    }
}