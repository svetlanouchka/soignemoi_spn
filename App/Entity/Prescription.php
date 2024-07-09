<?php

namespace App\Entity;
use DateTime;
class Prescription extends Entity
{
    protected ?int $id = null;
    protected string $libelle;
    protected DateTime $date_prescription;
    protected string $description;
    protected int $medecin_id = null;
    protected int $sejour_id = null;

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
     * Get the value of libelle
     */ 
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set the value of libelle
     *
     * @return  self
     */ 
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get the value of date_prescription
     */ 
    public function getDate_prescription()
    {
        return $this->date_prescription;
    }

    /**
     * Set the value of date_prescription
     *
     * @return  self
     */ 
    public function setDateprescription($date_prescription)
    {
        $this->date_prescription = $date_prescription;

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
     * Get the value of sejour_id
     */ 
    public function getSejour_id()
    {
        return $this->sejour_id;
    }

    /**
     * Set the value of sejour_id
     *
     * @return  self
     */ 
    public function setSejour_id($sejour_id)
    {
        $this->sejour_id = $sejour_id;

        return $this;
    }

    public function validate(): array
    {
        $errors = [];
        if (empty($this->libelle)) {
            $errors[] = "Le libellé ne peut pas être vide";
        }
        if (empty($this->date_prescription)) {
            $errors[] = "La date de prescription ne peut pas être vide";
        }
        if (empty($this->description)) {
            $errors[] = "La description ne peut pas être vide";
        }
        if (empty($this->medecin_id)) {
            $errors[] = "Le médecin ne peut pas être vide";
        }
        if (empty($this->sejour_id)) {
            $errors[] = "Le séjour ne peut pas être vide";
        }
        return $errors;
    }
} 