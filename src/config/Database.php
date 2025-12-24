<?php

    // classe de Database pour cree la connexion a la base de donne
    class Database{
        // variable de connexion
        private $HOST;
        private $DB;
        private $USER;
        private $PASS;
        private $conn;

        // intialization des donnes de la connexion
        public function __construct($HOST,$DB,$USER,$PASS){
            $this->HOST = $HOST;
            $this->DB = $DB;
            $this->USER = $USER;
            $this->PASS = $PASS;
        }
        
        // creer la connexion
        public function Connect(){
            try{

                $this->conn = new PDO("mysql:host=$this->HOST;dbname=$this->DB",$this->USER,$this->PASS);

            }catch(PDOException $e){
                echo "Error de Connexion..." . $e->getMessage();
                exit;
            }
            return $this->conn;
        }
    }
