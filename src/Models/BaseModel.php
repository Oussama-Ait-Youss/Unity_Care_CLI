<?php


abstract class BaseModel {

    protected $db;
    protected $id = null;
    protected static $table;

    public function getId() {
        return $this->id;
    }

    public static function findAll() {
        $db = Database::getInstance()->getConnection();

        
        $table = static::$table;
        
        $stmt = $db->query("SELECT * FROM $table");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete() {
        if ($this->id === null) {
            return false;
        }
        
        $db = Database::getInstance()->getConnection();
        $table = static::$table;

        $stmt = $db->prepare("DELETE FROM $table WHERE id = :id");
        
        
        return $stmt->execute([':id' => $this->id]);
    }

    public static function findById($id) {
        $db = Database::getInstance()->getConnection();
        $table = static::$table;

        $stmt = $db->prepare("SELECT * FROM $table WHERE id = :id");
        
        $stmt->execute([':id' => $id]);
        
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        
        // Fetch single result
        $result = $stmt->fetch();

        return $result ?: null;
    }
    
    abstract public function save();
}