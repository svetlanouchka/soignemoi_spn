<?php

namespace App\Entity;
use DateTime;

class PrescriptionMedicament extends Entity
{
    protected ?int $id = null;
    protected int $prescription_id;
    protected int $medicament_id;

    protected string $posologie;

    protected DateTime $datedebut;

    protected DateTime $datefin;

    

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
     * Get the value of prescription_id
     */ 
    public function getPrescription_id()
    {
        return $this->prescription_id;
    }

    /**
     * Set the value of prescription_id
     *
     * @return  self
     */ 
    public function setPrescription_id($prescription_id)
    {
        $this->prescription_id = $prescription_id;

        return $this;
    }

    /**
     * Get the value of medicament_id
     */ 
    public function getMedicament_id()
    {
        return $this->medicament_id;
    }

    /**
     * Set the value of medicament_id
     *
     * @return  self
     */ 
    public function setMedicament_id($medicament_id)
    {
        $this->medicament_id = $medicament_id;

        return $this;
    }

    /**
     * Get the value of posologie
     */ 
    public function getPosologie()
    {
        return $this->posologie;
    }

    /**
     * Set the value of posologie
     *
     * @return  self
     */ 
    public function setPosologie($posologie)
    {
        $this->posologie = $posologie;

        return $this;
    }

    /**
     * Get the value of datedebut
     */ 
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set the value of datedebut
     *
     * @return  self
     */ 
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get the value of datefin
     */ 
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set the value of datefin
     *
     * @return  self
     */ 
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function validate(): array
    {
        $errors = [];
        if (empty($this->posologie)) {
            $errors['posologie'] = "La posologie est obligatoire";
        }
        if (empty($this->datedebut)) {
            $errors['datedebut'] = "La date de début est obligatoire";
        }
        if (empty($this->datefin)) {
            $errors['datefin'] = "La date de fin est obligatoire";
        }
        return $errors;
    }
}