<?php

namespace App\Entity;

use DateTime;

class Sejour extends Entity
{

    protected ?int $id = null;
    protected DateTime $date_debut;
    protected DateTime $date_fin;
    protected ?string $motif = '';
    protected ?int $specialite_id; 
    protected ?int $medecin_id;
    protected ?int $user_id = null;

    protected ?Specialite $specialite = null;
    protected ?Medecin $medecin = null;
    
    public function __construct()
    {
        // Initialisation des propriétés par défaut
        $this->date_debut = new DateTime();
        $this->date_fin = new DateTime();
        $this->motif = '';
        $this->specialite_id = 0;
        $this->medecin_id = 0;
    }

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
     * Get the value of date_debut
     */ 
    public function getDate_debut() : DateTime
    {
        return $this->date_debut;
    }

    /**
     * Set the value of date_debut
     *
     * @return  self
     */ 
    public function setDate_debut(DateTime $date_debut) : self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    /**
     * Get the value of date_fin
     */ 
    public function getDate_fin() : DateTime
    {
        return $this->date_fin;
    }

    /**
     * Set the value of date_fin
     *
     * @return  self
     */ 
    public function setDate_fin(DateTime $date_fin) : self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    /**
     * Get the value of motif
     */ 
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set the value of motif
     *
     * @return  self
     */ 
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get the value of specialite
     */ 
    public function getSpecialite_id()
    {
        return $this->specialite_id;
    }

    /**
     * Set the value of specialite
     *
     * @return  self
     */ 
    public function setSpecialite_id($specialite)
    {
        $this->specialite_id = $specialite;

        return $this;
    }

        /**
     * Get the value of medecin_id
     */ 
    public function getMedecin_id()
    {
        return $this->medecin_id;
    }

    /**
     * Set the value of medecin_id
     *
     * @return  self
     */ 
    public function setMedecin_id($medecin_id)
    {
        $this->medecin_id = $medecin_id;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function setSpecialite(Specialite $specialite): self
    {
        $this->specialite = $specialite;
        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setMedecin(Medecin $medecin): self
    {
        $this->medecin = $medecin;
        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function validate(): array
    {
        $errors = [];
        if (empty($this->getDate_debut())) {
            $errors['date_debut'] = 'Le champ date de début ne doit pas être vide';
        }
        if (empty($this->getDate_fin())) {
            $errors['date_fin'] = 'Le champ date de fin ne doit pas être vide';
        }
        if (empty($this->getMotif())) {
            $errors['motif'] = 'Le champ motif ne doit pas être vide';
        } 
        if (empty($this->getSpecialite_id())) {
            $errors['specialite_id'] = 'Le champ specialite ne doit pas être vide';
        }
        if (empty($this->getMedecin_id())) {
            $errors['medecin_id'] = 'Le champ médecin ne doit pas être vide';
        }
        return $errors;
    }


}