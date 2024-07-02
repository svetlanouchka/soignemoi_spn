<?php

namespace App\Entity;

class Planning extends Entity
{
    protected ?int $id = null;
    protected int $medecin_id;

    protected int $sejour_id;
    
    protected \DateTime $date_i;
    protected int $nombre_patients = 0;

    // Getters and setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedecinId(): int
    {
        return $this->medecin_id;
    }

    public function getDate_i(): \DateTime
    {
        return $this->date_i;
    }

    public function getNombrePatients(): int
    {
        return $this->nombre_patients;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setMedecinId(int $medecin_id): void
    {
        $this->medecin_id = $medecin_id;
    }

    public function setDate_i(\DateTime $date_i): void
    {
        $this->date_i = $date_i;
    }

    public function setNombrePatients(int $nombre_patients): void
    {
        $this->nombre_patients = $nombre_patients;
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
}
