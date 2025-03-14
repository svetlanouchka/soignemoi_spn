<?php

namespace App\Entity;

require_once __DIR__ . '/Entity.php';

class User extends Entity
{
    protected ?int $id = null;
    protected ?string $email = '';
    protected ?string $password = '';
    protected ?string $prenom = '';
    protected ?string $nom = '';
    protected ?string $adress = ''; 
    protected ?string $role = '';

    protected ?int $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->id; // Utilisation de $id comme $user_id
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUserId(?int $user_id): self
    {
        $this->id = $user_id; // Utilisation de $id pour setter $user_id

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Set the value of role
     */
    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /*
        Pourrait être déplacé dans une classe UserValidator
    */
    public function validate(): array
    {
        $errors = [];
        if (empty($this->getPrenom())) {
            $errors['prenom'] = 'Le champ prénom ne doit pas être vide';
        }
        if (empty($this->getNom())) {
            $errors['nom'] = 'Le champ nom ne doit pas être vide';
        }
        if (empty($this->getEmail())) {
            $errors['email'] = 'Le champ email ne doit pas être vide';
        } else if (!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'L\'email n\'est pas valide';
        }
        if (empty($this->getPassword())) {
            $errors['password'] = 'Le champ mot de passe ne doit pas être vide';
        }
        return $errors;
    }

    /*
        Pourrait être déplacé dans une classe Security
    */
    public function verifyPassword(string $password): bool
    {
        if (password_verify($password, $this->password)) {
            return true;
        } else {
            return false;
        }
    }

    /*
        Pourrait être déplacé dans une classe Security
    */
    public static function isLogged(): bool
    {
        return isset($_SESSION['user']);
    }


    /*
        Pourrait être déplacé dans une classe Security
    */
    public static function isUser(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user';
    }

    /*
        Pourrait être déplacé dans une classe Security
    */
    public static function isAdmin(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    public static function isMedecin(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'medecin';
    }


    /*
        Pourrait être déplacé dans une classe Security
    */
    public static function getCurrentUserId(): int|bool
    {
        return (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) ? $_SESSION['user']['id']: false;
    }




    /**
     * Get the value of adress
     */ 
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set the value of adress
     *
     * @return  self
     */ 
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }
}