<?php
include 'settings.php';

class Database{

    public $conn;

    // Método para la conexión a la base de datos.

    /**
     * @return PDO|null
     */
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, USERNAME, PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "ERROR: Fallo en la connexión a la base de datos: " . $exception->getMessage();
        }

        return $this->conn;
    }
}