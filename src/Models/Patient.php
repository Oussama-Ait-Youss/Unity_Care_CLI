<?php

class Patient extends Person {

    protected function getTableName(): string {
        return "patients";
    }

    protected function fromArray($arr): object {
      
        $patient = new Patient(
            $this->conn,
            $arr['first_name'] ?? null,
            $arr['last_name'] ?? null,
            $arr['phone'] ?? null,
            $arr['email'] ?? null
        );

        if (isset($arr['id'])) {
            $patient->id = $arr['id'];
        }

        return $patient;
    }

    protected function toArray(): array {
        return [];
    }

    public function register($data) {
        return $this->insert($data);
    }
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