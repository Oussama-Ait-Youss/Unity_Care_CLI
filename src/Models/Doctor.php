<?php

require_once __DIR__ . "/Personne.php";

class Doctor extends Person
{
    private ?int $dept_id;
    private ?string $specialization;


    public function __construct(
        PDO $db,
        $first_name = null,
        $last_name = null,
        $phone = null,
        $email = null,
        $dept_id = null,
        $specialization = null,

    ) {

        parent::__construct(
            $db,
            $first_name,
            $last_name,
            $phone,
            $email,
        );
        $this->dept_id = (int)$dept_id;
        $this->specialization = $specialization;
    }

    protected function getTableName(): string
    {
        return "doctors";
    }


    public function getDeptID()
    {

        return $this->dept_id;
    }
    public function setDeptID($dept_id)
    {
        $this->dept_id = $dept_id;
    }
    public function setSpecialization($spec)
    {

        $this->specialization = $spec;
    }
    public function getSpecialization(): string
    {
        return $this->specialization;
    }

    public function fromArray($arr): object
    {

        $doctor = new Doctor(
            Database::getConnection(),
            $arr["first_name"],
            $arr["last_name"],
            $arr["phone"],
            $arr["email"],
            $arr["speciality"],
            (int)$arr["department_id"]
        );
        return $doctor;
    }
    public function toArray(): array
    {

        $arr =
            [
                "first_name" => $this->first_name,
                "last_name" => $this->last_name,
                "phone" => $this->phone,
                "email" => $this->email,
                "speciality" => $this->specialization,
                "department_id" => $this->dept_id
            ];
        return $arr;
    }

    public function __toString()
    {
        return "First Name: $this->first_name | Last Name: $this->last_name | Email: $this->email ";
    }
}
