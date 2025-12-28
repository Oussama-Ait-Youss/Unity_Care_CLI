<?php

class Patient extends Person {

    protected function getTableName(): string {
        return "patients";
    }

    protected function fromArray($arr): object {
        // We create the object AND pass the data from the database array ($arr)
        // Ensure the array keys (like 'first_name') match your Database columns exactly!
        $patient = new Patient(
            $this->conn,
            $arr['first_name'] ?? null,
            $arr['last_name'] ?? null,
            $arr['phone'] ?? null,
            $arr['email'] ?? null
        );

        // Manually set the ID (since it's not in the constructor usually)
        if (isset($arr['id'])) {
            $patient->id = $arr['id'];
        }

        // Return the FILLED object, not an empty one
        return $patient;
    }

    protected function toArray(): array {
        return [];
    }

    public function register($data) {
        return $this->insert($data);
    }
    // Ajoutez ceci à la fin de votre classe Patient, avant l'accolade fermante "}"
    public function __toString()
    {
        return sprintf(
            "ID: %d | Nom: %s %s | Email: %s | Tel: %s",
            $this->id ?? 0,
            $this->first_name,
            $this->last_name,
            $this->email,
            $this->phone
        );
    }
}