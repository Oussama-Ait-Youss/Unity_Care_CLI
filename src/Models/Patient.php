<?php

class Patient extends Person {

    protected static $table = 'patients';

  
    public function save() {
        $db = Database::getInstance()->getConnection();

        
        $sql = "INSERT INTO " . self::$table . " 
                (first_name, last_name, email, phone, birth_date, address) 
                VALUES 
                (:prenom, :nom, :email, :telephone, :date_naissance, :adresse)";
        
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':prenom'         => $this->prenom,
            ':nom'            => $this->nom,
            ':email'          => $this->email,
            ':telephone'      => $this->telephone,
            ':date_naissance' => $this->dateNaissance, 
            ':adresse'        => $this->adresse
        ]);
    }
}