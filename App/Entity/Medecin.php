<?php

namespace App\Entity;

class Medecin extends Entity
{
    protected ?int $id = null;
    protected string $nom;
    protected string $prenom;

    protected string $email;
    protected int $specialite_id;
    protected ?string $specialite_name = null;
    protected string $matricule; 

    public function __construct(
        string $nom = '',
        string $prenom = '',
        int $specialite_id = 0,
        string $matricule = ''
    ) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->specialite_id = $specialite_id;
        $this->matricule = $matricule;
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
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

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
    public function setSpecialite_id($specialite_id)
    {
        $this->specialite_id = $specialite_id;

        return $this;
    }

    /**
     * Get the value of matricule
     */ 
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set the value of matricule
     *
     * @return  self
     */ 
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getSpecialiteName(): ?string
    {
        return $this->specialite_name;
    }

    public function setSpecialiteName(?string $specialite_name): void
    {
        $this->specialite_name = $specialite_name;
    }
    public function getNomComplet(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function validate(): array
    {
        $errors = [];
        if (empty($this->getPrenom())) {
            $errors['prenom'] = 'Le champ prénom ne doit pas être vide';
        }
        if (empty($this->getNom())) {
            $errors['nom'] = 'Le champ nom ne doit pas être vide';
        }
        if (empty($this->getSpecialite_id())) {
            $errors['specialite_id'] = 'Le champ specialité ne doit pas être vide';
        } 
        if (empty($this->getMatricule())) {
            $errors['matricule'] = 'Le champ mot de passe ne doit pas être vide';
        }
        return $errors;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
} 