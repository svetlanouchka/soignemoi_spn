<?php

namespace App\Entity;

class Planning extends Entity
{
    protected ?int $id = null;
    protected int $medecin_id;
    protected \DateTime $date;
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

    public function getDate(): \DateTime
    {
        return $this->date;
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

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function setNombrePatients(int $nombre_patients): void
    {
        $this->nombre_patients = $nombre_patients;
    }
}
