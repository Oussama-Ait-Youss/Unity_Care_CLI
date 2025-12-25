<?php


abstract class Person extends BaseModel {
    
    protected string $nom;
    protected string $prenom;
    protected string $telephone;
    protected string $email;

    public function __construct(string $nom, string $prenom, string $email, string $telephone) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
    }

    
    public function getNom(): string {
        return $this->nom;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getTelephone(): string {
        return $this->telephone;
    }


    public function setNom(string $nom): void {
        $this->nom = $nom;
    }
    
    
}