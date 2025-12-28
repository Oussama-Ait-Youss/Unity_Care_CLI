<?php

// require_once "../config/Database.php";
require_once __DIR__ . '/../config/Database.php';



abstract class BaseModel
{
    protected PDO $conn;
    protected string $table;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
        $this->table = $this->getTableName();
    }

    abstract protected function getTableName(): string;
    abstract protected function fromArray($arr): object;
    abstract protected function toArray(): array;


    // ---------- CRUD ----------------
    public function getAll(): array
    {
        $qry = "SELECT * FROM $this->table";

        $stmt = $this->conn->prepare($qry);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr = [];
        foreach ($result as $key => $value) {
            $arr[] = $this->fromArray($value);
        }
        return $arr;
    }


    // select all
    public function findall()
    {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r($result);
    }

    // select by field
    public function getBy($column, $value)
    {

        $qry = "SELECT * FROM $this->table WHERE $column = $value";

        $stmt = $this->conn->prepare($qry);
        $stmt->execute();

        $result = $stmt->fetchAll();
        print_r($result);
    }



    // insertion
    public function insert($data)
    {
        $keys = array_keys($data);

        $columns = implode(", ", $keys);
        $values = implode(", ", array_fill(0, count($data), "?"));

        $qry = "INSERT INTO $this->table ($columns) values($values)";

        $stmt = $this->conn->prepare($qry);
        $stmt->execute(array_values($data));
    }

    // delete
    public function delete($id){
        $query = "DELETE FROM $this->table WHERE id = $id";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            # code...
            echo "delete succesfully..";
        }else{
            echo "delete error...";
        }
    }

   //update 
   public function update($data, $id)
    {
        $setParts = [];
        
        foreach (array_keys($data) as $column) {
            $setParts[] = "$column = ?";
        }
        
        $setClause = implode(", ", $setParts);

        $query = "UPDATE $this->table SET $setClause WHERE id = $id";

        $stmt = $this->conn->prepare($query);
        
        // Execute using just the values from the data array
        if ($stmt->execute(array_values($data))) {
            echo "update successfully..";
        } else {
            echo "update error...";
        }
    }
}
