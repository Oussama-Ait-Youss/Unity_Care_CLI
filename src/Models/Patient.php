<?php

class Patient extends Person {

    protected function getTableName(): string {
        return "Patients";
    }

    protected function fromArray($arr): object {
        $patient = new Patient($this->conn);
        return $patient;
    }

    protected function toArray(): array {
        return [];
    }

    public function register($data) {
        return $this->insert($data);
    }
}