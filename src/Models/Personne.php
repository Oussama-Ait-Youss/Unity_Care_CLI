<?php
require_once __DIR__ . "/BaseModel.php";
abstract class Person extends BaseModel
{
    protected ?string $first_name;
    protected ?string $last_name;
    protected ?string $phone;
    protected ?string $email;


    public function __construct(
        PDO $db,
        $first_name = null,
        $last_name = null,
        $phone = null,
        $email = null,
    ) {

        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->phone = $phone;
        $this->email = $email;
        parent::__construct($db);
    }


    public function getFirstName(): string
    {

        return $this->first_name;
    }

    public function setFirstName($fname)
    {
        $this->first_name = $fname;
    }

    public function getLastName(): string
    {

        return $this->last_name;
    }

    public function setLastName($lname)
    {
        $this->last_name = $lname;
    }

    public function getPhone(): string
    {

        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {

        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}
