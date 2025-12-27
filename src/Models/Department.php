<?php
require_once __DIR__ . "/BaseModel.php";

class Department extends BaseModel
{
    private string $name;

    public function __construct(PDO $db, $name = null)
    {
        parent::__construct($db);
        if ($name) {
            $this->name = $name;
        }
    }

    protected function getTableName(): string
    {
        return "departments";
    }

    // Convert database row to Department Object
    protected function fromArray($arr): object
    {
        $dept = new Department($this->conn);
        // We assume the DB has columns 'id' and 'name'
        // If your base model doesn't handle ID automatically in the object, 
        // you might need a public $id property in this class.
        if (isset($arr['name'])) {
            $dept->setName($arr['name']);
        }
        // If you want to store the ID in the object for display:
        // $dept->id = $arr['id']; 
        return $dept;
    }

    // Convert Object to Array for Insert/Update
    protected function toArray(): array
    {
        return [
            "name" => $this->name
        ];
    }

    // Business Logic Wrapper for Insert
    public function create($name)
    {
        $this->name = $name;
        // Use the BaseModel's insert method
        return $this->insert($this->toArray());
    }

    // Getters and Setters
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    public function __toString()
    {
        return sprintf("| %-20s |", $this->name);
    }
}